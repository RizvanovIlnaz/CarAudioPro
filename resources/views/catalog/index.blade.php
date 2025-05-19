@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-4">Каталог товаров</h1>
            
            <!-- Фильтры и поиск -->
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('catalog') }}" method="GET">
                        <div class="row">
                            <!-- Поиск -->
                            <div class="col-md-5 mb-3 mb-md-0">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Поиск по названию или описанию..." 
                                           value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Фильтр по категории -->
                            <div class="col-md-3 mb-3 mb-md-0">
                                <select name="category" class="form-select" onchange="this.form.submit()">
                                    <option value="">Все категории</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Фильтр рекомендуемых -->
                            <div class="col-md-2 mb-3 mb-md-0">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="recommended" 
                                           id="recommended" value="1" 
                                           {{ request('recommended') ? 'checked' : '' }}
                                           onchange="this.form.submit()">
                                    <label class="form-check-label" for="recommended">
                                        Рекомендуемые
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Сортировка -->
                            <div class="col-md-2">
                                <select name="sort" class="form-select" onchange="this.form.submit()">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Новые</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Цена ↑</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Цена ↓</option>
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>По названию</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Список товаров -->
            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4 col-lg-3 mb-4">
                            <div class="card h-100 product-card">
                                @if($product->main_image)
                                    <img src="{{ asset('storage/'.$product->main_image) }}" class="card-img-top" alt="{{ $product->name }}">
                                @else
                                    <div class="no-image-placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    @if($product->category)
                                        <span class="badge bg-secondary mb-2">{{ $product->category->name }}</span>
                                    @endif
                                    <p class="card-text">{{ number_format($product->price, 0, ',', ' ') }} ₽</p>
                                    
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-auto">
                                        @csrf
                                        <div class="input-group">
                                            <input type="number" name="quantity" value="1" min="1" class="form-control">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <a href="{{ route('catalog.show', $product) }}" class="btn btn-sm btn-outline-primary w-100">
                                        Подробнее
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Пагинация -->
                <div class="d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    Товары не найдены. Попробуйте изменить параметры поиска.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .product-card {
        transition: transform 0.2s;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .no-image-placeholder {
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        color: #6c757d;
        font-size: 3rem;
    }
</style>
@endsection