<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ServiceControllerTest extends TestCase
{
    public function test_pluralise(): void
    {
        $data = [
            'block.minecraft.grass_block' => 'Grass Block',
            'block.minecraft.cobblestone' => 'Cobblestone',
            'item.minecraft.nether_star' => 'Nether Star',
            'item.lcc.knife' => 'Knife',
            'block.to_base.test_block' => 'Test Block',
            'block.to_base.test_block_2' => 'Test Block 2',
            'block.to_stars.launch_pad' => 'Rocket Launch Pad',
        ];
        $expected = [
            'block.minecraft.grass_block' => 'Grass Blocks',
            'block.minecraft.cobblestone' => 'Cobblestones',
            'item.minecraft.nether_star' => 'Nether Stars',
            'item.lcc.knife' => 'Knives',
            'block.to_base.test_block' => 'Test Blocks',
            'block.to_base.test_block_2' => 'Test Block 2s',
            'block.to_stars.launch_pad' => 'Rocket Launch Pads',
        ];

        $response = $this->postJson('/api/service/pluralise', $data);

        $response->assertStatus(200);
        $response->assertJson($expected);
    }
}
