<?php

namespace Tests\Feature\UserApi;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterUserApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testRegisterUser()
    {
        $email = $this->faker->unique()->safeEmail();
        $response = $this->post(route('auth.register'), [
            'name' => $this->faker->name(),
            'email' => $email,
            'password' => $this->faker->password(),
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => $email,
        ]);
    }
    public function testRegisterInvalidEmail(){

        $user = User::factory()->create();
        $userInvalidEmail = $this->faker->name();
        $response = $this->post(route('auth.register'), [
            'name' => $userInvalidEmail,
            'email' => $user->email,
            'password' => $this->faker->password(),
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
        $this->assertDatabaseMissing('users', [
            'name' => $userInvalidEmail,
        ]);
    }

    public function testRegisterWithNotNameUser()
    {
        $email = $this->faker->unique()->safeEmail();
        $response = $this->post(route('auth.register'), [
            'email' => $email,
            'password' => $this->faker->password(),
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('users', [
            'email' => $email,
        ]);
    }
    public function testRegisterWithNotEmailUser()
    {
        $name = $this->faker->name();
        $response = $this->post(route('auth.register'), [
            'name' => $name,
            'password' => $this->faker->password(),
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('users', [
            'name' => $name,
        ]);
    }
    public function testRegisterWithNotPasswordUser()
    {
        $email = $this->faker->unique()->safeEmail();
        $response = $this->post(route('auth.register'), [
            'name' => $this->faker->name(),
            'email' => $email,
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('users', [
            'email' => $email,
        ]);
    }
}
