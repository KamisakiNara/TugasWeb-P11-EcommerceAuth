<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
    ];

    // ================= Relasi Eloquent =================

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // ================= Tugas Rutin 11 - Bagian A No. 3: minimal 1 scope =================

    /**
     * Scope: hanya produk yang stoknya masih ada (> 0)
     * Cara pakai di Tinker/Controller: Product::inStock()->get()
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope tambahan: filter produk berdasarkan kategori tertentu
     * Cara pakai: Product::byCategory($id)->get()
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }
}
