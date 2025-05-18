@extends('layouts.app')

@section('title', 'Оформление заказа')
@section('content')

<div class="container py-4">
    <h2 class="mb-4">Оформление заказа</h2>

    <form action="{{ route('checkout.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Ваше имя*</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                
                <div class="mb-3">
                    <label for="phone" class="form-label">Телефон*</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="address" class="form-label">Адрес доставки*</label>
                    <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="comment" class="form-label">Комментарий к заказу</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                </div>
            </div>
        </div>

        <div class="text-end mt-4">
            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary me-2">Назад</a>
            <button type="submit" class="btn btn-primary">Подтвердить заказ</button>
        </div>
    </form>
</div>

@endsection