<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
{
    $query = Product::query()->with('category');
    
    // Фильтр по категории
    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }
    
    // Поиск (уменьшил минимальную длину до 2 символов)
    if ($request->filled('search') && strlen($request->search) >= 2) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }
    
    // Фильтр рекомендуемых
    if ($request->has('recommended')) {
        $query->where('is_recommended', true);
    }
    
    // Сортировка
    switch ($request->input('sort', 'newest')) {
        case 'price_asc': $query->orderBy('price'); break;
        case 'price_desc': $query->orderByDesc('price'); break;
        case 'name': $query->orderBy('name'); break;
        default: $query->latest();
    }
    
    $products = $query->get();
    $categories = Category::orderBy('name')->get();
    
    return view('catalog.index', compact('products', 'categories'));


}

public function show(Product $product)
{
    // Получаем предыдущий и следующий товары
    $previousProduct = Product::where('id', '<', $product->id)
        ->orderBy('id', 'desc')
        ->first();

    $nextProduct = Product::where('id', '>', $product->id)
        ->orderBy('id', 'asc')
        ->first();

    // Рекомендуемые товары
    $recommendedProducts = Product::where('category_id', $product->category_id)
                                ->where('id', '!=', $product->id)
                                ->where('is_recommended', true)
                                ->limit(4)
                                ->get();
    
    return view('catalog.show', compact(
        'product', 
        'recommendedProducts',
        'previousProduct',
        'nextProduct'
    ));
}
    /**
     * Отображение каталога товаров с фильтрацией
     */
    /* public function index(Request $request)
    {
        // Получаем параметры фильтрации из запроса
        $search = $request->input('search');
        $categoryId = $request->input('category');
        $recommended = $request->has('recommended');
        $sort = $request->input('sort', 'newest');

        // Начинаем построение запроса
        $productsQuery = Product::query();

        // Применяем фильтры
        if ($search) {
            $productsQuery->where('name', 'like', "%{$search}%")
                         ->orWhere('description', 'like', "%{$search}%");
        }

        if ($categoryId) {
            $productsQuery->where('category_id', $categoryId);
        }

        if ($recommended) {
            $productsQuery->recommended();
        }

        // Применяем сортировку
        switch ($sort) {
            case 'price_asc':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $productsQuery->orderBy('price', 'desc');
                break;
            case 'name':
                $productsQuery->orderBy('name', 'asc');
                break;
            default:
                $productsQuery->orderBy('created_at', 'desc');
        }

        // Получаем все категории для фильтра
        $categories = Category::orderBy('name')->get();

        // Пагинация результатов (по 12 товаров на странице)
        $products = $productsQuery->paginate(12)->withQueryString();

        return view('catalog.index', compact('products', 'categories'));
    }

    /**
     * Отображение страницы товара
     
    public function show(Product $product)
    {
        // Рекомендуемые товары из той же категории
        $recommendedProducts = Product::where('category_id', $product->category_id)
                                    ->where('id', '!=', $product->id)
                                    ->recommended()
                                    ->limit(4)
                                    ->get();

        return view('catalog.show', compact('product', 'recommendedProducts'));
    } */
}