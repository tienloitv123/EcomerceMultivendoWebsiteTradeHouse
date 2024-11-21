@extends('front.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : $product->name)
@section('content')

<div class="container">
    <!-- Product Detail Section -->
    <div class="product-detail-wrap mb-30">
        <div class="row no-gutters">
            <div class="col-lg-6 col-md-12 col-sm-12 d-flex justify-content-center">
                <div class="product-slide" style="padding: 10px; background-color: #ffffff; border: 2px solid #e0e0e0;">
                    <img src="/images/products/{{ $product->product_image }}" alt="{{ $product->name }}" class="img-fluid"
                        style="max-width: 100%; height: 600px; object-fit: contain;" />
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 d-flex align-items-center">
                <div class="product-detail-desc pd-20 card-box height-100-p" style="margin-left: -2px;">
                    <h4 class="mb-20 pt-20">{{ $product->name }}</h4>
                    <p>{!! $product->summary !!}</p>
                    <div class="price">
                        @if ($product->compare_price)
                            <del>${{ $product->compare_price }}</del>
                        @endif
                        <ins>${{ $product->price }}</ins>
                    </div>
                    <form action="{{ route('client.cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="form-group">
                            <label class="text-blue">Quantity</label>
                            <input type="number" name="quantity" value="1" min="1" max="10" class="form-control" />
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6 col-6">
                                <button type="submit" class="btn btn-primary btn-block">Add To Cart</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Shop Information Section -->
    @if ($shop)
        <div class="card mb-4">
            <div class="card-body d-flex align-items-center">
                <!-- Shop Logo -->
                <div class="me-3">
                    <a href="{{ route('shop.view', ['id' => $shop->id]) }}">
                        <img src="{{ $shop->shop_logo ? asset('images/shop/' . $shop->shop_logo) : asset('images/shops/shop.png') }}"
                            alt="Shop : {{ $shop->shop_name }}" class="img-fluid rounded-circle"
                            style="width: 100px; height: 100px; object-fit: cover;">
                    </a>
                </div>
                <!-- Shop Details -->
                <div>
                    <h5 class="card-title">
                        <a href="{{ route('shop.view', ['id' => $shop->id]) }}" class="text-dark fw-bold">
                            {{ $shop->shop_name }}
                        </a>
                    </h5>
                    <p class="mb-1"><strong>Phone:</strong> {{ $shop->shop_phone }}</p>
                    <p class="mb-1"><strong>Address:</strong> {{ $shop->shop_address }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Related Products Section -->
    <h4 class="mb-4">Other Products</h4>
    <div class="section-products">
        <div class="container">
            <div class="row">
                @forelse ($relatedProducts as $relatedProduct)
                    <div class="col-md-6 col-lg-4">
                        <div id="product-{{ $relatedProduct->id }}" class="single-product">
                            <!-- Product Image Section -->
                            <div class="part-1"
                                 style="background: url('/images/products/{{ $relatedProduct->product_image }}') no-repeat center;
                                        background-size: cover;">
                                @if ($relatedProduct->compare_price)
                                    <span class="discount">
                                        {{ round((($relatedProduct->compare_price - $relatedProduct->price) / $relatedProduct->compare_price) * 100) }}% Off
                                    </span>
                                @endif
                                <ul>
                                    <li>
                                        <a href="{{ route('product.detail', ['id' => $relatedProduct->id]) }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fas fa-heart"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fas fa-shopping-cart"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- Product Details Section -->
                            <div class="part-2">
                                <h3 class="product-title">
                                    <a href="{{ route('product.detail', ['id' => $relatedProduct->id]) }}">
                                        {{ $relatedProduct->name }}
                                    </a>
                                </h3>
                                @if ($relatedProduct->compare_price)
                                    <h4 class="product-old-price">
                                        ${{ number_format($relatedProduct->compare_price, 2) }}
                                    </h4>
                                @endif
                                <h4 class="product-price">
                                    ${{ number_format($relatedProduct->price, 2) }}
                                </h4>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-danger">No related products found!</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
