<?php

namespace Tests\Feature\UserApi;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexUserTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexUser(){
        User::factory()->count(10)->create();

        $response = $this->get(route('user.index'));
        $response->assertStatus(200);
    }
}
