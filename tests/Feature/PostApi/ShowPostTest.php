<?php

namespace PostApi;

use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ShowPostTest extends TestCase
{
    use DatabaseMigrations;

    public function testShowPost(){
        $post = Post::factory()->create();

        $response = $this->get(route('post.show', $post->id));
        $response->assertStatus(200);
        $this->assertDatabaseHas('posts', $post->toArray());

    }

    public function testShowPostNotFound(){
        $post = Post::factory()->create();

        $response = $this->get(route('post.show', $post->id*2132));
        $response->assertStatus(404);
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id*2132,
        ]);
    }
}
