<!-- resources/views/livewire/home-products.blade.php -->
<div class="product-wrap">
    <div class="product-list">
        <ul class="row">
            @forelse ($products as $item)
                <li class="col-lg-4 col-md-6 col-sm-12">
                    <div class="product-box">
                        <div class="product-image">
                            <a href="{{ route('product.detail', ['id' => $item->id]) }}">
                                <img src="/images/products/{{ $item->product_image }}" alt="{{ $item->name }}">
                            </a>
                        </div>
                        <div class="product-caption">
                            <h4><a href="{{ route('product.detail', ['id' => $item->id]) }}">{{ $item->name }}</a></h4>
                            <div class="price">
                                @if ($item->compare_price)
                                    <del>${{ $item->compare_price }}</del>
                                @endif
                                <ins>${{ $item->price }}</ins>
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <li class="col-12">
                    <span class="text-danger">No product(s) found!</span>
                </li>
            @endforelse
        </ul>
        <div class="blog-pagination mb-30">
            <div class="btn-toolbar justify-content-center mb-15">
                <div class="btn-group">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
