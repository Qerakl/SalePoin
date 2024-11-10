<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdatePostTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_update_post(): void{
        $file = UploadedFile::fake()->image('new_image.png');
        $response = $this->put(route('post.update', 12), [
            'category_id' => 2,
            'title' => 'test',
            'description' => 'test description',
            'image' => $file,
        ]);
        $response->assertStatus(201);
        Storage::disk('public')->assertExists('posts/' . $file->hashName());

    }
}
