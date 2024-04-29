<?php

namespace App\Http\Controllers;

use App\Models\Build;
use App\Models\BuildFile;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BuildController extends Controller
{
    public function create(Request $request) {
        if ($request->post('key', '') !== env('API_KEY')) throw new AuthenticationException;
        $gradle = $request->file('gradle')->get();
        $lines = preg_split('/\r\n|\r|\n/', $gradle);
        foreach ($lines as $line) {
            if (str_starts_with($line, 'minecraft_version=')) {
                $mcver = substr($line, 18);
            } elseif (str_starts_with($line, 'mod_version=')) {
                $modver = substr($line, 12);
            } elseif (str_starts_with($line, 'mod_id=')) {
                $modid = substr($line, 7);
            }
        }

        $nightly = !str_starts_with($request->post('ref'), 'refs/tags/');
        Build::upsert([
            'nightly' => $nightly,
            'repository' => $request->post('repository'),
            'mod_identifier' => $modid ?? null,
            'mod_version' => $modver ?? null,
            'mc_version' => $mcver ?? null,
            'run_number' => (int)$request->post('run_number'),
            'ref_name' => $request->post('ref_name'),
            'commit' => $request->post('sha'),
        ], ['commit'], array_filter([$nightly ? 'nightly' : null, 'repository', 'mod_identifier', 'mod_version', 'mc_version', 'run_number', 'ref_name']));
        $build = Build::where(['commit' => $request->post('sha')])->with('files')->first();
        foreach ($build->files as $file) {
            Storage::disk()->delete($file->path);
        }
        $build->files()->delete();

        foreach (['build', 'forge', 'fabric', 'quilt', 'source'] as $type) {
            $file = $request->file($type);
            if (!$file) continue;

            $build->files()->create([
                'path' => $file->store('builds'),
                'type' => $type === 'build' || $type === 'source' ? null : $type,
                'sources' => $type === 'source',
            ]);
        }
        $build->load('files');

        return response()->json($build);
    }
}
