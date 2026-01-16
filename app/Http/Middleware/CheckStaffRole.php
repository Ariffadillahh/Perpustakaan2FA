<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckStaffRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && in_array((int)Auth::user()->role_id, [1, 2])) {
            return $next($request);
        }

        return redirect()->route('landing')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
    }
}
