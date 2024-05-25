<?php

namespace Tests\Feature;

use App\Models\ContentUpdate;
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

    protected function setUp() : void {
        parent::setUp();

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
        $response = $this->createRequest(content: $content = [
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
                    'data' => $content['to_base/test.json'],
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
        (new AssertableJsonString($json))->assertSubset($content['to_base/test.json']);
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
}
