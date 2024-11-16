<?php

namespace Tests\Feature\UserApi;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Routing\Route;
use Tests\TestCase;

class ShowUserTest extends TestCase
{
    use RefreshDatabase;

    public function testShowUser(){
        $user = User::factory()->create();
        $response = $this->get(route('user.show', $user->id));
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
    }
    public function testShowUserNotFound(){
        $user = User::factory()->create();
        $response = $this->get(route('user.show', $user->id+10));
        $response->assertStatus(404);
        $this->assertDatabaseMissing('users', [
            'id' => $user->id+10,
        ]);

    }
}
