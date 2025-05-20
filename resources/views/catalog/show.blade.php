@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row position-relative">
        <!-- Кнопка "Назад" -->
        <div class="col-12 mb-4">
            <a href="{{ route('catalog') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Назад в каталог
            </a>
        </div>

        <!-- Навигационные стрелки -->
        @if($previousProduct || $nextProduct)
            <div class="product-navigation">
                @if($previousProduct)
                    <a href="{{ route('catalog.show', $previousProduct) }}" 
                       class="nav-arrow nav-arrow-prev"
                       title="{{ $previousProduct->name }}">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                @endif

                @if($nextProduct)
                    <a href="{{ route('catalog.show', $nextProduct) }}" 
                       class="nav-arrow nav-arrow-next"
                       title="{{ $nextProduct->name }}">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                @endif
            </div>
        @endif

        <!-- Основное содержимое страницы товара -->
        <div class="col-md-6 mb-4 mb-md-0">
            @if($product->main_image)
                <img src="{{ asset('storage/'.$product->main_image) }}" 
                     class="img-fluid rounded" 
                     alt="{{ $product->name }}">
            @else
                <div class="no-image-placeholder-large">
                    <i class="fas fa-image"></i>
                </div>
            @endif
        </div>

        <div class="col-md-6">
            <h1 class="mb-3">{{ $product->name }}</h1>
            
            @if($product->category)
                <span class="badge bg-primary mb-3">{{ $product->category->name }}</span>
            @endif

            <div class="d-flex align-items-center mb-4">
                <h3 class="mb-0">{{ number_format($product->price, 0, ',', ' ') }} ₽</h3>
                @if($product->old_price)
                    <span class="text-muted ms-3 text-decoration-line-through">
                        {{ number_format($product->old_price, 0, ',', ' ') }} ₽
                    </span>
                @endif
            </div>

            <div class="mb-4">
                <form action="{{ route('cart.add', $product) }}" method="POST" class="d-flex align-items-center">
                    @csrf
                    <div class="input-group me-3" style="width: 120px;">
                        <input type="number" name="quantity" value="1" min="1" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-cart me-2"></i>В корзину
                    </button>
                </form>
            </div>

            <div class="product-description mb-4">
                <h5 class="mb-3">Описание</h5>
                <p>{{ $product->description }}</p>
            </div>
        </div>
    </div>

    <!-- Рекомендуемые товары -->
    @if($recommendedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">Рекомендуемые товары</h3>
                <div class="row">
                    @foreach($recommendedProducts as $product)
                        <div class="col-md-3 col-6 mb-4">
                            @include('catalog.partials.product-card', ['product' => $product])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    /* Стили для навигационных стрелок */
    .product-navigation {
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        transform: translateY(-50%);
        z-index: 10;
        pointer-events: none;
    }
    
    .nav-arrow {
        position: fixed;
        top: 50%;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #333;
        text-decoration: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        pointer-events: auto;
    }
    
    .nav-arrow:hover {
        background: #fff;
        color: #0d6efd;
        transform: translateY(-50%) scale(1.1);
    }
    
    .nav-arrow-prev {
        left: 20px;
    }
    
    .nav-arrow-next {
        right: 20px;
    }
    
    /* Адаптация для мобильных */
    @media (max-width: 768px) {
        .nav-arrow {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }
        
        .nav-arrow-prev {
            left: 10px;
        }
        
        .nav-arrow-next {
            right: 10px;
        }
    }
    
    /* Плейсхолдер для изображения */
    .no-image-placeholder-large {
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        color: #6c757d;
        font-size: 5rem;
        border-radius: 0.25rem;
    }
</style>
@endsection