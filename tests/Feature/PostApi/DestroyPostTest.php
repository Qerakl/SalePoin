<?php

namespace Tests\Feature\PostApi;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class DestroyPostTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    public function testDestroyPost(){
        //Создаем пользователя-пост и проверяем его в бд
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', [
            'id' => $user->id
        ]);

        //авторизуем этого пользователя и проверяем на код успеха
        $loginResponse = $this->post(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $loginResponse->assertStatus(200);
        //создаем пост через этого юзера
        $post = Post::create([
            'user_id' => $user->id,
            'category_id' => 1,
            'title' => 'test',
            'description' => 'test',
            'image' => 'test.png',
        ]);
        //Проверяем на успех в создание и что в бд появисля данный пост
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'user_id' => $user->id,
            'category_id' => 1,
            'title' => 'test',
            'description' => 'test',
            'image' => 'test.png',
        ]);
        $responseDestroyPost = $this->delete(route('post.destroy', $post->id ), [
            'id' => $post->id,
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }

    public function testDestroyPostNotFound(){
        //Создаем пользователя-пост и проверяем его в бд
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', [
            'id' => $user->id
        ]);

        //авторизуем этого пользователя и проверяем на код успеха
        $loginResponse = $this->post(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $loginResponse->assertStatus(200);
        //Проверяем что такого поста нет
        $responseDestroyPost = $this->delete(route('post.destroy', '1234' ), [
            'id' => '1234',
            'user_id' => $user->id,
        ]);
        $responseDestroyPost->assertStatus(404);
        $this->assertDatabaseMissing('posts', [
            'id' => '1234',
        ]);
    }


}
