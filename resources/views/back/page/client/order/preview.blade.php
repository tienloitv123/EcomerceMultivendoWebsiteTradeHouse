@extends('front.layout.pages-layout')
@section('pageTitle', 'Create order')
@section('content')
<div class="container">
    <h2>Your Order: </h2>

    <form action="{{ route('client.order.create') }}" method="POST">
        @csrf
        <input type="hidden" name="seller_id" value="{{ $seller_id }}">

        <div class="form-group">
            <label for="shipping_address">Address</label>
            <textarea name="shipping_address" id="shipping_address" class="form-control" required>{{ old('shipping_address', $shipping_address) }}</textarea>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $phone) }}" required>
        </div>

        <div class="form-group">
            <label for="payment_method">Payment method</label>
            <select name="payment_method" id="payment_method" class="form-control" required>
                <option value="COD" {{ $payment_method == 'COD' ? 'selected' : '' }}>Cash (COD)</option>
                <option value="CreditCard" {{ $payment_method == 'CreditCard' ? 'selected' : '' }}>Credit card</option>
                <option value="PayPal" {{ $payment_method == 'PayPal' ? 'selected' : '' }}>Momo</option>
            </select>
        </div>

        <h4>Order detail :</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartDetails as $detail)
                <tr>
                    <td>{{ $detail->product->name }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ number_format($detail->product->price, 2) }}</td>
                    <td>{{ number_format($detail->quantity * $detail->product->price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h4>Total amount: {{ number_format($totalAmount, 2) }} $</h4>
        <a href="{{ route('client.cart') }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success">Confirm order</button>
    </form>
</div>
@endsection
