<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Tugas Rutin 11 - Bagian A No. 2
     * Urutan pemanggilan PENTING: User & Category dulu, baru Product
     * (karena ProductFactory butuh category_id yang sudah ada).
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
