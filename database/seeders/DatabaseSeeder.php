<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Source;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Source::factory()
            ->count(3)
            ->create();

        Category::factory()
            ->count(10)
            ->create();

        Article::factory()
            ->count(100)
            ->create();
    }
}
