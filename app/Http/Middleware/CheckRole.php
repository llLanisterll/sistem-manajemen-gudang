<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika user belum login, lempar ke halaman login
        if (! $request->user()) {
            return redirect('/login');
        }

        // Cek apakah role user ada di dalam daftar role yang diizinkan
        // Admin (super user) selalu boleh akses (opsional, tapi disarankan)
        if ($request->user()->role === 'admin') {
            return $next($request);
        }

        // Cek role spesifik
        if (in_array($request->user()->role, $roles)) {
            return $next($request);
        }

        // Jika tidak punya akses
        abort(403, 'Unauthorized access.');
    }
}
