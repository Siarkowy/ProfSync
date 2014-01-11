ProfSync
========

Synchronizes profession data in public notes with Armory. [Wow 2.4.3]

ProfSync (c) 2013 by Siarkowy. Released under the terms of BSD 2-Clause license.

Caution
-------

Profession data in player notes will be stored between parentheses: `(pr/pr)`.
Existing profession data will be overwritten by the data supplied by script.
Everything outside of parentheses will be appended to new profession data.
There is special handling for specialization data `[spec]`, which will be
prepended before new note: `[spec](pr/pr) everything else`.

Usage
-----

1. Configure `generate_data.php` script (set guild name there).
2. Run data generation script: `php generate_data.php > data.lua`
3. (Re)start WoW client.
4. Type in-game: `/run ProfSync:Enable()`
5. Log out and disable addon completely after notes are updated.
