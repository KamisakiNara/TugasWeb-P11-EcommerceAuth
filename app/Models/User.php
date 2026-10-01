<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * PENTING: ini adalah file User.php lengkap (hasil install Breeze + tambahan
     * Tugas Rutin 11). Timpa User.php punyamu dengan isi ini, ATAU cukup tambahkan
     * bagian yang ditandai "TAMBAHAN TR11" ke file User.php yang sudah ada.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // TAMBAHAN TR11 - Bagian B No. 6: kolom role untuk multi-role
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ================= TAMBAHAN TR11 =================
    // Relasi Eloquent ke tabel-tabel e-commerce

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    // Helper pengecekan role, dipakai di Blade (@if auth()->user()->isAdmin())
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEditor(): bool
    {
        return $this->role === 'editor';
    }
    // ================= AKHIR TAMBAHAN TR11 =================
}
