<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Sprawdź, czy użytkownik jest zalogowany i ma rolę admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Jeśli użytkownik nie ma roli admin, przekieruj lub wyświetl błąd
        return redirect('/')->with('error', 'You do not have admin access.');
    }
}
