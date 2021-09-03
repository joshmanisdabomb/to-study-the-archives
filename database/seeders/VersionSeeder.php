<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class VersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('versions')->delete();
        DB::statement("ALTER TABLE versions AUTO_INCREMENT = 1");
        DB::table('version_groups')->delete();
        DB::statement("ALTER TABLE version_groups AUTO_INCREMENT = 1");

        DB::table('version_groups')->insert([
            [
                'name' => 'Loosely Connected Concepts (Fabric)',
                'code' => 'LooselyConnectedConcepts',
                'branch' => 'fabric',
                'sources' => true,
                'tags' => true,
                'order' => '100',
            ],
            [
                'name' => 'Loosely Connected Concepts (Forge)',
                'code' => 'LooselyConnectedConcepts',
                'branch' => 'lcc1.15.2forge',
                'sources' => false,
                'tags' => false,
                'order' => '200',
            ],
            [
                'name' => 'Aimless Agglomeration',
                'code' => 'AimlessAgglomeration',
                'branch' => 'aa1.12.2',
                'sources' => true,
                'tags' => false,
                'order' => '1000',
            ],
            [
                'name' => 'Yet Another Mod',
                'code' => 'YAM',
                'branch' => 'yam1.7.2',
                'sources' => false,
                'tags' => false,
                'order' => '2000',
            ],
        ]);

        //YAM Inserts
        DB::table('versions')->insert([
            [
                'mod_version' => 'Update 1',
                'mc_version' => '1.7.2',
                'code' => 'u1',
                'group_id' => 4,
                'title' => null,
                'order' => 0,
                'released_at' => Carbon::create(2015, 2, 15, 19, 9, 2, 'UTC'),
                'changelog' => 'First version uploaded, reports itself as Beta 1.3.'
            ],
            [
                'mod_version' => 'Update 1.1',
                'mc_version' => '1.7.2',
                'code' => 'u1.1',
                'group_id' => 4,
                'title' => null,
                'order' => 10,
                'released_at' => Carbon::create(2015, 2, 15, 21, 14, 56, 'UTC'),
                'changelog' => 'Removed Mars and Mercury dimensions, replaced with \'Asmia\' dimension(?)'
            ],
            [
                'mod_version' => 'Update 2',
                'mc_version' => '1.7.2',
                'code' => 'u2',
                'group_id' => 4,
                'title' => null,
                'order' => 100,
                'released_at' => Carbon::create(2015, 2, 16, 17, 34, 32, 'UTC'),
                'changelog' => 'Added the tick mob to the wasteland, changed sounds of Amplislimes, spawn group size of Psycho Pig decreased.'
            ],
            [
                'mod_version' => 'Update 3',
                'mc_version' => '1.7.2',
                'code' => 'u3',
                'group_id' => 4,
                'title' => null,
                'order' => 200,
                'released_at' => Carbon::create(2015, 2, 22, 19, 24, 51, 'UTC'),
                'changelog' => 'Changed nuke mechanics, wasteland spawn rate reduced, added psychomeat.'
            ],
            [
                'mod_version' => 'Update 3.1',
                'mc_version' => '1.7.2',
                'code' => 'u3.1',
                'group_id' => 4,
                'title' => null,
                'order' => 210,
                'released_at' => Carbon::create(2015, 2, 22, 20, 41, 01, 'UTC'),
                'changelog' => 'Reworked nuclear missile model, plans to add more missile strikes.'
            ],
            [
                'mod_version' => 'Update 4',
                'mc_version' => '1.7.2',
                'code' => 'u4',
                'group_id' => 4,
                'title' => null,
                'order' => 300,
                'released_at' => Carbon::create(2015, 2, 28, 11, 31, 57, 'UTC'),
                'changelog' => 'Pills almost work, Missile Launch Pads render properly with GUI, Oil Buckets.'
            ],
            [
                'mod_version' => 'Update 5',
                'mc_version' => '1.7.2',
                'code' => 'u5',
                'group_id' => 4,
                'title' => null,
                'order' => 400,
                'released_at' => Carbon::create(2015, 3, 1, 20, 32, 8, 'UTC'),
                'changelog' => 'Adding computer functionality, new parts including motherboard.'
            ],
            [
                'mod_version' => 'Update 6',
                'mc_version' => '1.7.2',
                'code' => 'u6',
                'group_id' => 4,
                'title' => null,
                'order' => 500,
                'released_at' => Carbon::create(2015, 3, 8, 10, 45, 50, 'UTC'),
                'changelog' => 'Updated graphics, hiatus on missiles and computers, new mobs in the works.'
            ],
            [
                'mod_version' => 'Update 7',
                'mc_version' => '1.7.2',
                'code' => 'u7',
                'group_id' => 4,
                'title' => null,
                'order' => 600,
                'released_at' => Carbon::create(2015, 3, 27, 7, 55, 17, 'UTC'),
                'changelog' => 'Added Aerstone with different subtypes, added Sparkling Dragon, added rope blocks.'
            ],
            [
                'mod_version' => 'Update 8',
                'mc_version' => '1.7.2',
                'code' => 'u8',
                'group_id' => 4,
                'title' => null,
                'order' => 700,
                'released_at' => Carbon::create(2015, 12, 19, 21, 10, 14, 'UTC'),
                'changelog' => 'Added more potion effects and pill effects, added luck stat, fixed infinite arrow bug with aerstone repeater.'
            ],
            [
                'mod_version' => 'Update 9',
                'mc_version' => '1.7.2',
                'code' => 'u9',
                'group_id' => 4,
                'title' => null,
                'order' => 800,
                'released_at' => Carbon::create(2015, 12, 22, 16, 44, 20, 'UTC'),
                'changelog' => 'Added 2 mobs and bloodwood to the wasteland, new light affinity biome WIP, fly swatter & poop harvester, nod to kyle, hellfire. poison spikes.'
            ],
            [
                'mod_version' => 'Update 9.1',
                'mc_version' => '1.7.2',
                'code' => 'u9.1',
                'group_id' => 4,
                'title' => null,
                'order' => 810,
                'released_at' => Carbon::create(2015, 12, 27, 18, 47, 50, 'UTC'),
                'changelog' => 'Quick nerf to hellfire.'
            ],
            [
                'mod_version' => 'Update 9.2',
                'mc_version' => '1.7.2',
                'code' => 'u9.2',
                'group_id' => 4,
                'title' => null,
                'order' => 820,
                'released_at' => Carbon::create(2015, 12, 27, 21, 57, 40, 'UTC'),
                'changelog' => 'Texture change to light leaves, classic sounds fixed.'
            ],
            [
                'mod_version' => 'Update 10',
                'mc_version' => '1.7.2',
                'code' => 'u10',
                'group_id' => 4,
                'title' => null,
                'order' => 900,
                'released_at' => Carbon::create(2016, 1, 10, 16, 44, 13, 'UTC'),
                'changelog' => 'Light aura now contains light stone right off the bat, custom saplings and leaves now work, mobs die and leave light shards in light aura.'
            ],
            [
                'mod_version' => 'Update 11',
                'mc_version' => '1.7.2',
                'code' => 'u11',
                'group_id' => 4,
                'title' => null,
                'order' => 1000,
                'released_at' => Carbon::create(2016, 1, 23, 17, 14, 16, 'UTC'),
                'changelog' => 'Light biomes no longer emit light due to lighting issues, different spawn eggs for different types of mobs (no longer limited to rainbow spawn eggs), work on winged creeper.'
            ],
            [
                'mod_version' => 'Update 11.1',
                'mc_version' => '1.7.2',
                'code' => 'u11.1',
                'group_id' => 4,
                'title' => null,
                'order' => 1010,
                'released_at' => Carbon::create(2016, 1, 23, 20, 19, 36, 'UTC'),
                'changelog' => 'Added aura conversion enum system.'
            ],
            [
                'mod_version' => 'Update 12',
                'mc_version' => '1.7.2',
                'code' => 'u12',
                'group_id' => 4,
                'title' => null,
                'order' => 1100,
                'released_at' => Carbon::create(2016, 1, 24, 17, 48, 48, 'UTC'),
                'changelog' => 'Added more light blocks. Changed some light block textures.'
            ]
        ]);

        //Aimless Agglomeration
        DB::table('versions')->insert([
            [
                'mod_version' => 'Pre-Alpha',
                'mc_version' => '1.10.2',
                'code' => 'prealpha',
                'group_id' => 3,
                'title' => null,
                'order' => 0,
                'released_at' => Carbon::create(2016, 10, 26, 22, 16, 51, '+0100'),
                'changelog' => 'Added a creative tab with a custom sort system, and a directional facing test block. Starting work on a spreader constructor, which will allow you to build spreaders that infect the world.'
            ],
            [
                'mod_version' => 'Alpha 0.1',
                'mc_version' => '1.10.2',
                'code' => 'a0.1',
                'group_id' => 3,
                'title' => null,
                'order' => 100,
                'released_at' => Carbon::create(2016, 11, 9, 14, 44, 42, '+0100'),
                'changelog' => 'Missile movement works, item and entity model for missiles.'
            ],
            [
                'mod_version' => 'Alpha 0.1.1',
                'mc_version' => '1.10.2',
                'code' => 'a0.1.1',
                'group_id' => 3,
                'title' => null,
                'order' => 110,
                'released_at' => Carbon::create(2016, 11, 19, 17, 51, 54, '+0100'),
                'changelog' => 'Missile polish, trying to add particle effects. Spreader blocks suspended, work begun on Billie Blocks. Changed upgrade system to card system, launch pad now renders further away, nuclear explosions less laggy, fire missile model and nuclear waste model added.'
            ],
            [
                'mod_version' => 'Alpha 0.2',
                'mc_version' => '1.12',
                'code' => 'a0.2',
                'group_id' => 3,
                'title' => null,
                'order' => 200,
                'released_at' => Carbon::create(2017, 7, 26, 4, 35, 20, '+0100'),
                'changelog' => 'My first successful port, for 1.12. Added pills and making custom models look nice in all situations.'
            ],
            [
                'mod_version' => 'Alpha 1.0.0',
                'mc_version' => '1.12',
                'code' => 'a1.0.0',
                'group_id' => 3,
                'title' => null,
                'order' => 1000,
                'released_at' => Carbon::create(2017, 7, 27, 3, 22, 02, '+0100'),
                'changelog' => 'Everything renders correctly apart from launch pad.'
            ],
            [
                'mod_version' => 'Alpha 1.0.1',
                'mc_version' => '1.12',
                'code' => 'a1.0.1',
                'group_id' => 3,
                'title' => null,
                'order' => 1010,
                'released_at' => Carbon::create(2017, 7, 27, 7, 47, 37, '+0100'),
                'changelog' => 'Added particles to modelled blocks and updated rotations in GUI.
No more modelling errors in logs.
Updated unrefined uranium texture.'
            ],
            [
                'mod_version' => 'Alpha 1.0.2',
                'mc_version' => '1.12',
                'code' => 'a1.0.2',
                'group_id' => 3,
                'title' => null,
                'order' => 1020,
                'released_at' => Carbon::create(2017, 7, 27, 10, 35, 33, '+0100'),
                'changelog' => 'Missile launch pad now has shift click support.
Client and server communicate so missile can be seen.
Missile renders on client.'
            ],
            [
                'mod_version' => 'Alpha 1.1.0',
                'mc_version' => '1.12',
                'code' => 'a1.1.0',
                'group_id' => 3,
                'title' => 'All These Little Things',
                'order' => 1100,
                'released_at' => Carbon::create(2017, 8, 2, 22, 21, 13, '+0100'),
                'changelog' => 'Added mud, quicksand, 2 types of hearts that render in-game, 3 types of heart consumables, crafting materials.
Added metadata sensitive block hardness, resistance, map colours, block sounds, harvest types and levels.
Added drop types and silk touch support.
Added enum support in favour of just knowing what the numbers mean.
Added shift click support for containers. They still need loads of work.'
            ],
            [
                'mod_version' => 'Alpha 1.1.1',
                'mc_version' => '1.12',
                'code' => 'a1.1.1',
                'group_id' => 3,
                'title' => null,
                'order' => 1110,
                'released_at' => Carbon::create(2017, 8, 2, 22, 26, 05, '+0100'),
                'changelog' => 'Quick language file fix.'
            ],
            [
                'mod_version' => 'Alpha 1.2',
                'mc_version' => '1.12',
                'code' => 'a1.2',
                'group_id' => 3,
                'title' => 'Connected Textures',
                'order' => 1200,
                'released_at' => Carbon::create(2017, 8, 31, 21, 30, 17, '+0100'),
                'changelog' => 'Overhauled sorting system, with categories, upper and lower sorting values.
Added different basic types of blocks, including connected texture blocks. (not finished yet)
Added pill effect GUI overlay and more pill effects work.
Starting work on rainbow dimension.'
            ],
            [
                'mod_version' => 'Alpha 1.3',
                'mc_version' => '1.12',
                'code' => 'a1.3',
                'group_id' => 3,
                'title' => 'Touch the Rainbow',
                'order' => 1300,
                'released_at' => Carbon::create(2017, 9, 11, 21, 49, 56, '+0100'),
                'changelog' => 'Currently in process of adding different rainbow dimension blocks.
Officially added the rainbow dimension and have working world gen.
Added spike blocks.
Changed unlocalized name formats.'
            ],
            [
                'mod_version' => 'Alpha 1.3.1',
                'mc_version' => '1.12',
                'code' => 'a1.3.1',
                'group_id' => 3,
                'title' => null,
                'order' => 1310,
                'released_at' => Carbon::create(2017, 9, 12, 21, 20, 7, '+0100'),
                'changelog' => 'Chocolate blocks given model and localised name.
Rainbow dimension has custom caves.'
            ],
            [
                'mod_version' => 'Alpha 1.3.2',
                'mc_version' => '1.12',
                'code' => 'a1.3.2',
                'group_id' => 3,
                'title' => null,
                'order' => 1320,
                'released_at' => Carbon::create(2017, 9, 12, 22, 15, 35, '+0100'),
                'changelog' => 'More reasonable gemstone ore generation.'
            ],
            [
                'mod_version' => 'Alpha 1.4',
                'mc_version' => '1.12',
                'code' => 'a1.4',
                'group_id' => 3,
                'title' => 'The Block Update',
                'order' => 1400,
                'released_at' => Carbon::create(2017, 9, 22, 16, 16, 3, '+0100'),
                'changelog' => 'Added illuminant tiles, scaffolding blocks, fortstone, candy canes, refined candy cane blocks, jelly.
Overhauled blockstates, block models and item models to forge\'s system, deleting 35+ model files.'
            ],
            [
                'mod_version' => 'Alpha 1.4.1',
                'mc_version' => '1.12',
                'code' => 'a1.4.1',
                'group_id' => 3,
                'title' => null,
                'order' => 1410,
                'released_at' => Carbon::create(2017, 9, 23, 2, 33, 31, '+0100'),
                'changelog' => 'Overhauled spreader textures and models. Saved about 3 MB of space!
Starting work on neon ore.'
            ],
            [
                'mod_version' => 'Alpha 1.5',
                'mc_version' => '1.12.2',
                'code' => 'a1.5',
                'group_id' => 3,
                'title' => 'New Meets Old',
                'order' => 1500,
                'released_at' => Carbon::create(2017, 10, 10, 14, 58, 8, '+0100'),
                'changelog' => 'Added gemstone and neon tools and armour, with recipes! The mod is starting to become more survival friendly.
Added rainbow core ore and lollipop stick.
Added classic grass, porkchops, and two sets of wool.
Started work on computing.'
            ],
            [
                'mod_version' => 'Alpha 1.6',
                'mc_version' => '1.12.2',
                'code' => 'a1.6',
                'group_id' => 3,
                'title' => 'Survival Spark',
                'order' => 1600,
                'released_at' => Carbon::create(2017, 10, 23, 23, 1, 7, '+0100'),
                'changelog' => 'Began work on the wasteland biome. Added cracked mud for the biome.
Added bounce pads and spring items.
Added computer cases and computer cables.
Added classic blocks, including classic saplings and leaves.
Multiplayer servers now run and should continue to run as well!
Using predicates instead of comparing one block state to another.
Added loads of crafting recipes!
Changed text colours of item tooltips.
Updated textures of neon equipment.'
            ],
            [
                'mod_version' => 'Alpha 1.6.1',
                'mc_version' => '1.12.2',
                'code' => 'a1.6.1',
                'group_id' => 3,
                'title' => null,
                'order' => 1610,
                'released_at' => Carbon::create(2017, 10, 25, 18, 30, 32, '+0100'),
                'changelog' => 'Fixed connected texture blocks, not touching them again for at least seven years.
Updated textures for fortstone and rainbow pads.'
            ],
        ]);

        //LCC Forge
        DB::table('versions')->insert([
            [
                'mod_version' => 'Pre-Alpha',
                'mc_version' => '1.13.2',
                'code' => 'prealpha',
                'group_id' => 2,
                'title' => null,
                'order' => 0,
                'released_at' => Carbon::create(2019, 2, 17, 20, 28, 13, 'UTC'),
                'changelog' => 'Pretty empty with nothing added.'
            ],
            [
                'mod_version' => 'Alpha 0.1',
                'mc_version' => '1.13.2',
                'code' => 'a0.1',
                'group_id' => 2,
                'title' => null,
                'order' => 100,
                'released_at' => Carbon::create(2019, 2, 18, 19, 4, 1, 'UTC'),
                'changelog' => 'Registers blocks, itemblocks and items.
Language file.
Textures, models and blockstates working!
Implemented all test blocks apart from connected.'
            ],
            [
                'mod_version' => 'Alpha 0.2',
                'mc_version' => '1.13.2',
                'code' => 'a0.2',
                'group_id' => 2,
                'title' => null,
                'order' => 200,
                'released_at' => Carbon::create(2019, 2, 19, 21, 20, 23, 'UTC'),
                'changelog' => 'Implemented creative tab.
Resources textured and modelled.
Added entity loading and a nuclear explosion entity.
Updated all textures to fit 1.14 style. Added enriched uranium resource.'
            ],
            [
                'mod_version' => 'Alpha 0.3',
                'mc_version' => '1.13.2',
                'code' => 'a0.3',
                'group_id' => 2,
                'title' => null,
                'order' => 300,
                'released_at' => Carbon::create(2019, 2, 20, 21, 34, 13, 'UTC'),
                'changelog' => 'Implemented nuclear explosion semi-functionality and optimisation.
Added nuclear debris and fire to nuclear main explosion.
Generating ores in the world.'
            ],
            [
                'mod_version' => 'Alpha 0.4',
                'mc_version' => '1.14.3',
                'code' => 'a0.4',
                'group_id' => 2,
                'title' => null,
                'order' => 400,
                'released_at' => Carbon::create(2019, 7, 20, 0, 12, 9, '+0100'),
                'changelog' => 'Initial refactoring for 1.14.3.
Added the gauntlet with arm rendering technology.
Added capability structure, added gauntlet functionality.
Added gauntlet UI overlay to show cooldowns and actions.
Added stun potion effect, not fully working yet.
Added gem modifiers to the gauntlet and implemented temporary hearts and structure for other hearts.
Added millions of item models for gem tools and armour.
Better way to sort and add empty space to item group.
Implemented heart items and containers. Sync heart data using packets and fixed heart using desync.'
            ],
            [
                'mod_version' => 'Alpha 0.5',
                'mc_version' => '1.14.4',
                'code' => 'a0.5',
                'group_id' => 2,
                'title' => null,
                'order' => 500,
                'released_at' => Carbon::create(2019, 8, 17, 1, 29, 29, '+0100'),
                'changelog' => 'Updated to 1.14.4 and a ton of refactoring!
Added survival crafting recipes and loot tables.
Complete renaming files to 1.14 naming conventions.
Adding survival-based block properties.
Small changes to nuclear explosion and fire.
Gauntlet functionality now plays nice on multiplayer.
Added nuclear explosion model (needs work)
Added particle effect packet handler ready for gauntlet client effects.
Added particle effects and sounds to gauntlet.
Finished connected texture blocks.
Welcome spreader blocks and spreader interface to the mod. Spreader interface now change the world\'s global capability.'
            ],
            [
                'mod_version' => 'Alpha 1.0',
                'mc_version' => '1.14.4',
                'code' => 'a1.0',
                'group_id' => 2,
                'title' => null,
                'order' => 1000,
                'released_at' => Carbon::create(2019, 10, 4, 2, 14, 37, '+0100'),
                'changelog' => 'Added basic multipart block interface, added cog dynamic model.
Added block networks for cogs and computers later.
Crying Obsidian test with respawning in different dimension.
Adding nostalgic items to the mod.
The glove finally fits.
Added the time rift, capable of nostalgic crafting.
Added road block and updated connected texture methods to support different states and block heights. Road blocks now speed up entities and boats.
Added bounce pads and updated working for multiplayer. Particles trigger in singleplayer. Code cleanup and spreader interface texture update.
Added hydrated soul sand and rewrote my tab sorting system from 3 years ago!'
            ],
            [
                'mod_version' => 'Beta 1.0',
                'mc_version' => '1.15.2',
                'code' => 'b1.0',
                'group_id' => 2,
                'title' => null,
                'order' => 2000,
                'released_at' => Carbon::create(2020, 5, 8, 12, 48, 31, '+0100'),
                'changelog' => 'Beginning creation of computers. Added digital storage items.
Adding the wasteland biome. Added oil to wasteland biome. Oil interactions with other liquids.
Adding atomic bomb shell.
Added rainbow dimension. Added rainbow dimension biomes, rainbow grasses, sparkling dirt, twilight stone, candy canes. Added small and large candy canes.
Added Rainbow Gate. Added Rainbow Portal block and fixed rendering issues with rainbow gate.
Working on channelite. Star plating block and tag and loot table updates.
Added flammable and vulnerable potion effects.
Stun now locks mouse movement.
Fix to double classic chest and hopper interaction.
Added loot table, lang, block state, item model, tag, advancement data generator.'
            ],
        ]);

        //LCC Forge
        DB::table('versions')->insert([
            [
                'mod_version' => '0.1.0',
                'mc_version' => '20w51a',
                'code' => '0.1.0',
                'group_id' => 1,
                'title' => null,
                'order' => 0,
                'released_at' => Carbon::create(2020, 12, 21, 1, 20, 11, 'UTC'),
                'changelog' => 'Added iron, crystal and temporary hearts.
Starting wasteland biome.
Added test blocks and cracked mud.
Test block 5 connected texture.
Added tools and armour real quick like.
Implementing roads made from cooled asphalt.
Soaking soul sand with fizzy bubbles.
Added arcane table block, block entity, container and screen.
Added bounce pads.
Gauntlet work.
To allow running in real environments: No longer use reflection for thing directories.
Time rift functionality and ruby recipes.'
            ],
            [
                'mod_version' => '0.1.1',
                'mc_version' => '20w51a',
                'code' => '0.1.1',
                'group_id' => 1,
                'title' => null,
                'order' => 10,
                'released_at' => Carbon::create(2020, 12, 22, 20, 9, 35, 'UTC'),
                'changelog' => 'Infrastructure for item rendering. Time rift rendering.
Added topaz geodes naturally spawning in some lava lakes.
Reworked gem system, rubies and diamonds tier 3, emerald and sapphire tier 2, amethyst and topaz tier 1.
Retextured amethyst equipment and topaz shards.
Time rift model.
Added topaz and reworked gems into tiers.'
            ],
            [
                'mod_version' => '0.1.2',
                'mc_version' => '20w51a',
                'code' => '0.1.2',
                'group_id' => 1,
                'title' => null,
                'order' => 20,
                'released_at' => Carbon::create(2020, 12, 24, 15, 20, 33, 'UTC'),
                'changelog' => 'Fixed topaz clusters not dropping crystals.
Added pumice and rhyolite to topaz geode casing.
Added textures and functionality to many classic blocks previously added.'
            ],
            [
                'mod_version' => '0.2.0',
                'mc_version' => '20w51a',
                'code' => '0.2.0',
                'group_id' => 1,
                'title' => null,
                'order' => 100,
                'released_at' => Carbon::create(2021, 1, 2, 4, 21, 19, 'UTC'),
                'changelog' => 'Internally modularised the modification using the MD5 protocol.
Added classic chest, nether reactor, crying obsidian.
Fixed topaz geode casing not generating enough topaz.'
            ],
            [
                'mod_version' => '0.2.1',
                'mc_version' => '20w51a',
                'code' => '0.2.1',
                'group_id' => 1,
                'title' => null,
                'order' => 110,
                'released_at' => Carbon::create(2021, 1, 3, 14, 35, 23, 'UTC'),
                'changelog' => 'Added classic foods and the quiver.
Fixed bug with spawning mixin for classic crying obsidian.
Time rift no longer instantly breaks.
Fixed language file and data generation issues.
Changed texture for rhyolite.'
            ],
            [
                'mod_version' => '0.2.2',
                'mc_version' => '20w51a',
                'code' => '0.2.2',
                'group_id' => 1,
                'title' => null,
                'order' => 120,
                'released_at' => Carbon::create(2021, 1, 8, 13, 18, 29, 'UTC'),
                'changelog' => 'Added cogs, classic leather armors and classic fish raw and cooked.
Fixed server crash with client packets such as bounce pad extensions.
Fixed furnace recipes for smelting items.'
            ],
            [
                'mod_version' => '0.3.0',
                'mc_version' => '20w51a',
                'code' => '0.3.0',
                'group_id' => 1,
                'title' => null,
                'order' => 200,
                'released_at' => Carbon::create(2021, 1, 13, 20, 30, 36, 'UTC'),
                'changelog' => 'Added refiner, power cables and solar panels.
Added heavy uranium.'
            ],
            [
                'mod_version' => '0.3.1',
                'mc_version' => '20w51a',
                'code' => '0.3.1',
                'group_id' => 1,
                'title' => null,
                'order' => 210,
                'released_at' => Carbon::create(2021, 1, 15, 0, 2, 42, 'UTC'),
                'changelog' => 'Fixed refiner numbers displaying incorrectly on multiplayer servers.
Quiver now stores picked up arrow items and projectiles.
Fixed space of bundle required by quiver.
Cogs now check if location is valid when surroundings change.
Cogs now drop correct amount of items when broken by the game.
Update to latest Fabric.'
            ],
            [
                'mod_version' => '0.3.2',
                'mc_version' => '21w03a',
                'code' => '0.3.2',
                'group_id' => 1,
                'title' => null,
                'order' => 220,
                'released_at' => Carbon::create(2021, 1, 25, 18, 8, 51, 'UTC'),
                'changelog' => 'Added furnace and combustion generators.
Added silicon for solar panel recipe and geothermal power.
Added energy bank and batteries for storing power.'
            ],
            [
                'mod_version' => '0.4.0',
                'mc_version' => '21w06a',
                'code' => '0.4.0',
                'group_id' => 1,
                'title' => null,
                'order' => 300,
                'released_at' => Carbon::create(2021, 2, 15, 13, 29, 2, 'UTC'),
                'changelog' => 'Added atomic bomb and radiation sickness.
Using nightly Cardinal Components.'
            ],
            [
                'mod_version' => '0.4.1',
                'mc_version' => '21w06a',
                'code' => '0.4.1',
                'group_id' => 1,
                'title' => null,
                'order' => 310,
                'released_at' => Carbon::create(2021, 2, 16, 21, 25, 52, 'UTC'),
                'changelog' => 'Atomic bomb particles.
Achievement for atomic bomb.
Radiation increase when within epicenter of atomic bomb.
Atomic bombs and nuclear explosions now load chunks.
Fix for server crash on radiation increase.'
            ],
            [
                'mod_version' => '0.4.2',
                'mc_version' => '21w08b',
                'code' => '0.4.2',
                'group_id' => 1,
                'title' => null,
                'order' => 320,
                'released_at' => Carbon::create(2021, 3, 5, 17, 16, 53, 'UTC'),
                'changelog' => 'Hazmat suit now blocks new status effects when oxygenated full set.
Hazmat helmet blocks eating food. Update to 21w08b and latest Kotlin.
Added oxygen tank and oxygen extractor. Hazmat suit recipes bar chestplate. LCC Base can display multiple bars for items.
Adding rubber wood, rubber tree blocks and treetap and latex gathering.
Migrated heart trackers to components. Ready to migrate from gauntlet trackers to components.
Rewriting gauntlet functionality for components, uppercut done - punch next.
Blocks, items and nullable blockitems now working with new directory system.
Race advancement for nuclear detonation. Fixed bug with nuclear explosion log not displaying name of player.'
            ],
            [
                'mod_version' => '0.4.3',
                'mc_version' => '21w11a',
                'code' => '0.4.3',
                'group_id' => 1,
                'title' => null,
                'order' => 330,
                'released_at' => Carbon::create(2021, 3, 29, 1, 30, 5, '+0100'),
                'changelog' => 'Added nuclear power generation and heavy uranium shielding to protect against nuclear explosions.
Added radiation and contained armour HUD elements.
Added graphics and tooltip to oxygen extractor.
Hazmat suits expend more oxygen when player is active and protects against more hazards.
Added kiln block for quicker smelting of non-blastables and non-smokables.
Added slabs and stairs for rhyolite and classic blocks.
Nerfed latex and solar power production.
Added custom heart type damage sounds and fixed custom heart type damage overlay.
Updated to 21w11a.'
            ],
            [
                'mod_version' => '0.4.4',
                'mc_version' => '21w14a',
                'code' => '0.4.4',
                'group_id' => 1,
                'title' => null,
                'order' => 340,
                'released_at' => Carbon::create(2021, 4, 29, 15, 37, 7, '+0100'),
                'changelog' => 'Added salt to gauge block temperatures and to throw at mobs and players.
Added tungsten ore in wasteland, raw tungsten item and block, tungsten ingot and block, cut tungsten, stairs and slabs.
Added radar and alarm.
Added radiation detector to detect nuclear winter level, nearby uranium and other radioactive sources.
Added rubber sign and rubber boat.
Added rubber block.
Nuclear generators now spawn nuclear waste below themselves that must be handled by the player.
Nuclear waste now piles up by horizontally sliding when landing.
Uranium ore now almost exclusively spawns exposed to air.
Added radiation and nuclear winter command.
Nuclear winters now spawn more mobs with effects per level, and causes weather issues.
Added advancements.
Fixed bug with radiation not healing and large amounts not carrying over to the next life.
Update to 21w14a.'
            ],
            [
                'mod_version' => '0.5.0',
                'mc_version' => '21w14a',
                'code' => '0.5.0',
                'group_id' => 1,
                'title' => null,
                'order' => 400,
                'released_at' => Carbon::create(2021, 8, 19, 13, 52, 40, '+0100'),
                'changelog' => 'Added sapphire altar block, structure, brick blocks with stair, slab and wall variants.
Added iron oxide nuggets used for making challenge keys.
Added dull sapphires exclusively for charging into regular sapphires.
Added structure rotation and mirror support for directional blocks.
Added altar challenge registry for loading challenges. Added minesweeper altar challenge. Added bomb board blocks.
Added crowbar that can stun on critical hits.
Deadwood logs now spawn in the wasteland.
Fixed oil spawning in exposed locations, now grouped in clusters scattered around the wasteland.
Added tent structures to wasteland with random loot.
Added shattered glass which crumbles under impact.
Spike traps now spawn in the wasteland barrens.
Landmines now spawn in the wasteland.
Added consumers that fire their tongues at entities.
Oil refining now provides tar for asphalt, refined oil buckets for plastic, and fuel for explosive paste (currently).
Products from distillation can also be stepped up with cracking recipes.
Plastic which gets vibrant colour from dyes in refining recipe, doesn\'t despawn.
Added plastic bag to store 128 items without despawning.
Can now define complex refining recipes.
Added rubber piston block and textures.
Added explosive paste which allows chain reaction explosions.
Fixed bug with custom recipes only giving one output for all recipes.
Added rusted iron blocks to wasteland. Added rusted iron bars.
Added polished fortstone with connected texture.
Added fortstone, cobbled fortstone and generation.
Separated wasteland spikes and barrens biomes.
Added baby skeleton entity.
Added wasp entity, renderer and model.
Added deposit blocks for wasteland.
Added wasteland spawn eggs for baby skeleton, wasp and consumer.
Split lcc-hooks into separate module.
Content datagen now launching and matches 0.4.4 datagen.'
            ],
        ]);
    }
}
