<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BuildSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('builds')->delete();
        DB::statement("ALTER TABLE builds AUTO_INCREMENT = 1");

        $versions = DB::table('versions')
            ->select([
                'versions.id',
                'versions.code AS mod_version',
                'version_groups.code AS group',
                'mc_version',
                'branch',
                'sources',
                'released_at',
            ])
            ->join('version_groups', 'versions.group_id', '=', 'version_groups.id')
            ->whereNotNull('released_at')
            ->get();
        DB::table('builds')->insert($versions->map(fn($version) => [
            'nightly' => false,
            'mc_version' => $version->mc_version,
            'mod_version' => $version->mod_version,
            'version_id' => $version->id,
            'path' => 'builds/' . $version->group . '-' . $version->mc_version . '-' . $version->mod_version . '.jar',
            'source_path' => $version->sources ? 'builds/' . $version->group . '-' . $version->mc_version . '-' . $version->mod_version . '-sources.jar' : null,
            'ref_name' => $version->branch,
            'created_at' => $version->released_at,
        ])->jsonSerialize());
    }
}
