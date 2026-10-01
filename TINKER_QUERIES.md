# Dokumentasi 5 Query Tinker — Tugas Rutin 11 Bagian A No. 4

Jalankan `php artisan tinker` di terminal, lalu ketik satu per satu perintah
di bawah ini. Screenshot HASIL setiap perintah (bukan cuma perintahnya) untuk
dilampirkan ke laporan.

> Catatan: semua model ditulis lengkap `App\Models\NamaModel` (tanpa garis
> miring di depan). Kalau ditulis singkat saja (misalnya `Product::...`),
> Tinker akan menolak dengan pesan "Class not found" karena PHP mencarinya
> di namespace global, bukan di `App\Models`. Alternatif: ketik
> `use App\Models\Product;` dulu di awal sesi, baru boleh pakai `Product::...`
> singkat untuk sisa sesi itu.

## Query 1 — Relasi belongsTo (produk -> kategori)
Menampilkan 1 produk beserta nama kategorinya.
```
App\Models\Product::with('category')->first()
```
Yang dibuktikan: relasi `belongsTo` di model Product jalan, dan `category`
muncul sebagai objek Category di dalam hasil produk.

## Query 2 — Relasi hasMany (kategori -> banyak produk)
Menampilkan semua produk dalam kategori dengan id 1.
```
App\Models\Category::find(1)->products
```
Yang dibuktikan: relasi `hasMany` di model Category, diakses dari sisi "satu".

## Query 3 — Custom scope
Menghitung jumlah produk yang stoknya masih tersedia.
```
App\Models\Product::inStock()->count()
```
Yang dibuktikan: scope `scopeInStock()` yang dibuat di model Product bisa
dipanggil langsung sebagai `Product::inStock()`.

## Query 4 — Query where biasa pada kolom role
Menampilkan semua user dengan role admin.
```
App\Models\User::where('role', 'admin')->get()
```
Yang dibuktikan: kolom `role` hasil migration No. 1 sudah terisi dan bisa
di-query seperti kolom biasa.

## Query 5 — Kombinasi eager loading + where + order + limit
Menampilkan 5 produk termahal beserta kategorinya.
```
App\Models\Product::with('category')->orderBy('price', 'desc')->take(5)->get()
```
Yang dibuktikan: relasi, sorting, dan limit bisa digabung dalam satu query
builder chain.

---

## Bonus — Bukti eager loading (N+1 problem)

Ini bukan bagian dari 5 query wajib, tapi bagus untuk bonus "eager loading
demo". Jalankan berurutan di Tinker yang sama. (`DB` boleh ditulis singkat
tanpa namespace — ini beda dengan model, karena `DB` sudah dikenal Laravel
sebagai alias bawaan.)

```
DB::enableQueryLog();
$produk = App\Models\Product::all();
foreach ($produk as $p) { $p->category->name; }
count(DB::getQueryLog())
```
Hasilnya akan mendekati jumlah produk + 1 (misalnya 61 query untuk 60 produk)
karena setiap `$p->category` memicu query baru satu per satu (N+1 problem).

Lalu bandingkan dengan:
```
DB::flushQueryLog();
$produk = App\Models\Product::with('category')->get();
foreach ($produk as $p) { $p->category->name; }
count(DB::getQueryLog())
```
Hasilnya akan jauh lebih sedikit (2 query saja: 1 untuk produk, 1 untuk semua
kategori sekaligus) karena `with('category')` melakukan eager loading.
Screenshot perbandingan dua angka ini sebagai bukti bonus eager loading.
