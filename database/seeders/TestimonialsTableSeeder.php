<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestimonialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('testimonials')->insert([
            [
                'testimonial' => 'Pelayanan sangat ramah dan mobil dalam kondisi prima. Recommended!',
                'name' => 'Andi Saputra',
                'position' => 'Pengusaha',
                'photo' => 'testimonials/default.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'testimonial' => 'Mobil bersih dan nyaman. Proses pemesanan juga sangat mudah.',
                'name' => 'Siti Aminah',
                'position' => 'Ibu Rumah Tangga',
                'photo' => 'testimonials/default.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'testimonial' => 'Harga terjangkau, cocok buat liburan keluarga. Akan sewa lagi!',
                'name' => 'Rian Pratama',
                'position' => 'Karyawan Swasta',
                'photo' => 'testimonials/default.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
