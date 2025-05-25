@extends('layouts.app')

@section('title', 'Корзина')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Ваша корзина</h2>

    @if(empty($cart))
        <div class="alert alert-info">Корзина пуста</div>
        <a href="{{ route('catalog') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left me-2"></i> Вернуться в каталог
        </a>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 40%">Товар</th>
                        <th>Цена</th>
                        <th>Количество</th>
                        <th>Сумма</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                               <!--  @if($item['image'])
                                    <img src="{{ asset('storage/'.$item['image']) }}" 
                                         width="60" 
                                         height="60"
                                         class="rounded me-3 object-fit-cover" 
                                         alt="{{ $item['name'] }}">
                                @else
                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 60px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif -->
                                <div>{{ $item['name'] }}</div>
                            </div>
                        </td>
                        <td>{{ number_format($item['price'], 0, ',', ' ') }} ₽</td>
                        <td style="width: 150px">
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex">
                                @csrf
                                @method('PATCH')
                                <input type="number" 
                                       name="quantity" 
                                       value="{{ $item['quantity'] }}" 
                                       min="1" 
                                       max="{{ $item['max'] ?? 10 }}" 
                                       class="form-control quantity-input">
                                <button type="submit" class="btn btn-sm btn-outline-primary ms-2">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </form>
                        </td>
                        <td>{{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} ₽</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Удалить">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="{{ route('catalog') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Продолжить покупки
            </a>
            
            <div class="text-end">
                <h4 class="mb-0">Итого: {{ number_format($total, 0, ',', ' ') }} ₽</h4>
                <small class="text-muted">Товаров: {{ count($cart) }} шт.</small>
                <div class="mt-2">
                    <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-credit-card me-2"></i> Оформить заказ
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Авто-отправка формы при изменении количества
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
});
</script>
@endsection