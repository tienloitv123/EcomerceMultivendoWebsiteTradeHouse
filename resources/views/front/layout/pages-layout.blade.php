<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ijaboShop">
    <meta name="keywords" content="ijaboShop">
    <meta name="author" content="ijaboShop">
    <link rel="icon" href="/images/site/{{ get_settings()->site_favicon }}" type="image/x-icon">
    <title>@yield('pageTitle')</title>
    <link type="text/css" rel="stylesheet" href="/front/css/animate.min.css" />
    <link type="text/css" rel="stylesheet" href="/front/css/vendors/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="/front/css/vendors/font-awesome.css">
    <link type="text/css" rel="stylesheet" href="/front/css/vendors/feather-icon.css">
    <link type="text/css" rel="stylesheet" href="/front/css/vendors/slick/slick.css">
    <link type="text/css" rel="stylesheet" href="/front/css/vendors/slick/slick-theme.css">
    <link type="text/css" rel="stylesheet" href="/front/styles/icon-font.min.css" />
    <link type="text/css" rel="stylesheet" href="/front/css/vendors/animate.css">
    <link type="text/css" rel="stylesheet" href="/front/css/custom.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet" />
    <link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.2/jquery-ui.min.css">
    <link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.2/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="/extra-assets/jquery-ui-1.13.2/jquery-ui.theme.min.css">
    <link rel="stylesheet" href="/extra-assets/ijaboCropTool/ijaboCropTool.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/back/vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="/back/vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="/back/vendors/styles/style.css" />
    <link rel="stylesheet" href="/extra-assets/summernote/summernote-bs4.min.css">


    {{-- <meta charset="utf-8">
    <title>@yield('pageTitle')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">


    <link rel="icon" type="image/png" sizes="16x16" href="/images/site/{{ get_settings()->site_favicon}}" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="/front/css/vendors/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link type="text/css" rel="stylesheet" href="/front/css/custom.css">
    <link href="/front/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="/front/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel --}}
    {{-- @livewire() --}}
    @stack('stylesheets')
</head>

<body>

    <!-- Categories End -->

    @include('front.layout.inc.header')

    @include('front.layout.inc.mobile-menu')

    @yield('content')

    <!-- Footer Start -->
    @include('front.layout.inc.footer')
    <!-- Footer End -->




    <!-- Tap to top start -->
    <div class="theme-option">
        <div class="back-to-top">
            <a id="back-to-top" href="#">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <!-- Tap to top end -->

    <!-- Bg overlay Start -->
    <div class="bg-overlay"></div>
    <!-- Bg overlay End -->

    <script src="/front/js/jquery-3.6.0.min.js"></script>
    <script src="/front/js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="/front/js/bootstrap/bootstrap-notify.min.js"></script>
    <script src="/front/js/bootstrap/popper.min.js"></script>
    <script src="/front/js/jquery-ui.min.js"></script>
    <script src="/front/js/feather/feather.min.js"></script>
    <script src="/front/js/feather/feather-icon.js"></script>
    <script src="/front/js/lazysizes.min.js"></script>
    <script src="/front/js/slick/slick.js"></script>
    <script src="/front/js/slick/slick-animation.min.js"></script>
    <script src="/front/js/slick/custom_slick.js"></script>
    <script src="/front/js/auto-height.js"></script>
    <script src="/front/js/timer.js"></script>
    <script src="/front/js/fly-cart.js"></script>
    <script src="/front/js/quantity-2.js"></script>
    <script src="/front/js/wow.min.js"></script>
    <script src="/front/js/custom-wow.js"></script>
    <script src="/front/js/script.js"></script>
    <script src="/front/js/settings.js"></script>
    <script src="/extra-assets/ijaboCropTool/ijaboCropTool.min.js"></script>
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
    <script src="/extra-assets/summernote/summernote-bs4.min.js"></script>
		<script>
			$(document).ready(function(){
                $('.summernote').summernote({
					height:200
				});
			});
		</script>
    @livewireScripts()
    @stack('scripts')
</body>

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
</html>
