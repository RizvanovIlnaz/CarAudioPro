@extends('layouts.app')

@section('title', 'Главная')
@section('content')

<section class="hero bg-light py-5">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Профессиональная автомобильная акустика</h1>
        <p class="lead text-muted mb-4 mx-auto" style="max-width: 600px;">
            Оборудование для идеального звука в вашем авто
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Рекомендованные товары</h2>
        
        @if($recommendedProducts->count() > 0)
        <div class="row g-4">
            @foreach($recommendedProducts as $product)
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 product-card">
                    @if($product->main_image)
                    <img src="{{ asset('storage/products/'.$product->main_image) }}" 
                         class="card-img-top p-3" 
                         alt="{{ $product->name }}">
                    @else
                    <div class="placeholder-image bg-light d-flex align-items-center justify-content-center">
                        <span class="text-muted">Нет изображения</span>
                    </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <div class="mt-auto">
                            <p class="card-text fw-bold h5">{{ number_format($product->price, 0, ',', ' ') }} ₽</p>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="number" name="quantity" value="1" min="1" class="form-control" style="width: 60px;">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-shopping-cart"></i> В корзину
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-center text-muted">Нет рекомендованных товаров</p>
        @endif
    </div>
</section>

<section class="bg-light py-5 mt-5">
    <div class="container">
        <h2 class="text-center mb-4">О компании</h2>
        <p class="text-center text-muted mx-auto" style="max-width: 800px;">
            CarAudioPro - предлагаем широкий ассортимент высококачественной автомобильной акустики.
            Мы предлагаем высококачественное оборудование для идеального звука в вашем автомобиле.
        </p>
    </div>
</section>

@endsection