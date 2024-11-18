<?php

namespace PostApi;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdatePostTest extends TestCase
{
    use RefreshDatabase;
    public function test_update_post(): void{
        $post = Post::factory()->create();
        $file = UploadedFile::fake()->image('new_image.png');

        $response = $this->put(route('post.update', $post->id), [
            'category_id' => 2,
            'title' => 'test',
            'description' => 'test description',
            'image' => $file,
            'price' => 2122
        ]);

        $response->assertStatus(201);
        Storage::disk('public')->assertExists('posts/' . $file->hashName());
        $this->assertDatabaseHas('posts', [
            'category_id' => 2,
            'title' => 'test',
            'description' => 'test description',
            'image' => $file->hashName(),
            'price' => 2122
        ]);
        Storage::delete('public/posts/' . $file->hashName());

    }

    public function TestUpdatePostWithoutImage(): void{
        $response = $this->put(route('post.update', 16), [
            'category_id' => 2,
            'title' => 'test',
            'description' => 'test description',
            'price' => 2122
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', [
            'category_id' => 2,
            'title' => 'test1',
            'description' => 'test description1',
            'price' => 2122
        ]);
    }
}
