<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LegacyBuildSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $versions = DB::table('mod_versions')
            ->select([
                'mod_versions.id',
                'mods.identifier AS mod_identifier',
                'mod_versions.code AS mod_version',
                'mods.short AS short',
                'mc_version',
                'repository',
                'repository_branch',
                'commit',
                'sources',
                'released_at',
            ])
            ->join('mods', 'mods.id', '=', 'mod_versions.mod_id')
            ->whereNotNull('mod_versions.released_at')
            ->where(['mods.legacy' => true])
            ->get();

        DB::table('builds')->upsert($versions->map(fn($version) => [
            'nightly' => false,
            'repository' => $version->repository,
            'mod_identifier' => $version->mod_identifier,
            'mod_version' => $version->mod_version,
            'mc_version' => $version->mc_version,
            'ref_name' => $version->repository_branch,
            'commit' => $version->commit,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ])->jsonSerialize(), ['commit'], ['nightly', 'mc_version', 'mod_version', 'mod_identifier', 'repository', 'ref_name', 'updated_at']);

        DB::table('build_files')->upsert($versions->map(fn($version) => [
            'build_id' => DB::table('builds')->where(['commit' => $version->commit])->first('id')->id,
            'path' => 'builds/' . $version->short . '-' . $version->mc_version . '-' . $version->mod_version . '.jar',
            'type' => null,
            'sources' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ])->jsonSerialize(), ['path'], ['build_id', 'path', 'type', 'sources', 'updated_at']);
        DB::table('build_files')->upsert($versions->filter(fn($version) => $version->sources)->map(fn($version) => [
            'build_id' => DB::table('builds')->where(['commit' => $version->commit])->first('id')->id,
            'path' => 'builds/' . $version->short . '-' . $version->mc_version . '-' . $version->mod_version . '-sources.jar',
            'type' => null,
            'sources' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ])->jsonSerialize(), ['path'], ['build_id', 'path', 'type', 'sources', 'updated_at']);
    }
}
