@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            @if($product->main_image)
                <img src="{{ asset('storage/'.$product->main_image) }}" class="img-fluid rounded" alt="{{ $product->name }}">
            @else
                <div class="no-image-placeholder-detail">
                    <i class="fas fa-image"></i>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('catalog') }}">Каталог</a></li>
                    @if($product->category)
                        <li class="breadcrumb-item">
                            <a href="{{ route('catalog', ['category' => $product->category->id]) }}">
                                {{ $product->category->name }}
                            </a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>
            
            <h1>{{ $product->name }}</h1>
            
            @if($product->category)
                <span class="badge bg-primary">{{ $product->category->name }}</span>
            @endif
            
            <div class="my-4">
                <h3 class="text-primary">{{ number_format($product->price, 0, ',', ' ') }} ₽</h3>
            </div>
            
            <form action="{{ route('cart.add', $product) }}" method="POST" class="mb-4">
                @csrf
                <div class="input-group" style="max-width: 200px;">
                    <input type="number" name="quantity" value="1" min="1" class="form-control">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-shopping-cart me-2"></i>В корзину
                    </button>
                </div>
            </form>
            
            <div class="card mb-4">
                <div class="card-header">
                    Описание
                </div>
                <div class="card-body">
                    {!! nl2br(e($product->description ?? 'Описание отсутствует')) !!}
                </div>
            </div>
        </div>
    </div>
    
    @if($recommendedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">Рекомендуемые товары</h3>
                <div class="row">
                    @foreach($recommendedProducts as $recommended)
                        <div class="col-md-3 col-6 mb-4">
                            <div class="card h-100">
                                <a href="{{ route('catalog.show', $recommended) }}">
                                    @if($recommended->main_image)
                                        <img src="{{ asset('storage/'.$recommended->main_image) }}" class="card-img-top" alt="{{ $recommended->name }}">
                                    @endif
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{ route('catalog.show', $recommended) }}" class="text-decoration-none">
                                            {{ $recommended->name }}
                                        </a>
                                    </h5>
                                    <p class="card-text">{{ number_format($recommended->price, 0, ',', ' ') }} ₽</p>
                                </div>
                            </div>
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
    .no-image-placeholder-detail {
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