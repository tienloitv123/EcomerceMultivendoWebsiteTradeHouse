@extends('front.layout.pages-layout')
@section('pageTitle', "$category->category_name")
@section('content')

<div class="container mt-4">
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Home Page</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Products in Category: "{{ $category->category_name }}"
            </li>
        </ol>
    </nav>
    <h2>Category: {{ $category->category_name }}</h2>

    <!-- Product Section -->
    <div class="section-products">
        <div class="container">
            <div class="row">
                @forelse ($products as $product)
                    <div class="col-md-6 col-lg-4">
                        <div id="product-{{ $product->id }}" class="single-product">
                            <!-- Product Image Section -->
                            <div class="part-1"
                                 style="background: url('/images/products/{{ $product->product_image }}') no-repeat center;
                                        background-size: cover;">
                                @if ($product->compare_price)
                                    <span class="discount">
                                        {{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}% Off
                                    </span>
                                @endif
                                <ul>
                                    <li>
                                        <a href="{{ route('product.detail', ['id' => $product->id]) }}">
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
                                    <a href="{{ route('product.detail', ['id' => $product->id]) }}">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                @if ($product->compare_price)
                                    <h4 class="product-old-price">
                                        ${{ number_format($product->compare_price, 2) }}
                                    </h4>
                                @endif
                                <h4 class="product-price">
                                    ${{ number_format($product->price, 2) }}
                                </h4>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">No products found in this category.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>

<style>
    /* Styles từ thẻ sản phẩm */
    @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');

    .section-products {
        padding: 50px 0;
    }

    .single-product {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        background: #fff;
        text-align: center;
        margin: 10px;
    }

    .single-product:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .part-1 {
        height: 300px;
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .part-2 {
        padding: 15px;
    }

    .product-title a {
        font-size: 1rem;
        font-weight: bold;
        color: #333;
        text-decoration: none;
        transition: color 0.3s;
    }

    .product-title a:hover {
        color: #fe302f;
    }

    .single-product .part-1 ul {
        position: absolute;
        bottom: -50px;
        left: 15px;
        list-style: none;
        margin: 0;
        padding: 0;
        transition: bottom 0.5s, opacity 0.5s;
        opacity: 0;
    }

    .single-product:hover .part-1 ul {
        bottom: 15px;
        opacity: 1;
    }

    .single-product .part-1 ul li {
        display: inline-block;
        margin-right: 8px;
    }

    .single-product .part-1 ul li a {
        display: block;
        width: 40px;
        height: 40px;
        background: #fff;
        color: #444;
        text-align: center;
        line-height: 40px;
        border-radius: 50%;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        transition: color 0.3s;
    }

    .single-product .part-1 ul li a:hover {
        color: #fe302f;
    }

    .single-product .part-2 h4 {
        margin: 5px 0;
        font-size: 1rem;
    }

    .single-product .part-2 .product-old-price {
        text-decoration: line-through;
        color: #888;
        margin-right: 10px;
    }
</style>

@endsection
