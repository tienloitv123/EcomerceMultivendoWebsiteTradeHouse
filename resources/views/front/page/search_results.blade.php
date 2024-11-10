@extends('front.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page title')
@section('content')

<div class="container mt-4">
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

    <!-- Search Results -->
    <div class="row">
        @if($products->isEmpty())
            <p>No products found.</p>
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
        {{ $products->appends(['query' => $searchTerm])->links() }}
    </div>
</div>

@endsection

@push('scripts')
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
                            option.selected = subcategory.id == "{{ request('subcategory') }}";
                            subcategorySelect.appendChild(option);

                            // Include child subcategories as indented options
                            subcategory.children.forEach(child => {
                                const childOption = document.createElement('option');
                                childOption.value = child.id;
                                childOption.textContent = `-- ${child.subcategory_name}`;
                                childOption.selected = child.id == "{{ request('subcategory') }}";
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
@endpush
