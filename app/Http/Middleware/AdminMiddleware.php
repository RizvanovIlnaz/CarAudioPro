<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Вариант 1: Используя фасад Auth
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Доступ запрещен');
        }

        // Или вариант 2: Через guard (более предпочтительно)
        // if (!auth()->guard()->check() || auth()->guard()->user()->role !== 'admin') {
        //     abort(403, 'Доступ запрещен');
        // }

        return $next($request);
    }
}