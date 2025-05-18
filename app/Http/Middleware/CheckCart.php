<?php

namespace App\Http\Middleware;

use Closure;

class CheckCart
{
    public function handle($request, Closure $next)
    {
        if (empty(session('cart'))) {
            return redirect()->route('home')->with('error', 'Ваша корзина пуста');
        }

        return $next($request);
    }
}
