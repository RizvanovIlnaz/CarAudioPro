<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
{
    $query = Product::query();
    
    // Фильтрация по категории
    if ($request->has('category')) {
        $query->where('category_id', $request->category);
    }
    
    // Поиск по названию
    if ($request->has('search')) {
        $query->where('name', 'like', '%'.$request->search.'%')
             ->orWhere('description', 'like', '%'.$request->search.'%');
    }
    
    // Фильтр рекомендуемых
    if ($request->has('recommended')) {
        $query->where('is_recommended', true);
    }
    
    // Сортировка
    switch ($request->input('sort', 'newest')) {
        case 'price_asc':
            $query->orderBy('price', 'asc');
            break;
        case 'price_desc':
            $query->orderBy('price', 'desc');
            break;
        case 'name':
            $query->orderBy('name', 'asc');
            break;
        default:
            $query->orderBy('created_at', 'desc');
    }
    
    $categories = Category::orderBy('name')->get();
    $products = $query->paginate(12);
    
    return view('catalog.index', compact('products', 'categories'));
}

public function show(Product $product)
{
    $recommendedProducts = Product::where('category_id', $product->category_id)
                                ->where('id', '!=', $product->id)
                                ->where('is_recommended', true)
                                ->limit(4)
                                ->get();
    
    return view('catalog.show', compact('product', 'recommendedProducts'));
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