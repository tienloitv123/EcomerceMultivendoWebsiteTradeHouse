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
                            <img src="/images/site/{{ get_settings()->site_logo }}" class="img-fluid blur-up lazyload" alt>
                        </a>
                        <div class="middle-box">
                            <div class="search-box">
                                <form action="{{ route('product.search') }}" method="GET">
                                    <div class="input-group">
                                        <input type="search" name="query" class="form-control" placeholder="What are you looking for?" aria-describedby="button-addon2" required>
                                        <button class="btn" type="submit" id="button-addon2">
                                            <i class="icon-copy dw dw-search2"></i>
                                        </button>
                                    </div>
                                </form>
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
                                    <div class="delivery-login-box">
                                        <div class="delivery-icon">
                                            <i class="ijaboIcon icon-copy dw dw-phone-call"></i>
                                        </div>
                                        <div class="delivery-detail">
                                            <h6>24/7 Service Number</h6>
                                            <h5>{{ get_settings()->site_phone }}</h5>
                                        </div>
                                    </div>
                                </li>
                                <li class="right-side">
                                    <div class="onhover-dropdown header-badge">
                                        <button type="button" class="btn p-0 position-relative header-wishlist">
                                           <a href="{{ route('client.cart') }}"><i class="ijaboIcon icon-copy dw dw-shopping-cart2"></i></a>
                                            <span class="position-absolute top-0 start-100 translate-middle badge">?
                                                <span class="visually-hidden">unread messages</span>
                                            </span>
                                        </button>
                                    </div>
                                </li>
                                <li class="right-side onhover-dropdown">
                                    <div class="delivery-login-box">
                                        <div class="delivery-icon">
                                            <i class="ijaboIcon icon-copy dw dw-user-1"></i>
                                        </div>
                                        <div class="delivery-detail">
                                            @if(auth('client')->check())
                                                <h6>Hello</h6>
                                                <h5> {{ auth('client')->user()->name }}</h5>
                                            @else
                                                <h6>Hello,</h6>
                                                <h5>My Account</h5>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="onhover-div onhover-div-login">
                                        <ul class="user-box-name">
                                            @if(auth('client')->check())
                                                <li class="product-box-contain">
                                                    <a href="{{ route('client.profile') }}"><i class="icon-copy dw dw-user-2"></i> Profile</a>
                                                </li>
                                                <li class="product-box-contain">
                                                    <a href="{{ route('client.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                        <i class="icon-copy dw dw-logout"></i> Logout
                                                    </a>
                                                    <form id="logout-form" action="{{ route('client.logout') }}" method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                                </li>
                                            @else
                                                <li class="product-box-contain">
                                                    <a href="{{ route('client.login') }}"><i class="icon-copy dw dw-login"></i> Client Log In</a>
                                                </li>
                                                <li class="product-box-contain">
                                                    <a href="{{ route('client.register') }}"><i class="icon-copy dw dw-user-2"></i> Client Register</a>
                                                </li>
                                                <li class="product-box-contain">
                                                    <a href="{{ route('admin.login') }}"><i class="icon-copy dw dw-login"></i> Admin Login</a>
                                                </li>
                                                <li class="product-box-contain">
                                                    <a href="{{ route('seller.login') }}"><i class="icon-copy dw dw-login"></i> Seller Log In</a>
                                                </li>
                                            @endif
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
                <div class="header-nav d-flex align-items-center justify-content-between">
                    <!-- Browse Categories Button -->
                    <div class="header-nav-left d-flex align-items-center">
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

                            @if (count(get_categories()) > 0)
                                @foreach (get_categories() as $category)
                                    <ul class="category-list">
                                        <li class="onhover-category-list">
                                            <a href="javascript:void(0)" class="category-name">
                                                <img src="/images/categories/{{ $category->category_image }}" alt="Category Image">
                                                <h6>{{ $category->category_name }}</h6>
                                                @if (count($category->subcategories) > 0)
                                                    <i class="fa fa-angle-right"></i>
                                                @endif
                                            </a>
                                            @if (count($category->subcategories) > 0)
                                                <div class="onhover-category-box">
                                                    @foreach ($category->subcategories as $subcategory)
                                                        @if ($subcategory->is_child_of == 0)
                                                            <div class="list">
                                                                <div class="category-title-box">
                                                                    <a href="javascript:void(0)">
                                                                        <h5>{{ $subcategory->subcategory_name }}</h5>
                                                                    </a>
                                                                </div>
                                                                <ul>
                                                                    @foreach ($subcategory->children as $child_subcategory)
                                                                        <li>
                                                                            <a href="javascript:void(0)">{{ $child_subcategory->subcategory_name }}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        </li>
                                    </ul>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Centered Navigation Links -->
                    <div class="header-nav-middle d-flex align-items-center">
                        <ul class="navbar-nav d-flex flex-row align-items-center" style="gap: 1.5rem;">
                            <li class="nav-item">
                                <a class="nav-link" href="/">Home</a>
                            </li>
                            <li class="nav-item">
                                {{-- <a class="nav-link" href="{{ route('about-us') }}">About Us</a> --}}
                                <a class="nav-link" href="{{ route('about-us') }}">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('contact-us')}}">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .header-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
        }

        .header-nav-left {
            display: flex;
            align-items: center;
        }

        .header-nav-middle .nav-link {
            font-size: 1rem;
            font-weight: bold;
            color: #333;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .header-nav-middle .nav-link:hover {
            color: #007bff;
            text-decoration: underline;
        }

        /* Background color for header */
        header {
            background-color: #f1f1f1; /* light gray background */
            border-bottom: 2px solid #000; /* black border at bottom */
        }
    </style>
</header>
