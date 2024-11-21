@extends('front.layout.pages-layout')
@section('pageTitle', "Search Results for: $searchTerm")
@section('content')

<div class="container mt-4">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Home Page</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Search Results for: "{{ $searchTerm }}"
            </li>
        </ol>
    </nav>

  <!-- Shop Search Results -->
@if(isset($shops) && $shops->isNotEmpty())
<div class="shop-search-results mb-5">
    <h4>Shops Related to "{{ $searchTerm }}"</h4>
    <div class="row">
        @foreach($shops as $shop)
            <div class="col-md-6 mb-4">
                <div class="card p-3 d-flex align-items-center">
                    <!-- Shop Logo -->
                    <a href="{{ route('shop.view', ['id' => $shop->id]) }}">
                        <img src="{{ $shop->shop_logo ? asset('images/shop/' . $shop->shop_logo) : asset('images/shops/shop.png') }}"
                            alt="{{ $shop->shop_name }}" class="img-fluid rounded-circle"
                            style="width: 100px; height: 100px; object-fit: cover;">
                    </a>

                    <!-- Shop Details -->
                    <div class="text-center mt-3">
                        <h5 class="fw-bold">
                            <a href="{{ route('shop.view', ['id' => $shop->id]) }}" class="text-dark">
                                {{ $shop->shop_name }}
                            </a>
                        </h5>
                        <p class="text-muted">{{ $shop->shop_description }}</p>
                        <p><strong>Phone:</strong> {{ $shop->shop_phone }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

    <!-- Filter Form -->
    <form id="product-filter-form" action="{{ route('product.filter') }}" method="GET" class="mb-4">
        <!-- Persist search term -->
        <input type="hidden" name="query" value="{{ $searchTerm }}">

        <div class="row">
            <!-- Category Filter -->
            <div class="col-md-4">
                <label for="category">Category:</label>
                <select name="category" id="category" class="form-control">
                    <option value="">Select Category</option>
                    @foreach (get_categories() as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Combined Subcategory Filter -->
            <div class="col-md-4">
                <label for="subcategory">Subcategory:</label>
                <select name="subcategory" id="subcategory" class="form-control">
                    <option value="">Select Subcategory</option>
                </select>
            </div>

            <!-- Price Order Filter -->
            <div class="col-md-4">
                <label for="price">Sort By Price:</label>
                <select name="price" id="price" class="form-control">
                    <option value="">Select Order</option>
                    <option value="asc" {{ request('price') == 'asc' ? 'selected' : '' }}>Low to High</option>
                    <option value="desc" {{ request('price') == 'desc' ? 'selected' : '' }}>High to Low</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Filter</button>
    </form>
    <!-- Product Search Results -->
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
                    <div class="col-12">
                        <p class="text-danger text-center">No products found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $products->appends(['query' => $searchTerm])->links() }}
    </div>
</div>

<style>
    .shop-search-results .card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .shop-search-results .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .shop-search-results img {
        width: 100px;
        height: 100px;
        object-fit: cover;
    }

    .shop-search-results h4 {
        font-size: 1.2rem;
        font-weight: bold;
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categorySelect = document.getElementById('category');
        const subcategorySelect = document.getElementById('subcategory');

        // Load subcategories based on selected category
        categorySelect.addEventListener('change', function () {
            const categoryId = this.value;
            subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';

            if (categoryId) {
                fetch(`/api/subcategories?category_id=${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(subcategory => {
                            const option = document.createElement('option');
                            option.value = subcategory.id;
                            option.textContent = subcategory.subcategory_name;
                            subcategorySelect.appendChild(option);

                            // Include child subcategories as indented options
                            subcategory.children.forEach(child => {
                                const childOption = document.createElement('option');
                                childOption.value = child.id;
                                childOption.textContent = `-- ${child.subcategory_name}`;
                                subcategorySelect.appendChild(childOption);
                            });
                        });
                    });
            }
        });

        // Preload subcategories if category is already selected
        if (categorySelect.value) {
            categorySelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endsection
