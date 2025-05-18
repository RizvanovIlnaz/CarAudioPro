<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display catalog of products
     */
    public function index()
{
    $products = Product::where('is_recommended', true)
               ->orderBy('created_at', 'desc')
               ->get();
    return view('catalog', compact('products'));
}

    /**
     * Display single product page
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}