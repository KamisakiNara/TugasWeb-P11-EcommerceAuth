<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Toko Online') — Tugas Rutin 11</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('products.index') }}">Toko Online</a>

            <div class="d-flex align-items-center gap-3 ms-auto">
                @auth
                    <span class="text-white small">
                        {{ auth()->user()->name }}
                        <span class="badge bg-secondary text-uppercase">{{ auth()->user()->role }}</span>
                    </span>

                    @can('create', App\Models\Product::class)
                        <a href="{{ route('products.create') }}" class="btn btn-sm btn-success">+ Tambah Produk</a>
                    @endcan

                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>

</body>
</html>
