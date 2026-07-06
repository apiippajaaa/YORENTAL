<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('faqs')->insert([
            [
                'question' => 'Bagaimana cara melakukan pemesanan?',
                'answer' => 'Anda bisa melakukan pemesanan melalui website atau hubungi kami via WhatsApp.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Apa saja syarat sewa mobil?',
                'answer' => 'KTP, SIM A aktif, dan uang jaminan sesuai ketentuan berlaku.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Apakah tersedia sewa dengan supir?',
                'answer' => 'Ya, kami menyediakan pilihan sewa mobil dengan atau tanpa supir.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
