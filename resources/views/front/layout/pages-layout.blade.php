<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel
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


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="/front/lib/easing/easing.min.js"></script>
    <script src="/front/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Contact Javascript File -->
    {{-- <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script> --}}

    <!-- Template Javascript -->
    <script src="/front/js/main.js"></script>
    @livewireScripts()
    @stack('scripts')
</body>

</html>
