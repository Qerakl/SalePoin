<?php

namespace PostApi;

use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdatePostTest extends TestCase
{

    public function test_update_post(): void{
        Post::factory()->create();
        $file = UploadedFile::fake()->image('new_image.png');

        $response = $this->put(route('post.update', 12), [
            'category_id' => 2,
            'title' => 'test',
            'description' => 'test description',
            'image' => $file,
        ]);

        $response->assertStatus(201);
        Storage::disk('public')->assertExists('posts/' . $file->hashName());
        $this->assertDatabaseHas('posts', [
            'category_id' => 2,
            'title' => 'test',
            'description' => 'test description',
            'image' => $file->hashName(),
        ]);

    }

    public function TestUpdatePostWithoutImage(): void{
        $response = $this->put(route('post.update', 16), [
            'category_id' => 2,
            'title' => 'test',
            'description' => 'test description',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', [
            'category_id' => 2,
            'title' => 'test1',
            'description' => 'test description1',
        ]);
    }
}
