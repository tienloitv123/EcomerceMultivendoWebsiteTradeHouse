<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>@yield('pageTitle')</title>
    <link rel="icon" type="image/png" sizes="16x16" href="/images/site/{{ get_settings()->site_favicon }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.2/jquery-ui.min.css">
    <link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.2/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.2/jquery-ui.theme.min.css">
    <link rel="stylesheet" type="text/css" href="/back/vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="/back/vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="/back/vendors/styles/style.css" />


<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                "gtm.start": new Date().getTime(),
                event: "gtm.js"
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != "dataLayer" ? "&l=" + l : "";
            j.async = true;
            j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, "script", "dataLayer", "GTM-NXZMQSS");

        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.left-side-bar');
            sidebar.style.backgroundColor = '#87CEFA';
            sidebar.style.color = 'white';
        });
    </script>
    <!-- End Google Tag Manager -->
    <link rel="stylesheet" href="/extra-assets/ijabo/ijabo.min.css">
    <link rel="stylesheet" href="/extra-assets/ijaboCropTool/ijaboCropTool.min.css">
    <link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.2/jquery-ui.min.css">
    <link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.2/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.2/jquery-ui.theme.min.css">
    <link rel="stylesheet" href="/extra-assets/summernote/summernote-bs4.min.css">

    <style>
        .swal2-popup {
            font-size: 0.78em;
        }
    </style>
    @livewireStyles
    @stack('stylesheets')
</head>

<body>


    <div class="header">
        <div class="header-left">
            <div class="menu-icon bi bi-list"></div>
            <div class="search-toggle-icon bi bi-search" data-toggle="header_search"></div>
        </div>
        <div class="header-right">
            {{-- <div class="dashboard-setting user-notification">
                <div class="dropdown">
                    <a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
                        <i class="dw dw-settings2"></i>
                    </a>
                </div>
            </div> --}}
            @livewire('admin-seller-header-profile-info')
        </div>
    </div>

    {{-- <div class="right-sidebar">
        <div class="sidebar-title">
            <h3 class="weight-600 font-16 text-blue">
                Layout Settings
                <span class="btn-block font-weight-400 font-12">User Interface Settings</span>
            </h3>
            <div class="close-sidebar" data-toggle="right-sidebar-close">
                <i class="icon-copy ion-close-round"></i>
            </div>
        </div>
        <div class="right-sidebar-body customscroll">
            <div class="right-sidebar-body-content">
                <h4 class="weight-600 font-18 pb-10">Header Background</h4>
                <div class="sidebar-btn-group pb-30 mb-10">
                    <a href="javascript:void(0);" class="btn btn-outline-primary header-white active">White</a>
                    <a href="javascript:void(0);" class="btn btn-outline-primary header-dark">Dark</a>
                </div>

                <h4 class="weight-600 font-18 pb-10">Sidebar Background</h4>
                <div class="sidebar-btn-group pb-30 mb-10">
                    <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-light">White</a>
                    <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-dark active">Dark</a>
                </div>

                <h4 class="weight-600 font-18 pb-10">Menu Dropdown Icon</h4>
                <div class="sidebar-radio-group pb-10 mb-10">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebaricon-1" name="menu-dropdown-icon" class="custom-control-input"
                            value="icon-style-1" checked="" />
                        <label class="custom-control-label" for="sidebaricon-1"><i class="fa fa-angle-down"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebaricon-2" name="menu-dropdown-icon" class="custom-control-input"
                            value="icon-style-2" />
                        <label class="custom-control-label" for="sidebaricon-2"><i class="ion-plus-round"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebaricon-3" name="menu-dropdown-icon" class="custom-control-input"
                            value="icon-style-3" />
                        <label class="custom-control-label" for="sidebaricon-3"><i
                                class="fa fa-angle-double-right"></i></label>
                    </div>
                </div>

                <h4 class="weight-600 font-18 pb-10">Menu List Icon</h4>
                <div class="sidebar-radio-group pb-30 mb-10">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-1" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-1" checked="" />
                        <label class="custom-control-label" for="sidebariconlist-1"><i
                                class="ion-minus-round"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-2" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-2" />
                        <label class="custom-control-label" for="sidebariconlist-2"><i class="fa fa-circle-o"
                                aria-hidden="true"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-3" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-3" />
                        <label class="custom-control-label" for="sidebariconlist-3"><i
                                class="dw dw-check"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-4" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-4" checked="" />
                        <label class="custom-control-label" for="sidebariconlist-4"><i
                                class="icon-copy dw dw-next-2"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-5" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-5" />
                        <label class="custom-control-label" for="sidebariconlist-5"><i
                                class="dw dw-fast-forward-1"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-6" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-6" />
                        <label class="custom-control-label" for="sidebariconlist-6"><i
                                class="dw dw-next"></i></label>
                    </div>
                </div>

                <div class="reset-options pt-30 text-center">
                    <button class="btn btn-danger" id="reset-settings">
                        Reset Settings
                    </button>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="left-side-bar">
        <div class="brand-logo">
            <a href="index.html">
                <img src="/images/site/{{ get_settings()->site_logo }}" alt="" class="dark-logo" />
                <img src="/images/site/{{ get_settings()->site_logo }}" alt="" class="light-logo" />
            </a>
            <div class="close-sidebar" data-toggle="left-sidebar-close">
                <i class="ion-close-round"></i>
            </div>
        </div>
        <div class="menu-block customscroll">
            <div class="sidebar-menu">
                <ul id="accordion-menu">

                    @if (Route::is('admin.*'))
                        <li>
                            <a href="{{ route('admin.home') }}"
                                class="dropdown-toggle no-arrow {{ Route::is('admin.home') ? 'active' : '' }}">
                                <span class="micon bi bi-receipt-cutoff"></span><span class="mtext">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.manage-categories.cats-subcats-list') }}"
                                class="dropdown-toggle no-arrow {{ Route::is('admin.manage-categories.*') ? 'active' : '' }}">
                                <span class="micon dw dw-align-left3"></span><span class="mtext">Manage
                                    Categories</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.wallet.view') }}" class="dropdown-toggle no-arrow {{ Route::is('admin.wallet.view') ? 'active' : '' }}">
                                <span class="micon bi bi-wallet2"></span><span class="mtext">Wallet</span>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <div class="sidebar-small-cap">Setting</div>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle">
                                <span class="micon bi bi-people-fill"></span><span class="mtext">User Manage</span>
                            </a>
                            <ul class="submenu">
                                <li>
                                    <a href="{{ route('admin.manage.clients') }}" class="">
                                        Client
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.manage.sellers') }}" class="">
                                        Seller
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('admin.profile') }}"
                                class="dropdown-toggle no-arrow {{ Route::is('admin.profile') ? 'active' : '' }}">
                                <span class="micon fa fa-user"></span>
                                <span class="mtext">Profile</span>
                            </a>
                            <a href="{{ route('admin.setting') }}"
                                class="dropdown-toggle no-arrow {{ Route::is('admin.setting') ? 'active' : '' }} ">
                                <span class="micon fa fa-cog"></span>
                                <span class="mtext">Setting</span>
                            </a>
                        </li>
                    @else()
                        <li>
                            <a href="{{ route('seller.home') }}"
                                class="dropdown-toggle no-arrow {{ Route::is('seller.home') ? 'active' : '' }}">
                                <span class="micon fa fa-home"></span><span class="mtext">Home</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('seller.orders.manage') }}" class="dropdown-toggle no-arrow">
                                <span class="micon bi bi-receipt-cutoff"></span><span class="mtext">Order List</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('seller.wallet.view') }}" class="dropdown-toggle no-arrow {{ Route::is('seller.wallet.view') ? 'active' : '' }}">
                                <span class="micon bi bi-wallet2"></span><span class="mtext">My Wallet</span>
                            </a>
                        </li>

                        <li class="dropdown">
                            <a href="javascript:;"
                                class="dropdown-toggle {{ Route::is('seller.product.*') ? 'active' : '' }}">
                                <span class="micon bi bi-bag"></span><span class="mtext">Manage Products</span>
                            </a>
                            <ul class="submenu">
                                <li><a href="{{ route('seller.product.all-products') }}"
                                        class="{{ Route::is('seller.product.all-products') ? 'active' : '' }}">All
                                        Products</a></li>
                                <li><a href="{{ route('seller.product.add-product') }}"
                                        class="{{ Route::is('seller.product.add-product') ? 'active' : '' }}">Add
                                        Product</a></li>
                            </ul>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <div class="sidebar-small-cap">Setting</div>
                        </li>

                        <li>
                            <a href="{{ route('seller.profile') }}" class="dropdown-toggle no-arrow"
                                class="dropdown-toggle no-arrow {{ Route::is('seller.profile') ? 'active' : '' }}">
                                <span class="micon fa fa-user"></span>
                                <span class="mtext">Profile</span>
                            </a>

                        </li>
                        <li>
                            <a href="{{ route('seller.shop-settings') }}"
                                class="dropdown-toggle no-arrow {{ Route::is('seller.shop-settings') ? 'active' : '' }}">
                                <span class="micon bi bi-shop"></span>
                                <span class="mtext">Shop Settigs
                                </span>
                            </a>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
    </div>
    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                {{-- <div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>blank</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="index.html">Home</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
											blank
										</li>
									</ol>
								</nav>
							</div>
							<div class="col-md-6 col-sm-12 text-right">
								<div class="dropdown">
									<a
										class="btn btn-primary dropdown-toggle"
										href="#"
										role="button"
										data-toggle="dropdown"
									>
										January 2018
									</a>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item" href="#">Export List</a>
										<a class="dropdown-item" href="#">Policies</a>
										<a class="dropdown-item" href="#">View Assets</a>
									</div>
								</div>
							</div>
						</div>
					</div> --}}
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    @yield('content')
                </div>
            </div>
            <div class="footer-wrap pd-20 mb-20 card-box">
                Trade House friendly with everyone!!!!
                <a href="https://github.com/tienloitv123/EcomerceMultivendoWebsiteTradeHouse" target="_blank">Github
                    by Loiltgcc210019</a>
            </div>
        </div>
    </div>

    <!-- js -->
    <script src="/back/vendors/scripts/core.js"></script>
    <script src="/back/vendors/scripts/script.min.js"></script>
    <script src="/back/vendors/scripts/process.js"></script>
    <script src="/back/vendors/scripts/layout-settings.js"></script>

    <script>
        if (navigator.userAgent.indexOf("Firefox") != -1) {
            history.pushState(null, null, document.URL);
            window.addEventListener('popstate', function() {
                history.pushState(null, null, document.URL);
            });
        }
    </script>
    <script src="/extra-assets/ijabo/ijabo.min.js"></script>
    <script src="/extra-assets/ijabo/jquery.ijaboViewer.min.js"></script>
    <script src="/extra-assets/ijaboCropTool/ijaboCropTool.min.js"></script>
    <script src="/extra-assets/jquery-ui-1.13.2/jquery-ui.min.js"></script>
    <script src="/extra-assets/summernote/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 200
            });
        });
    </script>

    <script>
        window.addEventListener('showToastr', function(event) {
            toastr.remove();
            if (event.detail[0].type === 'info') {
                toastr.info(event.detail[0].message);
            } else if (event.detail[0].type === 'success') {
                toastr.success(event.detail[0].message);
            } else if (event.detail[0].type === 'error') {
                toastr.error(event.detail[0].message);
            } else if (event.detail[0].type === 'warning') {
                toastr.warning(event.detail[0].message);
            } else {
                return false;
            }
        });
    </script>
    @livewireStyles
    @stack('scripts')

</body>
<style>

</style>

</html>
