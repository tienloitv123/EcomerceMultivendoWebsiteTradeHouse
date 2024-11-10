@extends('front.layout.pages-layout')
@section('pageTitle', "Products in Category: $category->category_name")
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
    <div class="row">
        @if($products->isEmpty())
            <p>No products found in this category.</p>
        @else
            @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="/images/products/{{ $product->product_image }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">${{ number_format($product->price, 2) }}</p>
                            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>

@endsection
