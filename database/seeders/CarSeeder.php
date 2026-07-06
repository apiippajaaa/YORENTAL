<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarPhoto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $cars = [
            [
                'car_category_id' => 1,
                'name' => 'Ferrari 488',
                'slug' => 'ferrari-488',
                'plate_number' => 'B1001FER',
                'year' => 2020,
                'seats' => 2,
                'transmission' => 'automatic',
                'color' => 'Red',
                'price_per_12_hours' => 500000,
                'price_per_day' => 900000,
                'description' => 'Mobil sport mewah dengan performa tinggi dari Ferrari.',
            ],
            [
                'car_category_id' => 1,
                'name' => 'Lamborghini Aventador',
                'slug' => 'lamborghini-aventador',
                'plate_number' => 'B1002LAM',
                'year' => 2021,
                'seats' => 2,
                'transmission' => 'automatic',
                'color' => 'Yellow',
                'price_per_12_hours' => 100000,
                'price_per_day' => 500000,
                'description' => 'Lamborghini dengan desain agresif dan tenaga luar biasa.',
            ],
            [
                'car_category_id' => 1,
                'name' => 'McLaren 720S',
                'slug' => 'mclaren-720s',
                'plate_number' => 'B1003MCL',
                'year' => 2022,
                'seats' => 2,
                'transmission' => 'automatic',
                'color' => 'Orange',
                'price_per_12_hours' => 550000,
                'price_per_day' => 900000,
                'description' => 'McLaren 720S adalah supercar dengan handling luar biasa.',
            ],
            [
                'car_category_id' => 1,
                'name' => 'Porsche 911 Turbo S',
                'slug' => 'porsche-911-turbo-s',
                'plate_number' => 'B1004POR',
                'year' => 2021,
                'seats' => 4,
                'transmission' => 'automatic',
                'color' => 'Silver',
                'price_per_12_hours' => 450000,
                'price_per_day' => 800000,
                'description' => 'Mobil sport ikonik dari Porsche dengan kenyamanan harian.',
            ],
            [
                'car_category_id' => 1,
                'name' => 'Chevrolet Corvette C8',
                'slug' => 'chevrolet-corvette-c8',
                'plate_number' => 'B1005CHE',
                'year' => 2022,
                'seats' => 2,
                'transmission' => 'automatic',
                'color' => 'White',
                'price_per_12_hours' => 400000,
                'price_per_day' => 750000,
                'description' => 'Corvette C8 dengan mesin tengah yang ikonik.',
            ],
            [
                'car_category_id' => 1,
                'name' => 'Aston Martin Vantage',
                'slug' => 'aston-martin-vantage',
                'plate_number' => 'B1006AST',
                'year' => 2020,
                'seats' => 2,
                'transmission' => 'automatic',
                'color' => 'Green',
                'price_per_12_hours' => 480000,
                'price_per_day' => 850000,
                'description' => 'Keanggunan khas Inggris dengan performa hebat.',
            ],
            [
                'car_category_id' => 1,
                'name' => 'Nissan GT-R R35',
                'slug' => 'nissan-gtr-r35',
                'plate_number' => 'B1007NIS',
                'year' => 2020,
                'seats' => 4,
                'transmission' => 'automatic',
                'color' => 'Black',
                'price_per_12_hours' => 350000,
                'price_per_day' => 700000,
                'description' => 'Legenda Jepang dengan akselerasi brutal.',
            ],
            [
                'car_category_id' => 1,
                'name' => 'Audi R8',
                'slug' => 'audi-r8',
                'plate_number' => 'B1008AUD',
                'year' => 2021,
                'seats' => 2,
                'transmission' => 'automatic',
                'color' => 'Blue',
                'price_per_12_hours' => 470000,
                'price_per_day' => 860000,
                'description' => 'Audi R8 dengan suara V10 yang menggelegar.',
            ],
            [
                'car_category_id' => 1,
                'name' => 'BMW i8',
                'slug' => 'bmw-i8',
                'plate_number' => 'B1009BMW',
                'year' => 2019,
                'seats' => 2,
                'transmission' => 'automatic',
                'color' => 'White-Blue',
                'price_per_12_hours' => 300000,
                'price_per_day' => 650000,
                'description' => 'Mobil hybrid futuristik dari BMW.',
            ],
            [
                'car_category_id' => 1,
                'name' => 'Ford Mustang GT',
                'slug' => 'ford-mustang-gt',
                'plate_number' => 'B1010FOR',
                'year' => 2020,
                'seats' => 4,
                'transmission' => 'manual',
                'color' => 'Red',
                'price_per_12_hours' => 320000,
                'price_per_day' => 670000,
                'description' => 'Muscle car klasik Amerika dengan tenaga besar.',
            ],
        ];

        foreach ($cars as $carData) {
            $slug = $carData['slug'];
            unset($carData['slug']); // remove slug before inserting

            $car = Car::create($carData);

            // Simulasi ada 2 foto per mobil
            for ($i = 1; $i <= 3; $i++) {
                $photoPath = "cars/seeder/{$slug}/{$i}.jpg";
                CarPhoto::create([
                    'car_id' => $car->id,
                    'photo_path' => $photoPath,
                ]);
            }
        }
    }
}
