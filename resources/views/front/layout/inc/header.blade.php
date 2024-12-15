<header class="bg-light border-bottom">
    <!-- Top Info Bar -->
    <div class="bg-secondary text-white py-2">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="text-dark">
                <i class="bi bi-geo-alt-fill text-dark"></i> {{ get_settings()->site_address }}
            </div>
            <div class="text-dark">
                <i class="bi bi-phone-fill text-dark"></i> Hotline: {{ get_settings()->site_phone }}
            </div>
        </div>
    </div>

    <!-- Middle Section -->
    <div class="container py-3">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Logo -->
            <a href="/" class="d-flex align-items-center">
                <img src="/images/site/{{ get_settings()->site_logo }}" alt="Logo" class="img-fluid"
                    style="width: 120px;">
            </a>

            <!-- Search Bar -->
            <div class="flex-grow-1 mx-4">
                <form action="{{ route('product.search') }}" method="GET" class="input-group">
                    <input type="text" class="form-control" placeholder="What are you looking for?" name="query"
                        required>
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>

            <!-- Cart and User -->
            <div class="d-flex align-items-center">
                <!-- Cart -->
                {{-- <a href="{{ route('client.cart') }}" class="btn btn-outline-primary position-relative me-3">
                    <i class="bi bi-cart-fill"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge bg-danger">
                        {{ $cartItemCount ?? 0 }}
                    </span>
                </a> --}}
                <a href="{{ route('client.cart') }}" class="btn btn-outline-primary position-relative me-3">
                    <i class="bi bi-cart-fill"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge bg-danger">
                        {{ $cartItemCount ?? 0 }}
                    </span>
                </a>

                <!-- User -->
                <li class="right-side onhover-dropdown">
                    <div class="delivery-login-box d-flex align-items-center">
                        <div class="delivery-icon">
                            @if (auth('client')->check() &&
                                    auth('client')->user()->picture &&
                                    file_exists(public_path('images/users/clients/' . auth('client')->user()->picture)))
                                <img src="{{ asset('images/users/clients/' . auth('client')->user()->picture) }}"
                                    alt="Profile Picture" class="rounded-circle"
                                    style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/users/default-avatar.png') }}" alt="Default Profile Picture"
                                    class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                            @endif

                        </div>

                        <div class="delivery-detail ms-2">
                            @if (auth('client')->check())
                                <h5 class="mb-0">{{ auth('client')->user()->name }}</h5>
                            @else
                                <h5 class="mb-0">My Account</h5>
                            @endif
                        </div>
                    </div>
                    <div class="onhover-div onhover-div-login">
                        <ul class="user-box-name">
                            @if (auth('client')->check())
                                <li class="product-box-contain">
                                    <a href="{{ route('client.profile') }}"><i class="icon-copy dw dw-user-2"></i>
                                        Profile</a>
                                </li>
                                <li class="product-box-contain">
                                    <a href="{{ route('client.orders.manage') }}">
                                        <i class="bi bi-box-fill"></i> Order
                                    </a>
                                </li>
                                <li class="product-box-contain">
                                    <a href="{{ route('wallet.deposit.form') }}">
                                        <i class="bi bi-wallet-fill"></i> Deposit to Wallet
                                    </a>
                                </li>
                                <li class="product-box-contain">
                                    <a href="{{ route('wallet.balance') }}">
                                        <i class="bi bi-wallet2"></i> My Wallet
                                    </a>
                                </li>
                                <li class="product-box-contain">
                                    <a href="{{ route('client.logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="icon-copy dw dw-logout"></i> Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('client.logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            @else
                                <li class="product-box-contain">
                                    <a href="{{ route('client.login') }}"><i
                                            class="icon-copy dw dw-login"></i>Login</a>
                                </li>
                                <li class="product-box-contain">
                                    <a href="{{ route('admin.login') }}"><i class="icon-copy dw dw-login"></i> Admin
                                        Login</a>
                                </li>
                                <li class="product-box-contain">
                                    <a href="{{ route('seller.login') }}"><i class="icon-copy dw dw-login"></i> Login
                                        as a seller</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            </div>
        </div>
    </div>

    <!-- Navigation Bar -->
    <nav class="bg-white border-top">
        <div class="container">
            <ul class="nav justify-content-center py-2">
                <li class="nav-item">
                    <a class="nav-link text-dark" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('about-us') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('contact-us') }}">Contact</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<style>
    header {
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .bg-secondary {
        background-color: #e5e5e5 !important;
        /* Nhẹ nhàng hơn */
    }

    header .form-control {
        border-radius: 50px;
        padding: 10px 20px;
    }

    header .btn-primary {
        border-radius: 50px;
    }

    .nav-link {
        font-weight: 500;
        text-transform: uppercase;
        transition: color 0.3s;
    }

    .nav-link:hover {
        color: #007bff;
    }
</style>
