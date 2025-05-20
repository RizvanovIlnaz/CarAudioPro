@extends('layouts.app')

@section('title', 'Оформление заказа')
@section('content')

<div class="container py-4">
    <h2 class="mb-4">Оформление заказа</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('checkout.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Ваше имя*</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ auth()->user()->name ?? old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="phone" class="form-label">Телефон*</label>
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                           id="phone" name="phone" value="{{ auth()->user()->phone ?? old('phone') }}" 
                           placeholder="+7 (XXX) XXX-XX-XX" required>
                    @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    @if(auth()->check() && auth()->user()->email)
                        <input type="email" class="form-control-plaintext" 
                               id="email" value="{{ auth()->user()->email }}" readonly>
                        <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                    @else
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    @endif
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="address" class="form-label">Адрес доставки*</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" 
                              id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="comment" class="form-label">Комментарий к заказу</label>
                    <textarea class="form-control @error('comment') is-invalid @enderror" 
                              id="comment" name="comment" rows="3">{{ old('comment') }}</textarea>
                    @error('comment')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
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