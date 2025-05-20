@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-4">Каталог товаров</h1>
            
            <!-- Фильтры и поиск -->
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('catalog') }}" method="GET" id="auto-filter-form">
                        <div class="row">
                            <!-- Поиск -->
                            <div class="col-md-5 mb-3 mb-md-0">
                                <div class="input-group">
                                    <input type="text" 
                                           name="search" 
                                           class="form-control" 
                                           placeholder="Поиск по названию или описанию..." 
                                           value="{{ request('search') }}"
                                           id="search-input"
                                           autocomplete="off">
                                    <span class="input-group-text search-loader d-none">
                                        <div class="spinner-border spinner-border-sm" role="status">
                                            <span class="visually-hidden">Загрузка...</span>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Фильтр по категории -->
                            <div class="col-md-3 mb-3 mb-md-0">
                                <select name="category_id" class="form-select">
                                    <option value="">Все категории</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
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
                                           {{ request('recommended') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="recommended">
                                        Рекомендуемые
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Сортировка -->
                            <div class="col-md-2">
                                <select name="sort" class="form-select">
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
                                        <img src="{{ asset('storage/products/' . $product->main_image) }}" 
                                        class="card-img-top" 
                                        alt="{{ $product->name }}"
                                        style="height: 200px; object-fit: cover;">
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
                
                
            @else
                <div class="alert alert-info">
                    Товары не найдены. Попробуйте изменить параметры поиска.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('auto-filter-form');
    const searchInput = document.getElementById('search-input');
    const loader = document.querySelector('.search-loader');
    let searchTimeout;

    function submitForm() {
        loader.classList.remove('d-none');
        form.submit();
    }

    // Более агрессивная версия обработчиков
    const handleFilterChange = () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(submitForm, 800);
    };

    // Обработчики для всех элементов фильтрации
    searchInput.addEventListener('input', handleFilterChange);
    
    document.querySelectorAll('select[name="category_id"], select[name="sort"]')
        .forEach(el => el.addEventListener('change', handleFilterChange));
    
    document.querySelector('input[name="recommended"]')
        .addEventListener('change', submitForm); // Мгновенно для чекбокса
});
</script>

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
    .search-loader {
        display: none;
    }
</style>
@endsection

