@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-sign-in-alt me-2"></i>{{ __('Вход в систему') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Поле Email -->
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">
                                <i class="fas fa-envelope me-2"></i>{{ __('Электронная почта') }}*
                            </label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required 
                                       autocomplete="email" autofocus
                                       placeholder="example@mail.ru">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>
                                            @if($message == 'The email field is required.')
                                                {{ 'Поле "Email" обязательно для заполнения' }}
                                            @elseif($message == 'The email must be a valid email address.')
                                                {{ 'Введите корректный email адрес' }}
                                            @elseif($message == 'These credentials do not match our records.')
                                                {{ 'Неверный email или пароль' }}
                                            @else
                                                {{ $message }}
                                            @endif
                                        </strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Поле Пароль -->
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">
                                <i class="fas fa-lock me-2"></i>{{ __('Пароль') }}*
                            </label>

                            <div class="col-md-6">
                                <input id="password" type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="current-password"
                                       placeholder="Не менее 8 символов">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>
                                            @if($message == 'The password field is required.')
                                                {{ 'Поле "Пароль" обязательно для заполнения' }}
                                            @elseif($message == 'The password must be at least 8 characters.')
                                                {{ 'Пароль должен содержать минимум 8 символов' }}
                                            @else
                                                {{ $message }}
                                            @endif
                                        </strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Чекбокс "Запомнить меня" -->
                       <!--  <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" 
                                           id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Запомнить меня') }}
                                    </label>
                                </div>
                            </div>
                        </div>
 -->
                        <!-- Кнопка входа -->
                        <div class="row mb-3">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-sign-in-alt me-2"></i>{{ __('Войти') }}
                                </button>

                                <!-- @if (Route::has('password.request'))
                                    <a class="btn btn-link text-decoration-none ms-2" href="{{ route('password.request') }}">
                                        {{ __('Забыли пароль?') }}
                                    </a>
                                @endif -->
                            </div>
                        </div>

                        <!-- Ссылка на регистрацию -->
                        <div class="row">
                            <div class="col-md-8 offset-md-4">
                                <p class="text-muted mb-0">
                                    {{ __('Ещё не зарегистрированы?') }}
                                    <a href="{{ route('register') }}" class="text-decoration-none fw-bold">
                                        {{ __('Создать аккаунт') }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection