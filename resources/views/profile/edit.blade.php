@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Профиль пользователя') }}</div>

                <div class="card-body">
                    <!-- Сообщения об успешном выполнении -->
                    @if (session('status') == 'profile-updated')
                        <div class="alert alert-success" role="alert">
                            {{ __('Данные профиля успешно обновлены.') }}
                        </div>
                    @endif

                    @if (session('status') == 'password-updated')
                        <div class="alert alert-success" role="alert">
                            {{ __('Пароль успешно изменен.') }}
                        </div>
                    @endif

                    <!-- Форма основных данных -->
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Имя') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name', $user->name) }}" required autocomplete="name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ __('Пожалуйста, укажите ваше имя.') }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ __('Этот email уже занят.') }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Телефон') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       name="phone" value="{{ old('phone', $user->phone) }}" autocomplete="tel">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ __('Некорректный номер телефона.') }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Сохранить изменения') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Форма смены пароля -->
                    <form method="POST" action="{{ route('password.update') }}" class="mt-5">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="current_password" class="col-md-4 col-form-label text-md-end">{{ __('Текущий пароль') }}</label>

                            <div class="col-md-6">
                                <input id="current_password" type="password" 
                                       class="form-control @error('current_password') is-invalid @enderror" 
                                       name="current_password" required>

                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ __('Неверный текущий пароль.') }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Новый пароль') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" required>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ __('Пароль должен содержать не менее 8 символов, включая цифры и спецсимволы.') }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password_confirmation" class="col-md-4 col-form-label text-md-end">{{ __('Подтвердите пароль') }}</label>

                            <div class="col-md-6">
                                <input id="password_confirmation" type="password" 
                                       class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Изменить пароль') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Форма удаления профиля -->
                    <form method="POST" action="{{ route('profile.destroy') }}" class="mt-5">
                        @csrf
                        @method('delete')

                        <div class="row mb-3">
                            <label for="delete_password" class="col-md-4 col-form-label text-md-end">{{ __('Пароль для подтверждения') }}</label>

                            <div class="col-md-6">
                                <input id="delete_password" type="password" 
                                       class="form-control @error('delete_password') is-invalid @enderror" 
                                       name="delete_password" required>

                                @error('delete_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ __('Неверный пароль.') }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить свой аккаунт? Это действие нельзя отменить.')">
                                    {{ __('Удалить аккаунт') }}
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