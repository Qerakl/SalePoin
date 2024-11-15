<?php

namespace Tests\Feature\UserApi;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginUserApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testLoginUser(){
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
    }
    public function testLoginUserWithWrongPassword(){
        //Создаем пользователя и проверяем его в бд
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', [
            'id' => $user->id
        ]);

        //авторизуем этого пользователя и редирект
        $loginResponse = $this->post(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password1234',
        ]);
        $loginResponse->assertStatus(401);
    }

    public function testLoginUserWithWrongEmail(){
        //Создаем пользователя и проверяем его в бд
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', [
            'id' => $user->id
        ]);

        //авторизуем этого пользователя и проверяем на код успеха
        $loginResponse = $this->post(route('auth.login'), [
            'email' => 'sadasdas@sfsd.safdf',
            'password' => 'password',
        ]);
        $loginResponse->assertStatus(302);
    }
}
