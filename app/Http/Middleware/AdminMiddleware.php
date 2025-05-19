<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Явный импорт фасада Auth

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Вариант 1: Используя фасад Auth
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Вариант 2: Альтернативная проверка через guard
        // if (!auth()->check()) {
        //     return redirect()->route('login');
        // }

        // Проверка прав администратора
        $user = Auth::user();
        
        // Вариант проверки 1: через метод isAdmin()
        if (!$user->isAdmin()) {
            abort(403, 'Доступ запрещен');
        }
        
        // Вариант проверки 2: прямое обращение к полю
        // if ($user->role !== 'admin') {
        //    abort(403, 'Доступ запрещен');
        // }

        return $next($request);
    }
}