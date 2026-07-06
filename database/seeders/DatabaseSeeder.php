<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CarCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'phone_number' => '081234567890',
            'address' => 'Klaten, Jawa Tengah, Indonesia',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);

        // Membuat data user
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'phone_number' => '081234567891',
            'address' => 'Klaten, Jawa Tengah, Indonesia',
            'password' => Hash::make('user'),
            'role' => 'user',
        ]);

        $categories = [
            'Sedan',
            'SUV',
            'MPV',
            'Hatchback',
            'Coupe'
        ];

        foreach ($categories as $category) {
            CarCategory::create(['name' => $category]);
        }

        $this->call([
            HomeCarouselSeeder::class,
            LinksTableSeeder::class,
            FaqsTableSeeder::class,
            TestimonialsTableSeeder::class,
            CarSeeder::class,
        ]);
    }
}
