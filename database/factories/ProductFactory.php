<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Tugas Rutin 11 - Bagian A No. 2
     * Factory untuk generate produk "realistis": nama disusun dari
     * kombinasi kata sifat + jenis barang, bukan random string murni.
     */
    public function definition(): array
    {
        $adjectives = ['Premium', 'Klasik', 'Modern', 'Elegan', 'Simpel', 'Pro', 'Deluxe', 'Ringkas', 'Wireless', 'Original'];
        $nouns = ['Tas Ransel', 'Kaos', 'Sepatu', 'Jam Tangan', 'Headphone', 'Standing Laptop', 'Botol Minum', 'Jaket', 'Kacamata', 'Dompet', 'Buku Catatan', 'Mug', 'Lampu Meja', 'Kursi Kerja', 'Keyboard'];

        $name = fake()->randomElement($adjectives).' '.fake()->randomElement($nouns);

        return [
            // Ambil kategori acak yang sudah ada (CategorySeeder wajib jalan duluan)
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'name' => $name,
            'slug' => Str::slug($name).'-'.Str::random(5),
            'description' => fake()->sentence(12),
            'price' => fake()->numberBetween(15, 500) * 1000, // harga terasa seperti Rupiah
            'stock' => fake()->numberBetween(0, 150),
            'image' => null,
        ];
    }
}
