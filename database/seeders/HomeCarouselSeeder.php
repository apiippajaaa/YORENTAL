<?php

namespace Database\Seeders;

use App\Models\HomeCarousel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomeCarouselSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $images = [
            'carousels/1.jpg',
            'carousels/2.jpg',
            'carousels/3.jpg',
        ];

        foreach ($images as $image) {
            HomeCarousel::create([
                'image' => $image,
            ]);
        }
    }
}
