@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Заказ №{{ $order->id }}</h4>
                        <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                            {{ $order->statusName }}
                        </span>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Информация о заказе</h5>
                            <p><strong>Дата:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
                            <p><strong>Имя:</strong> {{ $order->customer_name }}</p>
                            <p><strong>Телефон:</strong> {{ $order->phone }}</p>
                            <p><strong>Email:</strong> {{ $order->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Доставка</h5>
                            <p><strong>Адрес:</strong> {{ $order->address }}</p>
                            @if($order->comment)
                                <p><strong>Комментарий:</strong> {{ $order->comment }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <h5 class="mb-3">Состав заказа</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Товар</th>
                                    <th>Цена</th>
                                    <th>Количество</th>
                                    <th>Сумма</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item->product->main_image)
                                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" width="50" class="me-3">
                                                @endif
                                                <div>
                                                    <a href="{{ route('catalog.show', $item->product) }}" class="text-decoration-none">
                                                        {{ $item->product->name }}
                                                    </a>
                                                    @if($item->product->category)
                                                        <div class="small text-muted">{{ $item->product->category->name }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ number_format($item->price, 0, ',', ' ') }} ₽</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->price * $item->quantity, 0, ',', ' ') }} ₽</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Итого:</th>
                                    <th>{{ number_format($order->total, 0, ',', ' ') }} ₽</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('orders.history') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Назад к истории заказов
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection