<?php

namespace Database;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MigrateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function MigrateTest()
    {
        $this->artisan('migrate')->assertExitCode(0);
        // Проверьте, что таблица существует
        $this->assertTrue(Schema::hasTable('users'));
        $this->assertTrue(Schema::hasTable('posts'));
        $this->assertTrue(Schema::hasTable('categories'));

    }

}
