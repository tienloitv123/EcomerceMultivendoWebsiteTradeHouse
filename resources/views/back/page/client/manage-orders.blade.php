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
        @foreach ($orders as $order)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Order Code: {{ $order->order_number }}</strong>
                <span class="badge
                    @if ($order->status === 'pending') bg-warning
                    @elseif ($order->status === 'accepted') bg-primary
                    @elseif ($order->status === 'delivery') bg-info
                    @elseif ($order->status === 'completed') bg-success
                    @elseif ($order->status === 'rejected') bg-danger
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total Price</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderDetails as $detail)
                            <tr>
                                <td>
                                    <div class="col-2">
                                        <img src="{{ $detail->product->product_image && file_exists(public_path('images/products/' . $detail->product->product_image))
                                                    ? asset('images/products/' . $detail->product->product_image)
                                                    : asset('images/default-product.png') }}"
                                             alt="Product Image" class="img-fluid">
                                    </div>
                                </td>
                                <td>{{ $detail->product->name }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>${{ number_format($detail->price, 2) }}</td>
                                <td>${{ number_format($detail->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-end">
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
        @endforeach
    @endif
</div>

<style>
    .card {
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .card-header {
        background-color: #f9f9f9;
    }

    .card-body {
        background-color: #fff;
    }

    .card-footer {
        background-color: #f9f9f9;
    }

    .table th, .table td {
        vertical-align: middle;
    }

    .table img {
        display: block;
        margin: auto;
    }
</style>

@endsection
