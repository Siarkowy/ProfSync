--------------------------------------------------------------------------------
-- ProfSync (c) 2013 by Siarkowy
-- Released under the terms of BSD 2-Clause license.
--------------------------------------------------------------------------------

local Sync = CreateFrame("Frame", "ProfSync")
Sync:SetScript("OnEvent", function(self, event, ...) self[event](self, ...) end)
Sync:RegisterEvent("ADDON_LOADED")

function Sync:ADDON_LOADED()
    self.db = ProfSyncDB or {}
end

function Sync:GUILD_ROSTER_UPDATE()
    for i = 1, GetNumGuildMembers() do
        -- get current data
        local n, _, _, _, _, _, pn = GetGuildRosterInfo(i)
        local sp = pn:match("%b[]") -- spec
        local pr = pn:match("%b()") -- profession

        -- new profession
        local npr = self.db[n] or pr
        if npr then
            npr = format("(%s)", npr)
        end

        -- new player note
        local npn = pn:gsub("%b[]", ""):gsub("%b()", ""):trim()
        npn = format("%s%s %s", sp or "", npr or "", npn):trim()

        -- update player note
        if pn ~= npn then
            printf("%s: %q -> %q", n, pn, npn)
            GuildRosterSetPublicNote(i, npn)
            return
        end
    end

    self:Disable()
end

function Sync:Enable()
    self:RegisterEvent("GUILD_ROSTER_UPDATE")
    self:GUILD_ROSTER_UPDATE()
end

function Sync:Disable()
    self:UnregisterEvent("GUILD_ROSTER_UPDATE")
end
