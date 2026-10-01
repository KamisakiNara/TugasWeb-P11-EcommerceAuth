<?php
/**
 * ISI FILE INI TIDAK BERDIRI SENDIRI.
 * Salin bagian di bawah ini ke dalam routes/web.php punyamu
 * (taruh sebelum baris "require __DIR__.'/auth.php';").
 * Jangan lupa tambahkan use ProductController di paling atas web.php.
 */

use App\Http\Controllers\ProductController;

// ================= Tugas Rutin 11 - Bagian B No. 8: Route protection =================

// Katalog produk bisa dilihat siapa saja (termasuk yang belum login)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Hanya admin & editor yang boleh MASUK ke route-route berikut.
// (Policy di dalam controller yang nanti membedakan admin vs editor untuk delete)
Route::middleware(['auth', 'role:admin,editor'])->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});
