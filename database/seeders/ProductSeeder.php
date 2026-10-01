<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Tugas Rutin 11 - Bagian A No. 2
     * 60 produk (>50 sesuai ketentuan) dibuat lewat ProductFactory.
     */
    public function run(): void
    {
        Product::factory()->count(60)->create();
    }
}
