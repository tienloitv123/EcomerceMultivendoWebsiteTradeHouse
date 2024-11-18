<h1>New Order Notification</h1>

<p>Dear {{ $shop->shop_name }},</p>

<p>You have received a new order. Below are the details:</p>

<h3>Order Number: {{ $order->order_number }}</h3>
<p>Total Amount: ${{ number_format($order->total_amount, 2) }}</p>
<p>Client Name: {{ $order->client->name }}</p>
<p>Shipping Address: {{ $order->shipping_address }}</p>
<p>Phone: {{ $order->phone }}</p>

<h3>Order Details:</h3>
<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orderDetails as $detail)
            <tr>
                <td>{{ $detail->product->name }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>${{ number_format($detail->price, 2) }}</td>
                <td>${{ number_format($detail->total, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
