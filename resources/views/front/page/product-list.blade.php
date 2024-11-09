@extends('front.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page title')
@section('content')

<div class="section-b-space">
    <div class="product-border border-row overflow-hidden">
            <div>
                <div class="row m-0">
                    <div class="col-12 px-0">
                        <div class="row">
                            @forelse ($products as $product)
                                <div class="col-md-3 col-sm-6 px-2 mb-4">
                                    <div class="product-box">
                                        <div class="product-image" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                                            <a href="{{ route('product.detail', ['id' => $product->id]) }}">
                                                <img src="/images/products/{{ $product->product_image }}"
                                                     class="img-fluid lazyload"
                                                     alt="{{ $product->name }}"
                                                     style="max-height: 180px; max-width: 100%; object-fit: contain;">
                                            </a>
                                            <ul class="product-option">
                                                <li title="View">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view">
                                                        <i class="ijaboIcon sx-1 dw dw-eye"></i>
                                                    </a>
                                                </li>
                                                <li title="Compare">
                                                    <a href="compare.html">
                                                        <i class="icon-copy dw dw-exchange"></i>
                                                    </a>
                                                </li>
                                                <li title="Wishlist">
                                                    <a href="wishlist.html" class="notifi-wishlist">
                                                        <i class="ijaboIcon sx-1 dw dw-heart"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="product-detail">
                                            <a href="{{ route('product.detail', ['id' => $product->id]) }}">
                                                <h6 class="name">{{ $product->name }}</h6>
                                            </a>
                                            <h5 class="sold text-content">
                                                <span class="theme-color price">${{ $product->price }}</span>
                                                @if ($product->compare_price)
                                                    <del>${{ $product->compare_price }}</del>
                                                @endif
                                            </h5>
                                            <div class="add-to-cart-box mt-2">
                                                <a href="cart.html"
                                                   class="btn btn-md bg-dark cart-button text-white w-100 btn-bg-color">
                                                    <i class="icon-copy bi bi-cart-plus-fill"></i> Add To Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-danger">No products found!</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
</div>

@endsection
