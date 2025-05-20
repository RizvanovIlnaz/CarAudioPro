<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Ваша корзина пуста. Добавьте товары перед оформлением заказа.');
        }

        $total = array_reduce($cart, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);
        $user = Auth::user();
        
        return view('checkout', compact('cart', 'total', 'user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[а-яА-ЯёЁa-zA-Z\s\-]+$/u'
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^\+?[0-9\s\-\(\)]{10,20}$/'
            ],
            'email' => [
                $user->email ? 'nullable' : 'required',
                'email',
                'max:255',
                Rule::in([$user->email]) // Запрещаем изменение email
            ],
            'address' => [
                'required',
                'string',
                'max:500',
                'regex:/^[а-яА-ЯёЁ0-9\s\-\.,\/]+$/u'
            ],
            'comment' => [
                'nullable',
                'string',
                'max:1000'
            ]
        ], [
            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'name.regex' => 'Имя может содержать только буквы и дефисы.',
            'phone.required' => 'Поле "Телефон" обязательно для заполнения.',
            'phone.regex' => 'Введите корректный номер телефона.',
            'email.required' => 'Поле "Email" обязательно для заполнения.',
            'email.email' => 'Введите корректный email адрес.',
            'email.in' => 'Вы не можете изменить email при оформлении заказа.',
            'address.required' => 'Поле "Адрес" обязательно для заполнения.',
            'address.regex' => 'Адрес содержит недопустимые символы.'
        ]);

        // Принудительно используем email пользователя
        $validated['email'] = $user->email;

        $cart = session()->get('cart', []);
        $total = array_reduce($cart, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);

        $order = DB::transaction(function() use ($validated, $cart, $total, $user) {
            $order = Order::create([
                'user_id' => $user->id,
                'customer_name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $user->email, // Всегда используем email из профиля
                'address' => $validated['address'],
                'comment' => $validated['comment'] ?? null,
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

            return $order;
        });

        session()->forget('cart');
        
        return redirect()->route('home')->with('success', [
            'title' => 'Заказ успешно оформлен!',
            'message' => 'Номер вашего заказа: #' . $order->id
        ]);
    }
}