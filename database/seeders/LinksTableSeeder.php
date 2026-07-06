<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('links')->insert([
            [
                'icon' => 'fa-brands fa-instagram',
                'title' => 'Instagram',
                'account' => '@yorental',
                'url' => 'https://instagram.com/yorental',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'fa-brands fa-whatsapp',
                'title' => 'WhatsApp',
                'account' => '+6281234567890',
                'url' => 'https://wa.me/6281234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'fa-brands fa-facebook',
                'title' => 'Facebook',
                'account' => 'yorental',
                'url' => 'https://facebook.com/yorental',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'icon' => 'fa-solid fa-envelope',
                'title' => 'Gmail',
                'account' => 'yordankusumaw@gmail.com',
                'url' => 'mailto:yordankusumaw@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
