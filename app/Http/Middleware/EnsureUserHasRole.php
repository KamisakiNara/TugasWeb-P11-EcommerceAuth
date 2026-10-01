<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Tugas Rutin 11 - Bagian B No. 6
     * Middleware custom untuk membatasi akses berdasarkan role.
     * Pemakaian di route: ->middleware('role:admin,editor')
     * Bisa diisi lebih dari satu role, dipisah koma.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user() || ! in_array($request->user()->role, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
