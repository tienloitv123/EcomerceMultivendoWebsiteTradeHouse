@extends('front.layout.pages-layout')

@section('pageTitle', $shop->shop_name)

@section('content')
<div class="container my-5">
    <!-- Shop Details Section -->
    <div class="row mb-5 border border-dark border-right-0 border-left-0">
        <!-- Shop Logo -->
        <div class="col-md-3 d-flex align-items-center justify-content-center">
            <img src="{{ $shop->shop_logo ? asset('images/shop/' . $shop->shop_logo) : asset('images/shops/shop.png') }}"
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
    <div class="section-products">
        <div class="container">
            <div class="row" id="product-list">
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
                    <div class="col-12">
                        <p class="text-danger text-center">No products found in this shop.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Pagination Switcher -->
    <div class="pagination mt-4 d-flex justify-content-center">
        <button class="prev" onclick="switchPage('prev')">&lt;</button>
        <span class="page-number" id="current-page">{{ $products->currentPage() }}</span>
        <button class="next" onclick="switchPage('next')">&gt;</button>
    </div>
</div>

<!-- JavaScript for Pagination -->
<script>
    let currentPage = {{ $products->currentPage() }};
    const totalPages = {{ $products->lastPage() }};

    function switchPage(action) {
        if (action === 'prev' && currentPage > 1) {
            currentPage--;
        } else if (action === 'next' && currentPage < totalPages) {
            currentPage++;
        }

        // Update the page number in the UI
        document.getElementById('current-page').textContent = currentPage;

        // Fetch products for the new page
        fetch(`/shop/{{ $shop->id }}?page=${currentPage}`)
            .then(response => response.text())
            .then(data => {
                const parser = new DOMParser();
                const htmlDoc = parser.parseFromString(data, 'text/html');
                const newProducts = htmlDoc.querySelector('#product-list').innerHTML;
                document.getElementById('product-list').innerHTML = newProducts;
            })
            .catch(error => console.error('Error:', error));
    }
</script>

<style>
    .pagination {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pagination button {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #888;
        transition: color 0.3s;
    }

    .pagination button:hover {
        color: #333;
    }

    .page-number {
        margin: 0 10px;
        padding: 5px 15px;
        background-color: #fe302f;
        color: #fff;
        font-weight: bold;
        font-size: 16px;
        border-radius: 5px;
        display: inline-block;
        text-align: center;
    }
</style>
@endsection
