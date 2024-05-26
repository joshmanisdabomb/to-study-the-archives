<?php

namespace Tests\Feature;

use App\Models\Build;
use App\Models\BuildFile;
use App\Models\ContentUpdate;
use App\Models\ModVersion;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\AssertableJsonString;
use Illuminate\Testing\TestResponse;
use RuntimeException;
use Tests\TestCase;
use ZipArchive;

class ContentControllerTest extends TestCase
{
    use RefreshDatabase;

    public const DEFAULT_BODY = [
        'mod' => ['id' => 'to_base', 'version' => '0.4.0'],
        'mc' => ['id' => 'minecraft', 'version' => '1.20.4'],
    ];

    public const DEFAULT_META = [
        'mods' => [
            'to_base' => [
                'name' => 'To Lay the Foundations',
                'short' => 'ToLTF',
                'legacy' => false,
                'repository' => 'joshmanisdabomb/to-lay-the-foundations',
                'repository_branch' => 'main',
                'tags' => true,
                'sources' => true,
                'modrinth' => true,
                'curseforge' => true,
                'versions' => [
                    '0.1.0' => [
                        'mc_version' => '1.20.4',
                        'commit' => '91744ad6',
                        'title' => null,
                        'changelog' => 'First version released.',
                        'released_at' => '2024-04-28T22:48:33.000000Z',
                    ],
                    '0.2.0' => [
                        'mc_version' => '1.20.4',
                        'commit' => 'baad1dee',
                        'changelog' => 'Fabric data generation.',
                        'released_at' => '2024-05-03T00:45:18.000000Z',
                    ],
                ],
            ],
            'to_dream' => [
                'name' => 'To Dream of Distant Worlds',
                'short' => 'ToDODW',
                'legacy' => false,
                'repository' => 'joshmanisdabomb/to-dream-of-distant-worlds',
                'repository_branch' => 'main',
                'tags' => true,
                'sources' => true,
                'modrinth' => true,
                'curseforge' => true,
                'versions' => [
                    '1.0.0' => [
                        'mc_version' => '1.20.5',
                        'commit' => 'ff7af85f',
                        'changelog' => 'Added everything missing.',
                        'title' => 'Wasteland Woes',
                        'released_at' => '2026-05-26T01:13:51.000000Z',
                    ],
                ],
            ],
            'lcc' => [
                'name' => 'Loosely Connected Concepts (Fabric)',
                'short' => 'LooselyConnectedConcepts',
                'legacy' => true,
                'repository' => 'joshmanisdabomb/loosely-connected-concepts',
                'repository_branch' => 'fabric',
                'tags' => true,
                'sources' => true,
                'modrinth' => false,
                'curseforge' => false,
                'versions' => [
                    '0.5.2' => [
                        'mc_version' => '1.19.2',
                        'changelog' => 'Added heart condenser.',
                        'released_at' => null,
                    ],
                    '0.5.1' => [
                        'mc_version' => '1.19.2',
                        'commit' => '2c3af4ae844662a69dbcd78de397af83ba3f8e5a',
                        'changelog' => 'Updated to 1.19.2',
                        'released_at' => '2022-10-09T12:50:40.000000Z',
                    ],
                    '0.5.0' => [
                        'mc_version' => '21w14a',
                        'commit' => '36b860424b6eb4c636866382f341b3794f99d76b',
                        'changelog' => 'Added sapphire altar block.',
                        'released_at' => '2021-08-19T13:52:40.000000Z',
                    ],
                ],
            ],
        ],
        'builds' => [
            '2c3af4ae844662a69dbcd78de397af83ba3f8e5a' => [
                'repository' => 'joshmanisdabomb/loosely-connected-concepts',
                'mod_identifier' => 'lcc',
                'mod_version' => '0.5.1',
                'mc_version' => '1.19.2',
                'ref_name' => 'fabric',
                'released_at' => '2022-10-09T12:50:40.000000Z',
                'files' => [
                    [
                        'path' => 'builds/LooselyConnectedConcepts-1.19.2-0.5.1.jar',
                        'type' => null,
                        'sources' => false,
                    ],
                    [
                        'path' => 'builds/LooselyConnectedConcepts-1.19.2-0.5.1-sources.jar',
                        'type' => null,
                        'sources' => true,
                    ],
                ],
            ],
            '36b860424b6eb4c636866382f341b3794f99d76b' => [
                'repository' => 'joshmanisdabomb/loosely-connected-concepts',
                'mod_identifier' => 'lcc',
                'mod_version' => '0.5.0',
                'mc_version' => '21w14a',
                'ref_name' => 'fabric',
                'released_at' => '2021-08-19T13:52:40.000000Z',
            ],
            'd511299d953ad1703abb41e382730b78359a30d4' => [
                'repository' => 'joshmanisdabomb/loosely-connected-concepts',
                'ref_name' => 'yam1.7.2',
                'mod_identifier' => 'yam',
                'mod_version' => 'u12',
                'mc_version' => '1.7.2',
                'released_at' => '2016-01-24T17:48:48.000000Z',
                'files' => [
                    [
                        'path' => 'builds/YAM-1.7.2-u12.jar',
                        'type' => null,
                        'sources' => false,
                    ],
                ],
            ],
        ],
    ];

    protected function setUp() : void {
        parent::setUp();
        $this->withoutExceptionHandling();

        Storage::fake();
    }

    private function createRequest(?array $body = self::DEFAULT_BODY, ?array $meta = null, ?array $content = null, ?array $images = null): TestResponse {
        if ($body) {
            $body += ['key' => env('API_KEY')];
        }
        foreach (['body', 'meta'] as $var) {
            if ($$var !== null) $$var = json_encode($$var);
        }
        foreach (['content', 'images'] as $var) {
            if ($$var !== null) {
                $tempfile = tmpfile();
                if (!$tempfile) {
                    throw new RuntimeException('File could not be created.');
                }
                $path = stream_get_meta_data($tempfile)['uri'];
                fclose($tempfile);

                $zip = new ZipArchive();
                $zip->open($path, ZipArchive::CREATE);
                foreach ($$var as $name => $item) {
                    $zip->addFromString($name, json_encode($item));
                }
                $zip->close();

                $$var = UploadedFile::fake()->createWithContent($var . '.zip', file_get_contents($path));
            }
        }

        $data = compact('body', 'meta', 'content', 'images');
        $response = $this->post('/api/content/update', $data);

        return $response;
    }

    public function test_content(): void
    {
        $response = $this->createRequest(content: $input = [
            'to_base/test.json' => [
                'pages' => [
                    'to_base' => [
                        'name' => [
                            'text' => 'Test Page',
                            'extra' => ['abc'],
                        ],
                        'flavor' => 'Simple test page.',
                        "header" => [
                            "identifier" => 'to_base:wasteland_header_image',
                            "registry" => 'to_base:image',
                        ],
                        'content' => [
                            'en_us' => [
                                'tyoe' => 'compound',
                                'fragments' => [
                                    [
                                        'type' => 'text',
                                        'component' => 'This is '
                                    ],
                                    [
                                        'type' => 'text',
                                        'component' => 'good',
                                        'refer' => [
                                            'identifier' => 'minecraft:diamond_block',
                                            'registry' => 'minecraft:block',
                                        ],
                                    ],
                                    [
                                        'type' => 'text',
                                        'component' => '.'
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $response->assertStatus(200);
        $response->assertJson($expected = [
            'id' => 1,
            'body' => self::DEFAULT_BODY,
            'meta' => null,
            'images' => null,
            'articles' => [
                [
                    'id' => 1,
                    'content_id' => 1,
                    'namespace' => 'to_base',
                    'identifier' => 'test',
                    'data' => $input['to_base/test.json'],
                ]
            ],
            'mod_identifier' => self::DEFAULT_BODY['mod']['id'],
            'mod_version' => self::DEFAULT_BODY['mod']['version'],
            'mc_version' => self::DEFAULT_BODY['mc']['version'],
        ]);

        $path = $response->json('content');
        $this->assertTrue(Storage::exists($path));

        $zip = new ZipArchive();
        $zip->open(Storage::path($path), ZipArchive::RDONLY);
        $json = $zip->getFromName('to_base/test.json');
        $this->assertIsString($json);
        $this->assertJson($json);
        (new AssertableJsonString($json))->assertSubset($input['to_base/test.json']);
        $zip->close();

        $this->assertDatabaseCount('content_updates', 1);
        $expected['body'] = json_encode($expected['body']);
        $this->assertDatabaseHas('content_updates', array_diff_key($expected, array_flip(['articles'])));
        $this->assertDatabaseCount('articles', count($expected['articles']));
        foreach ($expected['articles'] as $article) {
            $article['data'] = json_encode($article['data']);
            $this->assertDatabaseHas('articles', $article);
        }
    }

    public function test_meta_create(): void
    {
        $response = $this->createRequest(meta: self::DEFAULT_META);

        $response->assertStatus(200);
        $response->assertJson($expected = [
            'id' => 1,
            'body' => self::DEFAULT_BODY,
            'meta' => self::DEFAULT_META,
            'mods' => array_values(array_map(fn (array $mod) => array_diff_key($mod, array_flip(['versions'])), self::DEFAULT_META['mods'])),
            'versions' => collect(self::DEFAULT_META['mods'])->pluck('versions')->flatten(1)->filter()->values()->toArray(),
            'builds' => array_values(array_map(fn (array $mod) => array_diff_key($mod, array_flip(['files'])), self::DEFAULT_META['builds'])),
            'files' => collect(self::DEFAULT_META['builds'])->pluck('files')->flatten(1)->filter()->values()->toArray(),
            'content' => null,
            'images' => null,
            'mod_identifier' => self::DEFAULT_BODY['mod']['id'],
            'mod_version' => self::DEFAULT_BODY['mod']['version'],
            'mc_version' => self::DEFAULT_BODY['mc']['version'],
        ]);

        $this->assertDatabaseCount('content_updates', 1);
        $this->assertDatabaseHas('content_updates', array_diff_key($expected, array_flip(['body', 'meta', 'mods', 'versions', 'builds', 'files'])));
        $this->assertDatabaseCount('mods', count($expected['mods']));
        foreach ($expected['mods'] as $mod) {
            $this->assertDatabaseHas('mods', $mod);
        }
        $this->assertDatabaseCount('mod_versions', count($expected['versions']));
        foreach ($expected['versions'] as $version) {
            if ($version['released_at']) {
                $version['released_at'] = Carbon::parse($version['released_at'])->toDateTimeString();
            }
            $this->assertDatabaseHas('mod_versions', $version);
        }
        $this->assertDatabaseCount('builds', count($expected['builds']));
        foreach ($expected['builds'] as $build) {
            if ($build['released_at']) {
                $build['released_at'] = Carbon::parse($build['released_at'])->toDateTimeString();
            }
            $this->assertDatabaseHas('builds', $build);
        }
        $this->assertDatabaseCount('build_files', count($expected['files']));
        foreach ($expected['files'] as $file) {
            $this->assertDatabaseHas('build_files', array_diff_key($file, ['released_at']));
        }
    }

    public function test_meta_update(): void
    {
        $create = $this->createRequest(meta: self::DEFAULT_META);
        $create->assertStatus(200);

        $input = self::DEFAULT_META;
        unset($input['mods']['to_base']);
        $input['mods']['to_dream'] = false;
        $input['mods']['to_stars'] = false;
        $input['mods']['lcc']['name'] = 'Loosely Connected Concepts';
        $input['mods']['lcc']['versions'][2] = false;
        $input['mods']['lcc_forge'] = $input['mods']['lcc'];
        $input['mods']['lcc_forge']['name'] = 'Loosely Connected Concepts (Forge)';
        $input['mods']['lcc_forge']['versions'] = [
            'a0.1' => [
                'name' => 'Alpha 0.1',
                'mc_version' => '1.13.2',
                'title' => null,
                'commit' => '29eead077eaf7d7dcaf8354afdf588ccf001a8d2',
                'released_at' => '2019-02-18T19:04:01.000000Z',
                'changelog' => '',
            ]
        ];
        unset($input['builds']['d511299d953ad1703abb41e382730b78359a30d4']);
        $input['builds']['36b860424b6eb4c636866382f341b3794f99d76b'] = false;
        $input['builds']['2c3af4ae844662a69dbcd78de397af83ba3f8e5a']['mod_identifier'] = 'lcc_forge';
        $input['builds']['2c3af4ae844662a69dbcd78de397af83ba3f8e5a']['mod_version'] = 'a0.1';
        $input['builds']['2c3af4ae844662a69dbcd78de397af83ba3f8e5a']['files'][0]['type'] = 'forge';
        $input['builds']['2c3af4ae844662a69dbcd78de397af83ba3f8e5a']['files'][0]['path'] = 'builds/LooselyConnectedConcepts-1.13.2-a0.1.jar';
        unset($input['builds']['2c3af4ae844662a69dbcd78de397af83ba3f8e5a']['files'][1]);

        $response = $this->createRequest(meta: $input);
        $response->assertStatus(200);
        $response->assertJson($expected = [
            'id' => 2,
            'body' => self::DEFAULT_BODY,
            'meta' => $input,
            'mods' => array_values(array_map(fn (array $mod) => array_diff_key($mod, array_flip(['versions'])), array_filter($input['mods']))),
            'versions' => collect($input['mods'])->pluck('versions')->flatten(1)->filter()->values()->toArray(),
            'builds' => array_values(array_map(fn (array $mod) => array_diff_key($mod, array_flip(['files'])), array_filter($input['builds']))),
            'files' => collect($input['builds'])->pluck('files')->flatten(1)->filter()->values()->toArray(),
            'content' => null,
            'images' => null,
            'mod_identifier' => self::DEFAULT_BODY['mod']['id'],
            'mod_version' => self::DEFAULT_BODY['mod']['version'],
            'mc_version' => self::DEFAULT_BODY['mc']['version'],
        ]);

        $this->assertDatabaseCount('content_updates', 2);
        $this->assertDatabaseHas('content_updates', array_diff_key($expected, array_flip(['body', 'meta', 'mods', 'versions', 'builds', 'files'])));

        $ignoredMods = array_diff_key(self::DEFAULT_META['mods'], $input['mods']);
        $this->assertDatabaseCount('mods', count($expected['mods']) + count($ignoredMods));
        foreach ($ignoredMods as $mod) {
            unset($mod['versions']);
            $this->assertDatabaseHas('mods', $mod);
        }
        $this->assertDatabaseMissing('mods', ['identifier' => 'to_dream']);
        $this->assertDatabaseMissing('mods', ['identifier' => 'to_stars']);

        $ignoredVersions = collect($ignoredMods)->pluck('versions')->flatten(1)->filter()->toArray();
        $this->assertDatabaseCount('mod_versions', count($expected['versions']) + count($ignoredVersions));
        foreach ($ignoredVersions as $version) {
            if ($version['released_at']) {
                $version['released_at'] = Carbon::parse($version['released_at'])->toDateTimeString();
            }
            $this->assertDatabaseHas('mod_versions', $version);
        }

        $ignoredBuilds = array_diff_key(self::DEFAULT_META['builds'], $input['builds']);
        $this->assertSame(Build::count(), count($expected['builds']) + count($ignoredBuilds));
        foreach ($ignoredBuilds as $build) {
            unset($build['files']);
            if ($build['released_at']) {
                $build['released_at'] = Carbon::parse($build['released_at'])->toDateTimeString();
            }
            $this->assertDatabaseHas('builds', $build);
        }
        $this->assertDatabaseMissing('mods', ['commit' => '36b860424b6eb4c636866382f341b3794f99d76b']);

        $ignoredFiles = collect($ignoredBuilds)->pluck('files')->flatten(1)->filter()->toArray();
        $this->assertSame(BuildFile::count(), count($expected['files']) + count($ignoredFiles));
        foreach ($ignoredFiles as $file) {
            $this->assertDatabaseHas('build_files', array_diff_key($file, array_flip(['released_at'])));
        }
    }
}
