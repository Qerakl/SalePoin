<?php

namespace Database;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SeedTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    public function testUserSeed(){
        $this->artisan('db:seed', ['--class' => 'UserSeeder']);

        $this->assertCount(10, User::all());
        $this->assertDatabaseHas('users', [
            'id' => '5'
        ]);
    }
    public function testPostSeed(){
        $this->artisan('db:seed', ['--class' => 'PostSeeder']);

        $this->assertCount(10, Post::all());
        $this->assertDatabaseHas('posts', [
            'id' => '5'
        ]);
    }

    public function testCategorySeed(){
        $this->artisan('db:seed', ['--class' => 'CategorySeeder']);
        $this->assertCount(4, Category::all());
        $this->assertDatabaseHas('categories', [
            'id' => '1'
        ]);
    }


}
