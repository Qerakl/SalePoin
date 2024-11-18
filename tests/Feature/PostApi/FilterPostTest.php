<?php

namespace Tests\Feature\PostApi;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FilterPostTest extends TestCase
{
    use RefreshDatabase;

    public function testFilterPost(){
        Post::factory()->count(100)->create();

        $response = $this->post(route('post.filter'), [
            'category_id' => 1,
            'rating_from' => 1,
            'rating_to' => 5,
            'price_from' => 100,
            'price_to' => 2000,
            'date_from' => '1980-01-01',
            'date_to' => '2020-01-01',

        ]);
        $response->assertStatus(200);
    }
}
