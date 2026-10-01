<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Elektronik',
            'Fashion',
            'Peralatan Rumah Tangga',
            'Olahraga & Outdoor',
            'Buku & Alat Tulis',
            'Kesehatan & Kecantikan',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
                'description' => 'Kumpulan produk kategori '.$category,
            ]);
        }
    }
}
