@extends('front.layout.pages-layout')

@section('pageTitle', $shop->shop_name)

@section('content')
<div class="container my-5">
    <!-- Shop Details Section -->
    <div class="row mb-5 border border-dark border-right-0 border-left-0 ">
        <!-- Shop Logo -->
        <div class="col-md-3 d-flex align-items-center justify-content-center">
            <img src="{{ $shop->shop_logo != null ? asset('images/shop/' . $shop->shop_logo) : asset('images/shops/shop.png') }}"
                 alt="{{ $shop->shop_name }}"
                 class="img-fluid rounded-circle"
                 style="width: 150px; height: 150px; object-fit: cover;">
        </div>

        <!-- Shop Details -->
        <div class="col-md-9 d-flex flex-column justify-content-center">
            <h1 class="fw-bold">{{ $shop->shop_name }}</h1>
            <p class="text-muted">{{ $shop->shop_description }}</p>
            <p><strong>Phone:</strong> {{ $shop->shop_phone }}</p>
            <p><strong>Address:</strong> {{ $shop->shop_address }}</p>
        </div>
    </div>

    <!-- Products Section -->
    <div class="row">
        @forelse ($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card">
                    <img src="/images/products/{{ $product->product_image }}"
                         class="card-img-top"
                         alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">
                            @if ($product->compare_price)
                                <del>${{ number_format($product->compare_price, 2) }}</del>
                            @endif
                            <strong>${{ number_format($product->price, 2) }}</strong>
                        </p>
                        <a href="{{ route('product.detail', $product->id) }}" class="btn btn-primary btn-sm">View Product</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-danger text-center">No products found in this shop.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
</div>

<style>

.card {
    border: 1px solid #e0e0e0;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card-img-top {
    height: 200px;
    object-fit: contain;
}

.img-fluid {
    max-width: 100%;
    height: auto;
}

.rounded-circle {
    width: 150px;
    height: 150px;
    object-fit: cover;
}

</style>
@endsection
