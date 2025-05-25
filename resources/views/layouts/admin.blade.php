<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | {{ config('app.name') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="admin-layout">
    <div class="admin-wrapper">
        @include('admin.partials.sidebar')
        
        <div class="admin-content">
            @yield('content')
        </div>
    </div>
</body>
</html>