<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $recommendedProducts = Product::where('is_recommended', true)->get();
        return view('home', compact('recommendedProducts'));
    }
}