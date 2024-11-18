@extends('front.layout.pages-layout')
@section('pageTitle', 'Manage Orders')
@section('content')

<div class="container mt-5">
    <h2>Manage Your Orders</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('fail'))
        <div class="alert alert-danger">{{ session('fail') }}</div>
    @endif

    @if ($orders->isEmpty())
        <p>No orders found!</p>
    @else
        <div class="accordion" id="ordersAccordion">
            @foreach ($orders as $order)
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="orderHeading{{ $order->id }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#orderCollapse{{ $order->id }}" aria-expanded="false" aria-controls="orderCollapse{{ $order->id }}">
                            <strong>Order #{{ $order->order_number }}</strong> - ${{ number_format($order->total_amount, 2) }}
                        </button>
                    </h2>
                    <div id="orderCollapse{{ $order->id }}" class="accordion-collapse collapse" aria-labelledby="orderHeading{{ $order->id }}" data-bs-parent="#ordersAccordion">
                        <div class="accordion-body">
                            <p><strong>Status:</strong>
                                <span class="badge
                                    @if ($order->status === 'pending') bg-warning
                                    @elseif ($order->status === 'accepted') bg-primary
                                    @elseif ($order->status === 'delivery') bg-info
                                    @elseif ($order->status === 'completed') bg-success
                                    @elseif ($order->status === 'rejected') bg-danger
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                            <ul class="list-group mb-3">
                                @foreach ($order->orderDetails as $detail)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $detail->product->name }}
                                        <span>${{ number_format($detail->total, 2) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            @if ($order->status === 'pending')
                                <form action="{{ route('client.orders.update', $order->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="action" value="cancel">
                                    <button type="submit" class="btn btn-danger btn-sm">Cancel Order</button>
                                </form>
                            @elseif ($order->status === 'delivery')
                                <form action="{{ route('client.orders.update', $order->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="action" value="received">
                                    <button type="submit" class="btn btn-success btn-sm">Mark as Received</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
<style>
    .accordion-button {
    font-size: 1rem;
}

.accordion-item {
    border: 1px solid #ddd;
    border-radius: 5px;
}

.accordion-body {
    background-color: #f9f9f9;
}

</style>

@endsection
