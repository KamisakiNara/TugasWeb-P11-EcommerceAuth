<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Tugas Rutin 11 - Bagian B No. 7
     *
     * Catatan penting: pada gambar ketentuan tertulis "PostPolicy".
     * Karena aplikasi ini bertema E-Commerce (bukan blog dengan model Post),
     * policy ini dipasang pada model Product sebagai entitas utama yang
     * di-CRUD dan perlu otorisasi edit/delete. Kalau dosen memang minta
     * nama class harus persis "PostPolicy", tinggal rename class dan file
     * ini menjadi PostPolicy tanpa mengubah isi logikanya.
     */

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor']);
    }

    public function update(User $user, Product $product): bool
    {
        return in_array($user->role, ['admin', 'editor']);
    }

    public function delete(User $user, Product $product): bool
    {
        // Sengaja dibuat lebih ketat dari update: hanya admin yang boleh hapus.
        // Ini membedakan hasil test antara role admin dan editor di No. 8.
        return $user->role === 'admin';
    }
}
