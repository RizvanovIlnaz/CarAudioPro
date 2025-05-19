<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Просмотр истории заказов пользователя
     */
    public function history()
    {
        $orders = Order::where('email', Auth::user()->email)
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('orders.history', compact('orders'));
    }

    /**
     * Просмотр деталей заказа
     */
    public function show(Order $order)
    {
        // Проверяем, что заказ принадлежит текущему пользователю ИЛИ пользователь - администратор
        if ($order->email !== Auth::user()->email && !Auth::user()->is_admin) {
            abort(403, 'Доступ запрещен');
        }

        $order->load('items.product');
        
        return view('orders.show', compact('order'));
    }
}