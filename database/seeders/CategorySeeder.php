<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(Category::query()->count() === 0) {
            Category::create([
                'name' => 'Спорт'
            ]);
            Category::create([
                'name' => 'Одежда'
            ]);
            Category::create([
                'name' => 'Работа'
            ]);
            Category::create([
            'name' => 'Эксасуары'
            ]);
        }
    }
}
