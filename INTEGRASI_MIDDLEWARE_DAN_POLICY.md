# Integrasi middleware & policy

Dua file INI SUDAH ADA di project Laravel-mu sejak awal install.
Kamu hanya perlu MENAMBAHKAN baris yang ditandai, bukan mengganti seluruh isi file.

## 1. bootstrap/app.php — daftarkan middleware `role`

Cari bagian `->withMiddleware(function (Middleware $middleware) {`
lalu tambahkan alias di dalamnya:

```php
use App\Http\Middleware\EnsureUserHasRole;

->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => EnsureUserHasRole::class,
    ]);
})
```

Kalau project-mu masih Laravel 10 ke bawah (masih ada app/Http/Kernel.php),
tambahkan baris ini ke dalam `$middlewareAliases` di Kernel.php:

```php
'role' => \App\Http\Middleware\EnsureUserHasRole::class,
```

## 2. app/Providers/AppServiceProvider.php — daftarkan Policy

Tambahkan use statement di atas, dan satu baris di dalam method boot():

```php
use App\Models\Product;
use App\Policies\ProductPolicy;
use Illuminate\Support\Facades\Gate;

public function boot(): void
{
    Gate::policy(Product::class, ProductPolicy::class);
}
```

Catatan: sebenarnya Laravel modern bisa auto-detect Policy lewat
konvensi nama (Product -> ProductPolicy), tapi mendaftarkannya manual
seperti ini membuatnya pasti terbaca dan lebih mudah dijelaskan ke dosen.
