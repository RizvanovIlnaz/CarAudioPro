<!DOCTYPE html>
<html lang="ru" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarAudioPro - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- Добавляем Font Awesome для иконок -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Стили для корзины -->
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        .cart-count-badge {
            font-size: 0.6rem;
            top: -5px;
            right: -5px;
        }
        .quantity-input {
            width: 70px;
            text-align: center;
        }
        .product-card-img {
            height: 180px;
            object-fit: contain;
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
    @include('partials.header')

    <main class="py-4">
        <!-- Добавляем вывод сообщений об успехе/ошибке -->
        @if(session('success'))
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Добавляем jQuery для удобной работы с AJAX (опционально) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Скрипты для корзины -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Авто-отправка формы при изменении количества
            document.querySelectorAll('input[name="quantity"]').forEach(input => {
                input.addEventListener('change', function() {
                    this.closest('form').submit();
                });
            });
            
            // Авто-отправка формы при изменении количества в корзине
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    this.closest('form').submit();
                });
            });
            
            // Инициализация всплывающих подсказок
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>