<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        $userRole = Auth::check() ? Auth::user()->role : 'not logged in';
        $userId = Auth::check() ? Auth::id() : 'none';
        Log::info('Role check: User role = ' . $userRole . ', Required role = ' . $role . ', User ID = ' . $userId);

        if (!Auth::check() || Auth::user()->role !== $role) {
            Log::warning('Access denied: User role ' . $userRole . ' does not match required role ' . $role);
            abort(403, 'Akses dilarang. Anda tidak memiliki hak untuk mengakses halaman ini.');
        }
        return $next($request);
    }
}
