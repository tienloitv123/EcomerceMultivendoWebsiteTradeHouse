@extends('front.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Trade House')
@section('content')

<!-- Home Section Start -->
<section class="home-section pt-2">
    <div class="container-fluid-lg">
        {{-- <div class="row g-4">
            <div class="col-xl-8 ratio_65">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img class="d-block w-100" src="/front/images/banner1.png" alt="First slide">
                      <div class="carousel-item">
                        <img class="d-block w-100" src="/front/images/home-banner-2.png" alt="Second slide">
                      </div>
                      <div class="carousel-item">
                        <img class="d-block w-100" src="/front/images/home-banner-3.png" alt="Third slide">
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 ratio_65">
                <div class="row g-4">
                    <div class="col-xl-12 col-md-6">
                        <div class="home-contain">
                            <img src="/front/images/home-banner-2.png" class="bg-img   lazyload" alt>
                            <div class="home-detail p-center-left home-p-sm w-75">
                                <div>
                                    <h2 class="mt-0 banner-label-color">BEST
                                        <span class="discount text-title">On</span>
                                    </h2>
                                    <h3 class="theme-color">Electronics
                                        Equipment</h3>
                                    <p class="w-75">Feugiat augue porta
                                        netus cubilia litora pulvinar
                                        habitasse</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-md-6">
                        <div class="home-contain">
                            <img src="/front/images/home-banner-3.png" class="bg-img   lazyload" alt>
                            <div class="home-detail p-center-left home-p-sm w-75">
                                <div>
                                    <h3 class="mt-0 theme-color fw-bold">Clothing
                                        & Accessories</h3>
                                    <h4 class="banner-label-color">Gravida
                                        congue</h4>
                                    <p class="organic">Hac fermentum
                                        phasellus neque sed faucibus</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img class="d-block w-100" src="/front/images/banner1.png" alt="First slide">
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="/front/images/banner2.png" alt="Second slide">
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="/front/images/banner3.png" alt="Third slide">
              </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</section>
<!-- Home Section End -->

 <!-- Product Section Start -->
 <section class="product-section">
    <div class="container-fluid-lg">
        <div class="row g-sm-4 g-3">
            <div class="col-xxl-3 col-xl-4 d-none d-xl-block">
                <div class="p-sticky">
                    <div class="category-menu">
                        <h3>Category</h3>
                        @if (count(get_categories()) > 0)
                            <ul>
                                @foreach (get_categories() as $category)
                                    <li>
                                        <div class="category-list">

                                                <img href="{{ route('category.search', $category->id) }}" src="/images/categories/{{ $category->category_image }}" class="lazyload" alt="{{ $category->category_name }}">
                                               <h5>
                                                <a href="{{ route('category.search', $category->id) }} javascript:void(0)">{{ $category->category_name }}</a>
                                                </h5>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="section-t-space">
                        <div class="category-menu">
                            <h3>Newest Products</h3>
                            <ul class="product-list border-0 p-0 d-block">
                                @if ($newestProducts->count() > 0)
                                    @foreach ($newestProducts as $product)
                                        <li>
                                            <div class="offer-product">
                                                <a href="{{ route('product.detail', ['id' => $product->id]) }}" class="offer-image">
                                                    <img src="/images/products/{{ $product->product_image }}" alt="{{ $product->name }}" class="lazyload img-fluid">
                                                </a>

                                                <div class="offer-detail">
                                                    <div>
                                                        <a href="{{ route('product.detail', ['id' => $product->id]) }}" class="text-title">
                                                            <h6 class="name">{{ $product->name }}</h6>
                                                        </a>
                                                        <h6 class="price theme-color">${{ number_format($product->price, 2) }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="text-center">
                                        <p>No new products available.</p>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xxl-9 col-xl-8">
                <div class="title title-flex">
                    <div>
                        <h2>Explore for the thing!!!</h2>
                        <p>The are some product is waiting for you !!</p>
                    </div>
                </div>


                    <div class="section-products">
                        <div class="container">
                            <div class="row">
                                @isset($featuredProducts)
                                    @foreach ($featuredProducts as $product)
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
                                    @endforeach
                                @else
                                    <p class="text-center">No products available. Please check back later!</p>
                                @endisset
                            </div>
                        </div>
                    </div>
                    {{-- <div class="section-products">
                        <div class="container">
                            <div class="row justify-content-center text-center mb-4">
                                <div class="col-md-8 col-lg-6">
                                    <h3>Featured Products</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 position-relative">
                                    <!-- Carousel Container -->
                                    <div class="carousel-container">
                                        <div class="product-carousel d-flex overflow-hidden">
                                            @isset($featuredProducts)
                                                @foreach ($featuredProducts as $index => $product)
                                                    <div class="product-card" style="min-width: 33.333%; max-width: 33.333%; display: {{ $index < 6 ? 'block' : 'none' }};">
                                                        <div id="product-{{ $product->id }}" class="single-product">
                                                            <!-- Product Image -->
                                                            <div class="part-1"
                                                                 style="background: url('/images/products/{{ $product->product_image }}') no-repeat center;
                                                                        background-size: cover;">
                                                                @if ($product->compare_price)
                                                                    <span class="discount">
                                                                        {{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}% Off
                                                                    </span>
                                                                @endif
                                                            </div>

                                                            <!-- Product Details -->
                                                            <div class="part-2 text-center">
                                                                <h3 class="product-title">
                                                                    <a href="{{ route('product.detail', ['id' => $product->id]) }}">
                                                                        {{ $product->name }}
                                                                    </a>
                                                                </h3>
                                                                @if ($product->compare_price)
                                                                    <h4 class="product-old-price">${{ number_format($product->compare_price, 2) }}</h4>
                                                                @endif
                                                                <h4 class="product-price">${{ number_format($product->price, 2) }}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="text-center">No products available. Please check back later!</p>
                                            @endisset
                                        </div>
                                    </div>

                                    <!-- Navigation Buttons -->
                                    <button class="carousel-btn prev-btn"><i class="fas fa-chevron-left"></i></button>
                                    <button class="carousel-btn next-btn"><i class="fas fa-chevron-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                <div class="title">
                    <h2>Shopping by Categories</h2>
                </div>

                @if ( count(get_categories()) > 0 )


                <div class="category-slider-2 product-wrapper no-arrow">
                    @foreach (get_categories() as $category)


                    <div>
                        <a href="javascript:void(0)" class="category-box">
                            <div>
                                <img src="/images/categories/{{ $category->category_image }}" class="  lazyload" alt>
                                <h5>{{ $category->category_name }}</h5>
                            </div>
                        </a>
                    </div>

                    @endforeach
                </div>

                @endif

                <div class="section-t-space">
                    <div class="banner-contain hover-effect">
                        <img src="/front/images/b.png" class="bg-img   lazyload" alt>
                        <div class="banner-details p-center banner-b-space w-100 text-center">
                            <div>
                                <h6 class="ls-expanded theme-color mb-sm-3 mb-1">OUR
                                    BEST</h6>
                                <h2 class="banner-title">ELECTRONICS</h2>
                                <h5 class="lh-sm mx-auto mt-1 text-content">SALE
                                    8% OFF</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="title section-t-space">
                    <h2>Latest on Blog</h2>
                    <p>This will be update in the next plan</p>
                </div>
                <div class="slider-3-blog ratio_65 no-arrow product-wrapper mb-4">
                    <div>
                        <div class="blog-box">
                            <div class="blog-box-image">
                                <a href="blog-detail.html" class="blog-image">
                                    <img src="/front/images/blog-image-1.png" class="bg-img   lazyload" alt>
                                </a>
                            </div>

                            <a href="blog-detail.html" class="blog-detail">
                                <h6>13 Jun, 2024</h6>
                                <h5>Proin primis et phasellus nisi
                                    ultrices maecenas enim potenti
                                    vestibulum
                                    praesent vulputate</h5>
                            </a>
                        </div>
                    </div>

                    <div>
                        <div class="blog-box">
                            <div class="blog-box-image">
                                <a href="blog-detail.html" class="blog-image">
                                    <img src="/front/images/blog-image-1.png" class="bg-img   lazyload" alt>
                                </a>
                            </div>

                            <a href="blog-detail.html" class="blog-detail">
                                <h6>10 March, 2024</h6>
                                <h5>Blandit consequat condimentum aenean
                                    mattis himenaeos purus venenatis
                                    auctor
                                    tellus</h5>
                            </a>
                        </div>
                    </div>

                    <div>
                        <div class="blog-box">
                            <div class="blog-box-image">
                                <a href="blog-detail.html" class="blog-image">
                                    <img src="/front/images/blog-image-1.png" class="bg-img   lazyload" alt>
                                </a>
                            </div>

                            <a href="blog-detail.html" class="blog-detail">
                                <h6>10 April, 2024</h6>
                                <h5>Montes tellus turpis integer semper
                                    leo per lacinia quam euismod
                                    senectus</h5>
                            </a>
                        </div>
                    </div>

                    <div>
                        <div class="blog-box">
                            <div class="blog-box-image">
                                <a href="blog-detail.html" class="blog-image">
                                    <img src="/front/images/blog-image-1.png" class="bg-img   lazyload" alt>
                                </a>
                            </div>

                            <a href="blog-detail.html" class="blog-detail">
                                <h6>20 March, 2024</h6>
                                <h5>ullamcorper ligula erat platea fusce
                                    pharetra proin volutpat a massa
                                    ac</h5>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>

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
    height: 300px; /* Fixed square dimension */
    overflow: hidden;
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

.carousel-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.8);
    border: none;
    cursor: pointer;
    padding: 10px;
    z-index: 10;
    font-size: 1.2rem;
}

.prev-btn {
    left: -10px;
}

.next-btn {
    right: -10px;
}

.section-products .single-product {
    margin-bottom: 30px;
    overflow: hidden;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    transition: transform 0.3s, box-shadow 0.3s;
}

.section-products .single-product:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

.section-products .single-product .part-1 {
    position: relative;
    height: 300px;
    transition: all 0.3s;
}

.section-products .single-product:hover .part-1 {
    transform: scale(1.05);
}

.section-products .single-product .part-1 .discount {
    position: absolute;
    top: 15px;
    left: 15px;
    background: #fe302f;
    color: #fff;
    font-size: 0.85rem;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 3px;
    text-transform: uppercase;
}

.section-products .single-product .part-1 ul {
    position: absolute;
    bottom: -50px;
    left: 15px;
    list-style: none;
    margin: 0;
    padding: 0;
    transition: bottom 0.5s, opacity 0.5s;
    opacity: 0;
}

.section-products .single-product:hover .part-1 ul {
    bottom: 15px;
    opacity: 1;
}

.section-products .single-product .part-1 ul li {
    display: inline-block;
    margin-right: 8px;
}

.section-products .single-product .part-1 ul li a {
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

.section-products .single-product .part-1 ul li a:hover {
    color: #fe302f;
}

.section-products .single-product .part-2 {
    padding: 15px;
    text-align: center;
}

.section-products .single-product .part-2 .product-title a {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    text-decoration: none;
    transition: color 0.3s;
}

.section-products .single-product .part-2 .product-title a:hover {
    color: #fe302f;
}

.section-products .single-product .part-2 h4 {
    margin: 5px 0;
    font-size: 1rem;
}

.section-products .single-product .part-2 .product-old-price {
    text-decoration: line-through;
    color: #888;
    margin-right: 10px;
}

</style>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const carousel = document.querySelector(".product-carousel");
    const products = document.querySelectorAll(".product-card");
    const prevBtn = document.querySelector(".prev-btn");
    const nextBtn = document.querySelector(".next-btn");

    let currentIndex = 0;
    const itemsPerPage = 3; // Show 3 products at a time
    const totalProducts = products.length;

    // Update visibility of products
    function updateCarousel() {
        const offset = -(currentIndex * 100 / itemsPerPage);
        carousel.style.transform = `translateX(${offset}%)`;
    }

    // Show next products
    nextBtn.addEventListener("click", function () {
        if (currentIndex < totalProducts / itemsPerPage - 1) {
            currentIndex++;
            updateCarousel();
        }
    });

    // Show previous products
    prevBtn.addEventListener("click", function () {
        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel();
        }
    });

    // Initialize carousel visibility
    updateCarousel();
});

$('#carouselExampleIndicators').carousel({
    interval: 3000,
    pause: 'hover'
});
</script>

@endsection
