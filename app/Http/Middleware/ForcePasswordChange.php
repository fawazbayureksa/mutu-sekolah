<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->must_change_password) {
            // Allow the password change routes to pass through
            if ($request->routeIs('school.password.change', 'school.password.update')) {
                return $next($request);
            }

            return redirect()->route('school.password.change')
                ->with('info', 'Anda harus membuat password baru sebelum melanjutkan.');
        }

        return $next($request);
    }
}
