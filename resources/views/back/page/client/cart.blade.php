@extends('front.layout.pages-layout')
@section('pageTitle', 'Your Cart')
@section('content')

<div class="pt-5">
    <div class="container my-5">
        @if(session('message'))
        <p class="text-center text-danger">{{ session('message') }}</p>
    @elseif(!empty($cartShops) && count($cartShops) > 0)
        @foreach ($cartShops as $shop)
            <div class="cart-shop pt-4 mt-1 mb-1 border border-dark border-right-0 border-left-0">
                {{-- <h5 class="fw-bold mb-4"><a href="{{ route('shop.view', $shop['shop_id']) }}"> Shop : {{ $shop['shop_name'] }} </a></h5> --}}
                <h5 class="fw-bold mb-4">
                    <a href="{{ route('shop.view.bySeller', $shop['shop_id']) }}">Shop: {{ $shop['shop_name'] }}</a>
                </h5>
                @foreach ($shop['items'] as $item)
                    <div class="row align-items-center border-bottom py-3" id="cart-item-{{ $item->id }}">
                        <div class="col-2">
                            <img src="{{ asset('images/products/' . $item->product->product_image) }}" alt="Product Image" class="img-fluid">
                        </div>
                        <div class="col-2">
                            <p class="fw-bold mb-1">{{ $item->product->name }}</p>
                        </div>
                        <div class="col-2">
                            <span>${{ number_format($item->product->price, 2) }}</span>
                        </div>
                        <div class="col-2">
                            @if($item->product->compare_price)
                                <span><del>${{ number_format($item->product->compare_price, 2) }}</del></span>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                        <div class="col-2 d-flex align-items-center quantity-control">
                            <button class="btn btn-secondary btn-sm update-quantity px-2" data-cart-detail-id="{{ $item->id }}" data-action="decrease">-</button>
                            <input type="number" class="form-control quantity-input mx-1 text-center" data-cart-detail-id="{{ $item->id }}" value="{{ $item->quantity }}" min="1" style="width: 60px;">
                            <button class="btn btn-secondary btn-sm update-quantity px-2" data-cart-detail-id="{{ $item->id }}" data-action="increase">+</button>
                        </div>
                        <div class="col-1">
                            <span id="total-price-{{ $item->id }}">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-danger btn-sm remove-item-btn" data-cart-detail-id="{{ $item->id }}">X</button>
                        </div>
                    </div>
                @endforeach

                <div class="row justify-content-between align-items-center py-3">
                    <div class="col-6">
                        <h5>Total: <span id="shop-total-{{ $shop['shop_id'] }}">${{ number_format($shop['total'], 2) }}</span></h5>
                    </div>
                    <div class="col-2 text-end">
                        <form action="{{ route('client.order.preview') }}" method="GET">
                            <input type="hidden" name="seller_id" value="{{ $shop['shop_id'] }}">
                            <button type="submit" class="btn btn-primary">Checkout</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="text-center my-5">
            <h4>Your cart is empty.</h4>
            <p><a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a></p>
        </div>
    @endif
    </div>
</div>
<style>
    .quantity-control .btn {
    width: 30px;
    height: 30px;
    font-size: 16px;
    line-height: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quantity-control .quantity-input {
    width: 60px; /* Đặt độ rộng cho ô nhập */
    text-align: center;
}

</style>
<script>
      document.addEventListener('DOMContentLoaded', function() {
        // Tăng giảm số lượng sản phẩm
        document.querySelectorAll('.update-quantity').forEach(function(button) {
            button.addEventListener('click', function() {
                let cartDetailId = this.dataset.cartDetailId;
                let action = this.dataset.action;
                let quantityInput = document.querySelector(`.quantity-input[data-cart-detail-id="${cartDetailId}"]`);
                let currentQuantity = parseInt(quantityInput.value);

                // Tăng hoặc giảm số lượng
                if (action === 'increase') {
                    quantityInput.value = currentQuantity + 1;
                } else if (action === 'decrease' && currentQuantity > 1) {
                    quantityInput.value = currentQuantity - 1;
                }

                // Gửi yêu cầu AJAX để cập nhật số lượng
                updateQuantity(cartDetailId, quantityInput.value, true);
            });
        });

        // Chỉ cho phép nhập số và bắt sự kiện Enter trong ô nhập số lượng
        document.querySelectorAll('.quantity-input').forEach(function(input) {
            input.addEventListener('input', function() {
                // Chỉ cho phép số, ngăn không cho nhập chữ cái
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            // Bắt sự kiện Enter và cập nhật số lượng
            input.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    let cartDetailId = this.dataset.cartDetailId;
                    updateQuantity(cartDetailId, this.value, true);
                }
            });

            // Bắt sự kiện mất focus (blur) để tự động cập nhật khi rời khỏi ô nhập
            input.addEventListener('blur', function() {
                let cartDetailId = this.dataset.cartDetailId;
                updateQuantity(cartDetailId, this.value, false);
            });
        });

        // Hàm cập nhật số lượng qua AJAX
        function updateQuantity(cartDetailId, quantity, reloadPage = false) {
            fetch('{{ route("client.cart.updateQuantity") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ cart_detail_id: cartDetailId, quantity: quantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cập nhật tổng giá sản phẩm trực tiếp
                    document.querySelector(`#total-price-${cartDetailId}`).textContent = `$${data.totalPrice}`;

                    // Cập nhật tổng giá của shop nếu có phần tử hiển thị tổng
                    if (document.querySelector(`#shop-total-${data.shop_id}`)) {
                        document.querySelector(`#shop-total-${data.shop_id}`).value = `$${data.shopTotal}`;
                    }

                    // Reload lại trang nếu cần
                    if (reloadPage) {
                        location.reload();
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        }
    document.querySelectorAll('.remove-item-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            let cartDetailId = this.dataset.cartDetailId;

            // Gửi yêu cầu AJAX để xóa sản phẩm
            fetch('{{ route("client.cart.removeItem") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ cart_detail_id: cartDetailId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Ẩn phần tử sản phẩm trong giao diện
                    document.querySelector(`#cart-item-${cartDetailId}`).remove();

                    // Cập nhật lại tổng giá trị cho shop sau khi xóa
                    if (document.querySelector(`#shop-total-${data.shop_id}`)) {
                        document.querySelector(`#shop-total-${data.shop_id}`).value = `$${data.shopTotal}`;
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
