<?php

namespace Tests\Feature\UserApi;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreImageUserTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    public function testStoreImageUser(){
        //Создаем пользователя и проверяем его в бд
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

        $avatar = UploadedFile::fake()->image('new_avatar.png');
        $response = $this->post(route('user.avatar'), [
            'avatar' => $avatar,
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'avatar' => $avatar->hashName(),
        ]);
        Storage::delete('public/avatars/' . $avatar->hashName());
    }
    public function teststoreImageUserWhithNotAvatar(){
        //Создаем пользователя и проверяем его в бд
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

        $response = $this->post(route('user.avatar'), [
            'avatar' => '',
        ]);
        $response->assertStatus(302);

    }
}
