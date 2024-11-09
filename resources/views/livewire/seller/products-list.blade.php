<div class="product-wrap">
    <div class="product-list">
        <ul class="row">
            @forelse ($products as $product)
                <li class="col-lg-4 col-md-6 col-sm-12">
                    <div class="product-box">
                        <div class="product-image">
                            <a href="{{ route('product.detail', ['id' => $product->id]) }}">
                                <img src="/images/products/{{ $product->product_image }}" alt="{{ $product->name }}">
                            </a>
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
                        </div>
                    </div>
                </li>
            @empty
                <li class="col-12">
                    <span class="text-danger">No products found!</span>
                </li>
            @endforelse
        </ul>
    </div>
    {{ $products->links() }}
</div>
