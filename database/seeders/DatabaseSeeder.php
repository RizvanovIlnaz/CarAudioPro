<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
{
    // Создаем администратора, если его нет
    \App\Models\User::firstOrCreate(
        ['email' => 'admin@example.com'],
        [
            'name' => 'Admin',
            'password' => bcrypt('password123'),
            'role' => 'admin'
        ]
    );

    // Создаем тестового пользователя, если его нет
    \App\Models\User::firstOrCreate(
        ['email' => 'test@example.com'],
        [
            'name' => 'Test User',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]
    );

    // Запускаем сидер категорий
    $this->call(CategoriesTableSeeder::class);
}
}
