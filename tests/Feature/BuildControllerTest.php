<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BuildControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp() : void {
        parent::setUp();

        Storage::fake();
    }

    public function test_build_nightly(): void
    {
        $properties = [
            'minecraft_version' => '1.20.4',
            'mod_id' => 'to_base',
            'mod_version' => '0.1.0'
        ];
        $propertiesStr = http_build_query($properties, '', "\n");

        $forge = UploadedFile::fake()->create('forge.jar', 1);
        $fabric = UploadedFile::fake()->create('fabric.jar', 1);
        $quilt = UploadedFile::fake()->create('quilt.jar', 1);
        $source = UploadedFile::fake()->create('sources.jar', 1);
        $gradle = UploadedFile::fake()->createWithContent('gradle.properties', $propertiesStr);

        $data = [
            'key' => env('API_KEY'),
            'repository' => 'joshmanisdabomb/to-lay-the-foundations',
            'run_id' => 48,
            'run_number' => 38,
            'ref' => 'refs/heads/fabric',
            'ref_name' => 'fabric',
            'sha' => '07ec46b35962fee77f4c69f7a2f2d9a6bffb10a8',
        ];
        $expected = [
            'id' => 1,
            'nightly' => true,
            'repository' => $data['repository'],
            'mod_identifier' => $properties['mod_id'],
            'mod_version' => $properties['mod_version'],
            'mc_version' => $properties['minecraft_version'],
            'run_number' => $data['run_number'],
            'ref_name' => $data['ref_name'],
            'commit' => $data['sha'],
            'files' => [
                [
                    'build_id' => 1,
                    'type' => 'forge',
                    'sources' => false,
                ],
                [
                    'build_id' => 1,
                    'type' => 'fabric',
                    'sources' => false,
                ],
                [
                    'build_id' => 1,
                    'type' => 'quilt',
                    'sources' => false,
                ],
                [
                    'build_id' => 1,
                    'type' => null,
                    'sources' => true,
                ],
            ],
        ];

        $response = $this->post('/api/build/create', compact('forge', 'fabric', 'quilt', 'source', 'gradle') + $data);

        $response->assertStatus(200);
        $response->assertJson($expected);

        $files = $expected['files'];
        unset($expected['files']);
        $this->assertDatabaseHas('builds', $expected);
        foreach ($files as $file) {
            $this->assertDatabaseHas('build_files', $file);
        }
    }

    public function test_build_version(): void
    {
        $properties = [
            'minecraft_version' => '1.20.4',
            'mod_id' => 'to_stars',
            'mod_version' => '1.1.5'
        ];
        $propertiesStr = http_build_query($properties, '', "\n");

        $forge = UploadedFile::fake()->create('forge.jar', 1);
        $fabric = UploadedFile::fake()->create('fabric.jar', 1);
        $quilt = UploadedFile::fake()->create('quilt.jar', 1);
        $source = UploadedFile::fake()->create('sources.jar', 1);
        $gradle = UploadedFile::fake()->createWithContent('gradle.properties', $propertiesStr);

        $data = [
            'key' => env('API_KEY'),
            'repository' => 'joshmanisdabomb/to-sky-and-stars',
            'run_id' => 12,
            'run_number' => 12,
            'ref' => 'refs/tags/fabric-1.1.5',
            'ref_name' => 'fabric-1.1.5',
            'sha' => '1234567890abcdef1234567890abcdef12345678',
        ];
        $expected = [
            'id' => 1,
            'nightly' => false,
            'repository' => $data['repository'],
            'mod_identifier' => $properties['mod_id'],
            'mod_version' => $properties['mod_version'],
            'mc_version' => $properties['minecraft_version'],
            'run_number' => $data['run_number'],
            'ref_name' => $data['ref_name'],
            'commit' => $data['sha'],
            'files' => [
                [
                    'build_id' => 1,
                    'type' => 'forge',
                    'sources' => false,
                ],
                [
                    'build_id' => 1,
                    'type' => 'fabric',
                    'sources' => false,
                ],
                [
                    'build_id' => 1,
                    'type' => 'quilt',
                    'sources' => false,
                ],
                [
                    'build_id' => 1,
                    'type' => null,
                    'sources' => true,
                ],
            ],
        ];

        $response = $this->post('/api/build/create', compact('forge', 'fabric', 'quilt', 'source', 'gradle') + $data);

        $response->assertStatus(200);
        $response->assertJson($expected);

        $files = $expected['files'];
        unset($expected['files']);
        $this->assertDatabaseHas('builds', $expected);
        foreach ($files as $file) {
            $this->assertDatabaseHas('build_files', $file);
        }
    }
}
