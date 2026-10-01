<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Tugas Rutin 11 - Bonus: eager loading demo.
     * with('category') = mengambil relasi category dalam 1 query tambahan saja
     * (bukan 1 query per produk / N+1 problem). Coba bandingkan dengan
     * menghapus with('category') lalu lihat jumlah query di Laravel Debugbar
     * atau lewat DB::enableQueryLog() di Tinker (lihat TINKER_QUERIES.md).
     */
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        // Bagian B No. 7: otorisasi lewat Policy (bukan cuma middleware)
        Gate::authorize('create', Product::class);

        $categories = Category::all();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Product::class);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']).'-'.Str::random(5);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        Gate::authorize('update', $product);

        $categories = Category::all();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        Gate::authorize('update', $product);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        // Di sinilah perbedaan admin vs editor benar-benar diuji (lihat No. 8):
        // route mengizinkan admin+editor lewat, tapi Policy ini menolak editor.
        Gate::authorize('delete', $product);

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
