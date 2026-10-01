# Tugas Rutin 11 — E-Commerce DB + Secure Auth

Panduan setup lengkap, urut dari nomor 1 sampai 8 sesuai ketentuan, plus bonus.
Baca `PENJELASAN` di chat untuk alasan tiap keputusan desain; file ini murni
langkah teknis yang bisa kamu ikuti sambil kerja.

## 0. Prasyarat

Project Laravel baru (kosong), sudah `composer create-project laravel/laravel nama-project`,
database MySQL sudah dibuat dan disambungkan lewat file `.env`.

## Bagian A — Database & Eloquent

### 1. Migrations 7 tabel + FK
1. Salin 8 file dari folder `database/migrations/` project ini ke folder
   `database/migrations/` project Laravel-mu (1 file untuk tambah kolom role,
   7 file untuk tabel baru).
2. Jalankan:
   ```
   php artisan migrate
   ```

### 2. Seeders + factories (50+ produk)
1. Salin `database/factories/ProductFactory.php` ke project-mu.
2. Salin 4 file dari `database/seeders/` ke project-mu (timpa DatabaseSeeder.php
   yang sudah ada).
3. Jalankan:
   ```
   php artisan db:seed
   ```
   Ini akan membuat 3 user (admin/editor/user), 6 kategori, dan 60 produk.

### 3. Model + relationships + minimal 1 scope
1. Salin 7 file dari `app/Models/` (Category, Product, Order, OrderItem, Cart,
   Review, Address) ke project-mu.
2. Buka `app/Models/User.php` punyamu, lalu:
   - Tambahkan `'role'` ke array `$fillable`
   - Tambahkan method `orders()`, `carts()`, `reviews()`, `addresses()`, `isAdmin()`, `isEditor()`
   - (lihat file User.php di sini sebagai referensi lengkap)

### 4. Dokumentasi 5 query Tinker
Ikuti `TINKER_QUERIES.md` di folder ini.

## Bagian B — Auth & Security

### 5. Install Breeze
```
composer require laravel/breeze --dev
php artisan breeze:install
```
Saat ditanya stack, pilih **Blade**. Lanjutkan:
```
npm install && npm run build
```
Breeze otomatis membuat route & view login/register/logout — tidak perlu
dibuat manual.

### 6. Multi-role + custom middleware
1. Migration role (langkah 1) + isAdmin()/isEditor() (langkah 3) sudah
   menyiapkan datanya.
2. Salin `app/Http/Middleware/EnsureUserHasRole.php` ke project-mu.
3. Daftarkan middleware-nya: ikuti `INTEGRASI_MIDDLEWARE_DAN_POLICY.md` bagian 1.

### 7. Policy otorisasi edit/delete
1. Salin `app/Policies/ProductPolicy.php` ke project-mu.
2. Daftarkan Policy-nya: ikuti `INTEGRASI_MIDDLEWARE_DAN_POLICY.md` bagian 2.
3. Salin `app/Http/Controllers/ProductController.php` ke project-mu.
4. Salin folder `resources/views/layouts/` dan `resources/views/products/`
   ke project-mu.
5. Tambahkan route: ikuti isi `routes/web-tambahan.php`.

### 8. Route protection + testing 2 role
1. Jalankan `php artisan serve`.
2. Buka browser biasa, login sebagai `admin@example.com` / `password`.
   Buka `/products` — tombol Tambah, Edit, dan Hapus semua muncul dan berfungsi.
3. Buka jendela **Incognito**, login sebagai `editor@example.com` / `password`.
   Buka `/products` — tombol Tambah & Edit muncul dan berfungsi, tapi tombol
   Hapus akan menghasilkan **403 Forbidden** (dibatasi oleh Policy, bukan middleware).
4. Coba juga login sebagai `user@example.com` / `password` — tombol Tambah
   tidak akan muncul sama sekali, dan mengakses `/products/create` langsung
   lewat URL akan menghasilkan **403 Forbidden** (dibatasi oleh middleware `role`).
5. Screenshot ketiga kondisi ini (admin, editor, user) sebagai bukti testing.

## Bonus

### Filament admin panel
```
composer require filament/filament
php artisan filament:install --panels
php artisan make:filament-user
php artisan make:filament-resource Category --generate
php artisan make:filament-resource Product --generate
```
Buka `/admin` untuk login ke panel Filament dengan akun yang dibuat lewat
`make:filament-user`.

### Eager loading demo
Sudah diterapkan di `ProductController@index` lewat `with('category')`.
Lihat bagian bawah `TINKER_QUERIES.md` untuk cara membuktikan bedanya
lewat perhitungan jumlah query.

## Akun demo (dari UserSeeder)
| Role   | Email               | Password |
|--------|---------------------|----------|
| admin  | admin@example.com   | password |
| editor | editor@example.com  | password |
| user   | user@example.com    | password |
