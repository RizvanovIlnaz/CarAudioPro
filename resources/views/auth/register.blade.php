@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Регистрация') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Имя') }}*</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>
                                            @if($message == 'The name field is required.')
                                                {{ 'Поле "Имя" обязательно для заполнения.' }}
                                            @elseif($message == 'The name must not be greater than 255 characters.')
                                                {{ 'Имя не должно превышать 255 символов.' }}
                                            @else
                                                {{ $message }}
                                            @endif
                                        </strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}*</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>
                                            @if($message == 'The email field is required.')
                                                {{ 'Поле "Email" обязательно для заполнения.' }}
                                            @elseif($message == 'The email must be a valid email address.')
                                                {{ 'Введите корректный email адрес.' }}
                                            @elseif($message == 'The email has already been taken.')
                                                {{ 'Этот email уже занят.' }}
                                            @else
                                                {{ $message }}
                                            @endif
                                        </strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Телефон') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       name="phone" value="{{ old('phone') }}" autocomplete="tel"
                                       placeholder="+7 (XXX) XXX-XX-XX">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>
                                            @if($message == 'The phone must not be greater than 20 characters.')
                                                {{ 'Телефон не должен превышать 20 символов.' }}
                                            @else
                                                {{ $message }}
                                            @endif
                                        </strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Пароль') }}*</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="new-password"
                                       placeholder="Не менее 8 символов">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>
                                            @if($message == 'The password field is required.')
                                                {{ 'Поле "Пароль" обязательно для заполнения.' }}
                                            @elseif($message == 'The password must be at least 8 characters.')
                                                {{ 'Пароль должен содержать минимум 8 символов.' }}
                                            @elseif($message == 'The password confirmation does not match.')
                                                {{ 'Пароли не совпадают.' }}
                                            @else
                                                {{ $message }}
                                            @endif
                                        </strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Подтвердите пароль') }}*</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" 
                                       name="password_confirmation" required autocomplete="new-password"
                                       placeholder="Повторите пароль">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Зарегистрироваться') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection