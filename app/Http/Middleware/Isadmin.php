<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->email === 'admin@gmail.com') {
            return $next($request);
        }

        Auth::logout(); // logout user if not admin
        abort(403, 'Access Denied');
    }
}

