<?php

namespace Tests\Feature\UserApi;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreUserTest extends TestCase
{

use RefreshDatabase, WithFaker;

    public function testStoreUserDescription(){
        //Создаем пользователя и проверяем его в бд
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', [
            'id' => 12
        ]);

        //авторизуем этого пользователя и проверяем на код успеха
        $loginResponse = $this->post(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $loginResponse->assertStatus(200);

        //Отправляем запрос для изменения описания профиля и проверяем на статус успеха и что он появился в бд
        $response = $this->post(route('user.store'), [
            'description' => 'test'
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'id' => 12,
            'description' => 'test'
        ]);
    }
    public function testStoreUserWithNotDescription(){
        //Создаем пользователя и проверяем его в бд
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', [
            'id' => 13
        ]);

        //авторизуем этого пользователя и проверяем на код успеха
        $loginResponse = $this->post(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $loginResponse->assertStatus(200);

        //Отправляем запрос для изменения описания профиля и проверяем на статус успеха и что он появился в бд
        $response = $this->post(route('user.store'), [
            'description' => ''
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'id' => 13,
            'description' => null
        ]);
    }
}
