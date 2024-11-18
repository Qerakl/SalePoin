<?php

namespace Tests\Feature\UserApi;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateUserApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testUpdateUser(){
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

        $name = $this->faker->name();
        $email = $this->faker->unique()->safeEmail();
        $response = $this->put(route('user.update', $user->id), [
           'name' => $name,
           'email' => $email,
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email,
        ]);
    }
    public function testUpdateUserNotFound(){
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

        $name = $this->faker->name();
        $email = $this->faker->unique()->safeEmail();
        $response = $this->put(route('user.update', $user->id * 123123), [
            'name' => $name,
            'email' => $email,
        ]);
        $response->assertStatus(404);
        $this->assertDatabaseMissing('users', [
            'name' => $name,
            'email' => $email,
        ]);
    }

    public function testUpdateUserWithEmptyName(){
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

        $name = $this->faker->name();
        $email = $this->faker->unique()->safeEmail();
        $response = $this->put(route('user.update', $user->id), [
            'name' => $name,
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('users', [
            'name' => $name,
        ]);
    }
    public function testUpdateUserWithEmptyEmail(){
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


        $email = $this->faker->unique()->safeEmail();
        $response = $this->put(route('user.update', $user->id), [
            'email' => $email,
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('users', [
            'email' => $email,
        ]);
    }
    //
    public function testUpdateUserWithOnlyName(){
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

        $name = $this->faker->name();
        $response = $this->put(route('user.update', $user->id), [
            'name' => $name,
            'email' => $user->email,
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $user->email,
        ]);
    }
    public function testUpdateUserWithOnlyEmail(){
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

        $email = $this->faker->unique()->safeEmail();
        $response = $this->put(route('user.update', $user->id), [
            'name' => $user->name,
            'email' => $email,
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $email,
        ]);
    }
}
