<header class="pb-md-4 pb-0">

    <div class="top-nav top-header sticky-header">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="navbar-top">
                        <button class="navbar-toggler d-xl-none d-inline navbar-menu-button" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#primaryMenu">
                            <span class="navbar-toggler-icon">
                                <i class="fa fa-bars"></i>
                            </span>
                        </button>
                        <a href="/" class="web-logo nav-logo">
                            <img src="/images/site/{{ get_settings()->site_logo }}" class="img-fluid  " alt>
                        </a>

                        <div class="middle-box">

                            <div class="search-box">
                                <div class="input-group">
                                    <input type="search" class="form-control" placeholder="What are you looking for?"
                                        aria-describedby="button-addon2">
                                    <button class="btn" type="button" id="button-addon2">
                                        <i class="icon-copy dw dw-search2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="rightside-box">
                            <div class="search-full">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i data-feather="search" class="font-light"></i>
                                    </span>
                                    <input type="text" class="form-control search-type" placeholder="Search here..">
                                    <span class="input-group-text close-search">
                                        <i data-feather="x" class="font-light"></i>
                                    </span>
                                </div>
                            </div>
                            <ul class="right-side-menu">
                                <li class="right-side">
                                    <div class="delivery-login-box">
                                        <div class="delivery-icon">
                                            <div class="search-box">
                                                <i data-feather="search"></i>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="right-side">
                                    <a href="contact-us.html" class="delivery-login-box">
                                        <div class="delivery-icon">
                                            <i class="ijaboIcon icon-copy dw dw-phone-call"></i>
                                        </div>
                                        <div class="delivery-detail">
                                            <h6>24/7 Delivery</h6>
                                            <h5>+254 123 456 7890</h5>
                                        </div>
                                    </a>
                                </li>
                                <li class="right-side">
                                    <a href="wishlist.html" class="btn p-0 position-relative header-wishlist">
                                        <i class="ijaboIcon icon-copy ti-heart"></i>
                                    </a>
                                </li>
                                <li class="right-side">
                                    <div class="onhover-dropdown header-badge">
                                        <button type="button" class="btn p-0 position-relative header-wishlist">
                                            <i class="ijaboIcon icon-copy dw dw-shopping-cart2"></i>
                                            <span class="position-absolute top-0 start-100 translate-middle badge">2
                                                <span class="visually-hidden">unread
                                                    messages</span>
                                            </span>
                                        </button>

                                        <div class="onhover-div">
                                            <ul class="cart-list">
                                                <li class="product-box-contain">
                                                    <div class="drop-cart">
                                                        <a href="product-detail.html" class="drop-image">
                                                            <img src="/front/images/product img place holder 1.png"
                                                                class="" alt>
                                                        </a>

                                                        <div class="drop-contain">
                                                            <a href="product-detail.html">
                                                                <h5>Product
                                                                    name
                                                                    here</h5>
                                                            </a>
                                                            <h6><span>3
                                                                    x</span>
                                                                $12.01</h6>
                                                            <button class="close-button close_button">
                                                                <i class="fa fa-xmark"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </li>

                                                <li class="product-box-contain">
                                                    <div class="drop-cart">
                                                        <a href="product-detail.html" class="drop-image">
                                                            <img src="/front/images/product img place holder 1.png"
                                                                class="" alt>
                                                        </a>

                                                        <div class="drop-contain">
                                                            <a href="product-detail.html">
                                                                <h5>Product
                                                                    name
                                                                    2GB
                                                                </h5>
                                                            </a>
                                                            <h6><span>1
                                                                    x</span>
                                                                $14.12</h6>
                                                            <button class="close-button close_button">
                                                                <i class="fa fa-xmark"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>

                                            <div class="price-box">
                                                <h5>Total :</h5>
                                                <h4 class="theme-color fw-bold">$26.13</h4>
                                            </div>

                                            <div class="button-group">
                                                <a href="cart.html" class="btn btn-sm cart-button">View
                                                    Cart</a>
                                                <a href="checkout.html"
                                                    class="btn btn-sm cart-button theme-bg-color
                                        text-white">Checkout</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="right-side onhover-dropdown">
                                    <div class="delivery-login-box">
                                        <div class="delivery-icon">
                                            <!-- <i data-feather="user"></i> -->
                                            <i class="ijaboIcon icon-copy dw dw-user-1"></i>

                                        </div>
                                        <div class="delivery-detail">
                                            <h6>Hello,</h6>
                                            <h5>My Account</h5>
                                        </div>
                                    </div>

                                    <div class="onhover-div onhover-div-login">
                                        <ul class="user-box-name">
                                            <li class="product-box-contain">

                                                <a href="{{route('admin.login')}}"><i class="icon-copy dw dw-login"></i>
                                                   Admin Login In</a>
                                            </li>
                                            <li class="product-box-contain">

                                                <a href="{{route('seller.login')}}"><i class="icon-copy dw dw-login"></i>
                                                   Seller Log In</a>
                                            </li>
                                            <li class="product-box-contain">
                                                <a href="{{route('seller.register')}}"><i class="icon-copy dw dw-user-2"></i>
                                                   Seller Register</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="header-nav">
                    <div class="header-nav-left">
                        <button class="dropdown-category">
                            <i class="ijaboIcon icon-copy bi bi-list-nested"></i>
                            <span>&nbsp;Browse Categories</span>
                        </button>

                        <div class="category-dropdown">
                            <div class="category-title">
                                <h5>Categories</h5>
                                <button type="button" class="btn p-0 close-button text-content">
                                    <i class="fa fa-xmark"></i>
                                </button>
                            </div>

                            <!-- Example Categories and Subcategories -->
                            <ul class="category-list">
                                <li class="onhover-category-list">
                                    <a href="javascript:void(0)" class="category-name">
                                        <img src="/images/categories/category_image.png" alt="Category Image">
                                        <h6>Category 1</h6>
                                        <i class="fa fa-angle-right"></i>
                                    </a>

                                    <div class="onhover-category-box">
                                        <div class="list">
                                            <div class="category-title-box">
                                                <a href="javascript:void(0)">
                                                    <h5>Subcategory 1</h5>
                                                </a>
                                            </div>
                                            <ul>
                                                <li><a href="javascript:void(0)">Child Subcategory 1</a></li>
                                                <li><a href="javascript:void(0)">Child Subcategory 2</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>

                                <!-- Repeat for more categories -->
                                <li class="onhover-category-list">
                                    <a href="javascript:void(0)" class="category-name">
                                        <img src="/images/categories/category_image.png" alt="Category Image">
                                        <h6>Category 2</h6>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                    <!-- Add subcategories as needed -->
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="header-nav-middle">
                        <div class="main-nav navbar navbar-expand-xl navbar-light navbar-sticky">
                            <div class="offcanvas offcanvas-collapse order-xl-2" id="primaryMenu">
                                <div class="offcanvas-header navbar-shadow">
                                    <h5>Menu</h5>
                                    <button class="btn-close lead" type="button" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <ul class="navbar-nav ijabo-nav">
                                        <li class="nav-item active">
                                            <a class="nav-link nav-link-2" href="index.html">Home</a>
                                        </li>

                                        <li class="nav-item dropdown dropdown-mega">
                                            <a class="nav-link dropdown-toggle ps-xl-2 ps-0" href="javascript:void(0)"
                                                data-bs-toggle="dropdown">Shop</a>

                                            <div class="dropdown-menu dropdown-menu-2 row g-3">
                                                <div class="dropdown-column col-xl-4">
                                                    <h5 class="dropdown-header"><a
                                                            href="javascript:void(0)">Clothing</a></h5>
                                                    <a class="dropdown-item" href="javascript:void(0)">Vehicula,
                                                        Enim & Donec</a>

                                                    <a class="dropdown-item" href="javascript:void(0)">Tristique
                                                        &
                                                        Pulvinar</a>

                                                    <a href="javascript:void(0)" class="dropdown-item">Lorem
                                                        Ipsum
                                                        Dolo</a>

                                                    <a class="dropdown-item" href="javascript:void(0)">Ridiculus
                                                        Scelerisque</a>

                                                    <a class="dropdown-item" href="javascript:void(0)">Primis
                                                        Sapien</a>

                                                    <a class="dropdown-item" href="javascript:void(0)">Habitant
                                                        Dignissim</a>

                                                    <a class="dropdown-item" href="javascript:void(0)">Nunc
                                                        in
                                                        Aliquam</a>
                                                </div>

                                                <div class="dropdown-column col-xl-4">
                                                    <h5 class="dropdown-header"><a href="javascript:void(0)">Home
                                                            &
                                                            Garden
                                                        </a></h5>
                                                    <a class="dropdown-item" href="javascript:void(0)">Quisque
                                                        &
                                                        Porta</a>

                                                    <a class="dropdown-item" href="javascript:void(0)">Fusce
                                                        Natoque</a>

                                                    <a class="dropdown-item" href="javascript:void(0)">Vehicula
                                                        Enim</a>

                                                    <a class="dropdown-item" href="javascript:void(0)">Rutrum
                                                        Neque</a>

                                                    <a class="dropdown-item" href="javascript:void(0)">Nascetur
                                                        Suspendisse</a>

                                                    <a class="dropdown-item" href="javascript:void(0)">Pharetra
                                                        Nascetur</a>

                                                    <a href="javascript:void(0)" class="dropdown-item">Egestas
                                                        Bibendum</a>
                                                </div>

                                                <div class="dropdown-column col-xl-4">
                                                    <h5 class="dropdown-header"><a
                                                            href="javascript:void(0)">Beauty</a></h5>
                                                    <a class="dropdown-item" href="javascript:void(0)">Feugiat
                                                        Donec</a>

                                                    <a class="dropdown-item" href="javascript:void(0)">Blandit
                                                        Malesuada</a>

                                                    <a class="dropdown-item" href="javascript:void(0)">Convallis
                                                        Tristique</a>

                                                    <a class="dropdown-item" href="javascript:void(0)">Himenaeos
                                                        Cursus</a>

                                                    <a class="dropdown-item" href="javascript:void(0)">Accumsan
                                                        Dignissim</a>

                                                    <a class="dropdown-item" href="javascript:void(0)">Pharetra
                                                        Nascetur</a>
                                                </div>

                                            </div>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="javascript:void(0)"
                                                data-bs-toggle="dropdown">Pages</a>
                                            <ul class="dropdown-menu">

                                                <li>
                                                    <a class="dropdown-item" href="about-us.html">About
                                                        Us</a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item" href="checkout.html">Checkout</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="compare.html">Compare</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="wishlist.html">Wishlist</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="cart.html">Cart</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="success.html">Order
                                                        Success</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="search.html">Search</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="user-dashboard.html">User
                                                        Dashboard</a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item" href="forgot.html">Forgot
                                                        Password</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="404.html">404</a>
                                                </li>

                                            </ul>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link nav-link-2" href="blog.html">Blog</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link nav-link-2" href="about-us.html">About
                                                Us</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link nav-link-2" href="contact-us.html">Contact</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>
