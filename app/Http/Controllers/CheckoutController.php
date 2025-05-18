<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
{
    $cart = session()->get('cart', []);
    $total = array_reduce($cart, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);
    
    if (empty($cart)) {
        return redirect()->route('cart.index')->with('error', 'Корзина пуста');
    }

    return view('checkout', compact('cart', 'total'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'address' => 'required|string',
            'comment' => 'nullable|string'
        ]);

        $cart = session()->get('cart', []);
        $total = array_reduce($cart, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);

        DB::transaction(function() use ($validated, $cart, $total) {
            $order = Order::create([
                'customer_name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'address' => $validated['address'],
                'comment' => $validated['comment'],
                'total' => $total,
                'status' => 'new'
            ]);

            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }
        });

        session()->forget('cart');
        return redirect()->route('home')->with('success', 'Заказ успешно оформлен!');
    }
}