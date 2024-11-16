@extends('front.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : $product->name)
@section('content')

    <div class="container">
        <!-- Phần chi tiết sản phẩm chính -->
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
                                <input type="number" name="quantity" value="1" min="1" max="10"
                                    class="form-control" />
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

        <div class="section-b-space">
            <h4 class="mb-4">Other Products</h4>
            <div class="product-list">
                <ul class="row">
                    @forelse ($relatedProducts as $relatedProduct)
                        <li class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="product-box">
                                <div class="product-img">
                                    <a href="{{ route('product.detail', ['id' => $relatedProduct->id]) }}">
                                        <img src="/images/products/{{ $relatedProduct->product_image }}"
                                            alt="{{ $relatedProduct->name }}" class="img-fluid"
                                            style="max-height: 200px; object-fit: contain;">
                                    </a>
                                </div>
                                <div class="product-caption">
                                    <h4><a
                                            href="{{ route('product.detail', ['id' => $relatedProduct->id]) }}">{{ $relatedProduct->name }}</a>
                                    </h4>
                                    <div class="price">
                                        @if ($relatedProduct->compare_price)
                                            <del>${{ $relatedProduct->compare_price }}</del>
                                        @endif
                                        <ins>${{ $relatedProduct->price }}</ins>
                                    </div>
                                    <a href="{{ route('product.detail', ['id' => $relatedProduct->id]) }}"
                                        class="btn btn-outline-primary btn-sm mt-2">Read More</a>
                                </div>
                            </div>
                        </li>
                    @empty
                        <p class="text-danger">No related products found!</p>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

@endsection
