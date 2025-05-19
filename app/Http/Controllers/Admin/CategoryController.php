<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\AdminMiddleware;

class CategoryController extends Controller
{
    public function __construct()
    {
       $this->middleware('admin');
    }

    public function index()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $category = new Category();
        $category->name = $validated['name'];
        $category->slug = Str::slug($validated['name']);
        $category->description = $validated['description'];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $category->image = basename($path);
        }

        $category->save();

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Категория успешно создана');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $category->name = $validated['name'];
        $category->slug = Str::slug($validated['name']);
        $category->description = $validated['description'];

        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            if ($category->image) {
                Storage::disk('public')->delete('categories/'.$category->image);
            }
            
            $path = $request->file('image')->store('categories', 'public');
            $category->image = basename($path);
        }

        $category->save();

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Категория успешно обновлена');
    }

    public function destroy(Category $category)
    {
        // Проверяем, нет ли товаров в этой категории
        if ($category->products()->exists()) {
            return back()->with('error', 'Нельзя удалить категорию, в которой есть товары');
        }

        // Удаляем изображение
        if ($category->image) {
            Storage::disk('public')->delete('categories/'.$category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Категория успешно удалена');
    }
}