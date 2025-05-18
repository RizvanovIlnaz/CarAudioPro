@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Каталог товаров</h1>
    
    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($product->main_image)
                            <img src="{{ asset('storage/'.$product->main_image) }}" 
                                 class="card-img-top" 
                                 alt="{{ $product->name }}">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ number_format($product->price, 0, ',', ' ') }} ₽</p>
                            
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                                @csrf
                                <div class="input-group mb-3">
                                    <input type="number" name="quantity" value="1" min="1" class="form-control">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-shopping-cart"></i> В корзину
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">Товары отсутствуют</div>
    @endif
</div>
@endsection