@extends('layouts.toko')

@section('title', 'Katalog Produk')

@section('content')
    <h1 class="mb-4">Katalog Produk</h1>

    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <span class="badge bg-info text-dark mb-2">{{ $product->category->name }}</span>
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($product->description, 60) }}</p>
                        <p class="fw-bold mb-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="small text-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                            Stok: {{ $product->stock }}
                        </p>
                    </div>

                    @canany(['update', 'delete'], $product)
                        <div class="card-footer d-flex gap-2">
                            @can('update', $product)
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                            @endcan

                            @can('delete', $product)
                                <form action="{{ route('products.destroy', $product) }}" method="POST"
                                      onsubmit="return confirm('Yakin hapus produk ini?')" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            @endcan
                        </div>
                    @endcanany
                </div>
            </div>
        @empty
            <p>Belum ada produk. Jalankan seeder terlebih dahulu.</p>
        @endforelse
    </div>

    {{ $products->links() }}
@endsection
