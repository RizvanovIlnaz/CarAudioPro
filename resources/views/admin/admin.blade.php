<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Подключите ваши CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="admin-container">
        @include('admin.partials.sidebar') <!-- Если есть сайдбар -->
        
        <main class="admin-content">
            @yield('content')
        </main>
    </div>
    
    <!-- Подключите ваши JS -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>