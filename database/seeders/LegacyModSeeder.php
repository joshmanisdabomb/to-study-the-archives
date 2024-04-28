<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LegacyModSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mods')->upsert([
            [
                'name' => 'Loosely Connected Concepts (Fabric)',
                'short' => 'LooselyConnectedConcepts',
                'identifier' => 'lcc',
                'legacy' => true,
                'repository' => 'joshmanisdabomb/loosely-connected-concepts',
                'repository_branch' => 'fabric',
                'sources' => true,
                'tags' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Loosely Connected Concepts (Forge)',
                'short' => 'LooselyConnectedConcepts',
                'identifier' => 'lcc_forge',
                'legacy' => true,
                'repository' => 'joshmanisdabomb/loosely-connected-concepts',
                'repository_branch' => 'lcc1.15.2forge',
                'sources' => false,
                'tags' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Aimless Agglomeration',
                'short' => 'AimlessAgglomeration',
                'identifier' => 'aimagg',
                'legacy' => true,
                'repository' => 'joshmanisdabomb/loosely-connected-concepts',
                'repository_branch' => 'aa1.12.2',
                'sources' => true,
                'tags' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Yet Another Mod',
                'short' => 'YAM',
                'identifier' => 'yam',
                'legacy' => true,
                'repository' => 'joshmanisdabomb/loosely-connected-concepts',
                'repository_branch' => 'yam1.7.2',
                'sources' => false,
                'tags' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ], ['identifier'], ['name', 'short', 'legacy', 'repository', 'repository_branch', 'sources', 'tags', 'updated_at']);
    }
}
