<?php

namespace Tests\Feature;

use App\Models\BuildFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class BuildControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp() : void {
        parent::setUp();

        Storage::fake();
    }

    private function createRequest(array $properties, array $data, bool|null $expected = null): TestResponse {
        $propertiesStr = http_build_query($properties, '', "\n");

        $forge = UploadedFile::fake()->create('forge.jar', 1);
        $fabric = UploadedFile::fake()->create('fabric.jar', 1);
        $quilt = UploadedFile::fake()->create('quilt.jar', 1);
        $source = UploadedFile::fake()->create('sources.jar', 1);
        $gradle = UploadedFile::fake()->createWithContent('gradle.properties', $propertiesStr);

        $data += ['key' => env('API_KEY')] + compact('forge', 'fabric', 'quilt', 'source', 'gradle');
        $response = $this->post('/api/build/create', $data);

        if ($expected !== null) {
            $expected = [
                'id' => 1,
                'nightly' => $expected,
                'repository' => $data['repository'],
                'mod_identifier' => $properties['mod_id'],
                'mod_version' => $properties['mod_version'],
                'mc_version' => $properties['minecraft_version'],
                'run_number' => $data['run_number'],
                'ref_name' => $data['ref_name'],
                'commit' => $data['sha'],
                'files' => [
                    ['build_id' => 1, 'type' => 'forge', 'sources' => false],
                    ['build_id' => 1, 'type' => 'fabric', 'sources' => false],
                    ['build_id' => 1, 'type' => 'quilt', 'sources' => false],
                    ['build_id' => 1, 'type' => null, 'sources' => true],
                ],
            ];

            $response->assertStatus(200);
            $response->assertJson($expected);

            $this->assertDatabaseCount('builds', 1);
            $this->assertDatabaseHas('builds', array_diff_key($expected, array_flip(['files'])));
            $this->assertDatabaseCount('build_files', count($expected['files']));
            foreach ($expected['files'] as $file) {
                $this->assertDatabaseHas('build_files', $file);

                $bf = BuildFile::firstWhere($file);
                $this->assertTrue(Storage::exists($bf->path));

                $var = $bf->sources ? 'source' : $bf->type;
                $this->assertSame(Storage::get($bf->path), $$var->get());
            }
        }

        return $response;
    }

    public function test_build_nightly(): void
    {
        $this->createRequest([
            'minecraft_version' => '1.20.4',
            'mod_id' => 'to_base',
            'mod_version' => '0.1.0'
        ], [
            'repository' => 'joshmanisdabomb/to-lay-the-foundations',
            'run_id' => 48,
            'run_number' => 38,
            'ref' => 'refs/heads/fabric',
            'ref_name' => 'fabric',
            'sha' => '07ec46b35962fee77f4c69f7a2f2d9a6bffb10a8',
        ], true);
    }

    public function test_build_version(): void
    {
        $this->createRequest([
            'minecraft_version' => '1.20.4',
            'mod_id' => 'to_stars',
            'mod_version' => '1.1.5'
        ], [
            'repository' => 'joshmanisdabomb/to-sky-and-stars',
            'run_id' => 12,
            'run_number' => 12,
            'ref' => 'refs/tags/fabric-1.1.5',
            'ref_name' => 'fabric-1.1.5',
            'sha' => '1234567890abcdef1234567890abcdef12345678',
        ], false);
    }

    public function test_build_version_after_nightly(): void
    {
        $properties = [
            'minecraft_version' => '1.21',
            'mod_id' => 'to_market',
            'mod_version' => '2.0.0'
        ];
        $data = [
            'repository' => 'joshmanisdabomb/to-market-to-market',
            'sha' => '1111111111111111111111111111111111111111',
        ];

        $this->createRequest($properties, $data + [
            'run_id' => 154,
            'run_number' => 158,
            'ref' => 'refs/heads/main',
            'ref_name' => 'main',
        ], true);

        $this->createRequest($properties, $data + [
            'run_id' => 155,
            'run_number' => 159,
            'ref' => 'refs/tags/2.0.0',
            'ref_name' => '2.0.0',
        ], false);

        $this->createRequest($properties, $data + [
            'run_id' => 156,
            'run_number' => 160,
            'ref' => 'refs/heads/main',
            'ref_name' => 'main'
        ], false);
    }
}
