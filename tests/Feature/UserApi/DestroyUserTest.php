<?php

namespace Tests\Feature\UserApi;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DestroyUserTest extends TestCase
{
   use RefreshDatabase, WithFaker;

   public function testDestroyUser(){
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

       $response = $this->delete(route('user.destroy', $user->id), []);
       $response->assertStatus(200);
       $this->assertDatabaseMissing('users', [
           'id' => $user->id,
       ]);
   }
   public function testDestroyUserWithNotFoundId(){
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
       //Проверяем что id пользователя в токене и в переданном не совпадают
       $response = $this->delete(route('user.destroy', '-1'), []);
       $response->assertStatus(404);
       $this->assertDatabaseHas('users', [
           'id' => $user->id,
       ]);
   }
}
