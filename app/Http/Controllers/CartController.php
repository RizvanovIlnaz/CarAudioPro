<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = $this->calculateTotal($cart);
        $itemCount = count($cart);
        
        return view('cart', compact('cart', 'total', 'itemCount'));
    }

    public function add(Product $product, Request $request)
    {
        $request->validate([
            'quantity' => 'sometimes|integer|min:1|max:10'
        ]);

        $quantity = $request->quantity ?? 1;
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->main_image,
                'max' => 10 // Максимальное количество
            ];
        }

        // Проверка на превышение максимального количества
        if ($cart[$product->id]['quantity'] > 10) {
            $cart[$product->id]['quantity'] = 10;
            session()->put('cart', $cart);
            return redirect()->back()
                ->with('warning', 'Максимальное количество товара - 10 шт.');
        }

        session()->put('cart', $cart);
        return redirect()->back()
            ->with('success', 'Товар добавлен в корзину')
            ->with('cart_item_count', count($cart));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $validated['quantity'];
            session()->put('cart', $cart);
            
            return redirect()->route('cart.index')
                ->with('success', 'Количество обновлено');
        }

        return redirect()->route('cart.index')
            ->with('error', 'Товар не найден в корзине');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            
            return redirect()->route('cart.index')
                ->with('success', 'Товар удален из корзины')
                ->with('cart_item_count', count($cart));
        }

        return redirect()->route('cart.index')
            ->with('error', 'Товар не найден в корзине');
    }

    private function calculateTotal($cart)
    {
        return array_reduce($cart, function($total, $item) {
            return $total + ($item['price'] * $item['quantity']);
        }, 0);
    }
}