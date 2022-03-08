<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->has(Todo::factory()->count(rand(5, 10)))
            ->create(['email' => 'admin@gmail.com']);
        User::factory()
            ->has(Todo::factory()->count(rand(5, 10)))
            ->create(['email' => 'user@gmail.com']);
        User::factory(10)
            ->has(Todo::factory()->count(rand(5, 10)))
            ->create();
    }
}
