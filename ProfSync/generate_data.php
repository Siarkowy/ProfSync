<?php

/*------------------------------------------------------------------------------
-- ProfSync (c) 2013 by Siarkowy
-- Released under the terms of BSD 2-Clause license.
--------------------------------------------------------------------------------

This is the data generation script. It fetches guild roster from Armory and
loads profession data for every player. Usage from command line only:

    php generate_data.php > data.lua

*/

// guild name setting
$guild = 'your+guild+here'; // change all spaces to plus signs! ' ' -> '+'

// adjust armory URLs if needed (probably skip this)
$guildUrl = 'http://armory.hellground.net/guild-info.xml?r=HellGround&gn=' . $guild;
$charUrl = 'http://armory.hellground.net/character-sheet.xml?r=HellGround&n=';

// DO NOT TOUCH THE CODE BELOW /////////////////////////////////////////////////

$profabbr = array(
    'Alchemy'        => 'alch',
    'Blacksmithing'  => 'bs',
    'Engineering'    => 'engi',
    'Enchanting'     => 'ench',
    'Herbalism'      => 'herb',
    'Jewelcrafting'  => 'jc',
    'Leatherworking' => 'lw',
    'Mining'         => 'min',
    'Skinning'       => 'skin',
    'Tailoring'      => 'tail',
    null             => 'x',
);

$roster = file_get_contents($guildUrl);
preg_match_all('#character.*?name="(.*?)"#i', $roster, $match);

echo "ProfSyncDB = {\n";

foreach ($match[1] as $nick)
{
    $charData = file_get_contents($charUrl . $nick);
    preg_match_all('#skill.*?name="(.*?)"#i', $charData, $profs);
    sort($profs[1]);
    $prof1 = @$profabbr[$profs[1][0]] ? @$profabbr[$profs[1][0]] : 'x';
    $prof2 = @$profabbr[$profs[1][1]] ? @$profabbr[$profs[1][1]] : 'x';
    echo "\t{$nick} = \"{$prof1}/{$prof2}\",\n";
}

echo "}\n";
