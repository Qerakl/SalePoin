<?php

namespace Database;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FactoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testUserFactory(){
        $users = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'id' => $users->id,
        ]);
    }
   public function testPostFactory(){
        $post = Post::factory()->create();
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
        ]);
   }

}
