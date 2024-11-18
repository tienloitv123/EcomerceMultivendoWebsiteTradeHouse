@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Order List')
 @section('content')
<div class="container mt-4">
    <h1>Order Management</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order Number</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->order->order_number }}</td>
                    <td>{{ $order->product->name }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>${{ number_format($order->total, 2) }}</td>
                    <td>{{ ucfirst($order->order->status) }}</td>
                    <td>
                        @if($order->order->status === 'pending')
                            <form action="{{ route('seller.orders.update', $order->id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="status" value="accepted">
                                <button type="submit" class="btn btn-success btn-sm">Accept</button>
                            </form>
                            <form action="{{ route('seller.orders.update', $order->id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        @elseif($order->order->status === 'accepted')
                            <form action="{{ route('seller.orders.update', $order->id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="status" value="delivery">
                                <button type="submit" class="btn btn-primary btn-sm">Delivery</button>
                            </form>
                        @else
                            <span class="text-muted">No Actions Available</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No orders available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
