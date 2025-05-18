<!-- resources/views/partials/header.blade.php -->
<header class="bg-dark text-white p-3">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <a href="/" class="text-white text-decoration-none">
                <h1 class="h4 mb-0">CarAudioPro</h1>
            </a>
            <nav>
                <a href="{{ route('catalog') }}" class="btn btn-light btn-sm">Каталог</a>
            </nav>
            <a href="{{ route('cart.index') }}" class="btn btn-outline-light position-relative">
    <i class="fas fa-shopping-cart"></i>
    Корзина
    @if(session('cart_item_count', 0) > 0)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ session('cart_item_count', 0) }}
        </span>
    @endif
</a>
        </div>
    </div>
</header>