<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
                            <div class="custom-search-box">
                                <form action="{{ route('product.search') }}" method="GET">
                                    <input type="search" name="query" placeholder="What are you looking for?" required>
                                    <button type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
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
                                    <div class="header-badge">
                                        <button type="button" class="btn p-0 position-relative header-wishlist">
                                            <a href="{{ route('client.cart') }}">
                                                <i class="ijaboIcon icon-copy dw dw-shopping-cart2"></i>
                                            </a>
                                            <span class="position-absolute top-0 start-100 translate-middle badge">
                                                {{ $cartItemCount ?? 0 }}
                                                <span class="visually-hidden">unread messages</span>
                                            </span>
                                        </button>
                                    </div>
                                </li>

                                <li class="right-side onhover-dropdown">
                                    <div class="delivery-login-box d-flex align-items-center">
                                        <div class="delivery-icon">
                                            @if(auth('client')->check())
                                                <img src="{{ asset('images/users/clients/' . auth('client')->user()->picture) }}" alt="Profile Picture"
                                                     class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                            <img src="images\users\default-avatar.png" alt="Profile Picture"
                                                     class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                            @endif
                                        </div>
                                        <div class="delivery-detail ms-2">
                                            @if(auth('client')->check())
                                                <h5 class="mb-0">{{ auth('client')->user()->name }}</h5>
                                            @else
                                                <h5 class="mb-0">My Account</h5>
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
                                                    <a href="{{ route('client.orders.manage') }}">
                                                        <i class="bi bi-box-fill"></i> Order
                                                    </a>
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
                                                    <a href="{{ route('client.login') }}"><i class="icon-copy dw dw-login"></i>Login</a>
                                                </li>
                                                <li class="product-box-contain">
                                                    <a href="{{ route('admin.login') }}"><i class="icon-copy dw dw-login"></i> Admin Login</a>
                                                </li>
                                                <li class="product-box-contain">
                                                    <a href="{{ route('seller.login') }}"><i class="icon-copy dw dw-login"></i> Login as a seller</a>
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
                    <div class="header-nav-left d-flex align-items-center">
                        <button class="dropdown-category btn btn-dark">
                            <i class="ijaboIcon icon-copy bi bi-view-list"></i>
                            <span> Categories</span>
                        </button>

                        <div class="category-dropdown">
                            <div class="category-title border border-dark p-3 rounded" style="background-color: #ffffff;">
                                {{-- <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold m-0">Categories</h5>
                                    <button type="button" class="btn btn-sm btn-outline-dark">
                                        Close
                                    </button>
                                </div> --}}
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
                    <div class="header-nav-middle mr-40 d-flex align-items-center">
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

        .custom-search-box {
        position: relative;
        max-width: 800px;
        margin: 0 auto;
    }

    .custom-search-box input[type="search"] {
        width: 100%;
        padding: 10px 40px 10px 15px;
        border: 2px solid #000; /* Viền đen đậm */
        border-radius: 25px; /* Bo tròn góc */
        font-size: 16px;
        outline: none;
    }

    .custom-search-box input[type="search"]:focus {
        border-color: #007bff; /* Màu viền khi focus */
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .custom-search-box button {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: none;
        cursor: pointer;
    }

    .custom-search-box button i {
        font-size: 20px;
        color: #000; /* Màu icon */
    }
    </style>
</header>
