<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->admin()->create([
            'name'  => 'Администратор',
            'email' => 'admin@example.com',
        ]);

        User::factory(5)->create();

        Event::factory(5)
            ->has(Article::factory()->count(3))
            ->create();
    }
}
