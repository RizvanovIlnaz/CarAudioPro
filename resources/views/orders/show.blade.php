@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Заказ #{{ $order->id }}</h4>
                </div>
                
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Информация о заказе</h5>
                            <p>
                                <strong>Дата:</strong> 
                                @php
                                    $date = $order->created_at->setTimezone('Asia/Yekaterinburg');
                                @endphp
                                {{ $date->isoFormat('D MMMM YYYY, HH:mm') }}
                                <small class="text-muted"></small>
                            </p>
                            <p><strong>Статус:</strong> 
                                <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                                    {{ $order->statusName }}
                                </span>
                            </p>
                        </div>
                        <!-- Остальная часть шаблона -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection