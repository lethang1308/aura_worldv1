<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="img/favicon.png" type="image/png" />
    <title>Eiser ecommerce</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('client/assets/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('client/assets/vendors/linericon/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('client/assets/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('client/assets/css/themify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('client/assets/css/flaticon.css') }}" />
    <link rel="stylesheet" href="{{ asset('client/assets/vendors/owl-carousel/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('client/assets/vendors/lightbox/simpleLightbox.css') }}" />
    <link rel="stylesheet" href="{{ asset('client/assets/vendors/nice-select/css/nice-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('client/assets/vendors/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('client/assets/vendors/jquery-ui/jquery-ui.css') }}" />
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('client/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('client/assets/css/responsive.css') }}">
</head>

<body>
    <!--================Header Menu Area =================-->
    @include('clients.layouts.partials.header')
    <!--================Header Menu Area =================-->

    <!--================Home Banner Area =================-->

    <!--================End Home Banner Area =================-->

    <!-- Start feature Area -->
    @yield('content')
    <!-- End feature Area -->
    <!--================ Feature Product Area =================-->

    <!--================ End Feature Product Area =================-->

    <!--================ Offer Area =================-->


    <!--================ End Offer Area =================-->

    <!--================ New Product Area =================-->

    <!--================ End New Product Area =================-->

    <!--================ Inspired Product Area =================-->

    <!--================ End Inspired Product Area =================-->

    <!--================ Start Blog Area =================-->
    <!--================ End Blog Area =================-->

    <!--================ start footer Area  =================-->
    @include('clients.layouts.partials.footer')
    <!--================ End footer Area  =================-->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('client/assets/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('client/assets/js/popper.js') }}"></script>
    <script src="{{ asset('client/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('client/assets/js/stellar.js') }}"></script>

    <script src="{{ asset('client/assets/vendors/lightbox/simpleLightbox.min.js') }}"></script>
    <script src="{{ asset('client/assets/vendors/nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('client/assets/vendors/isotope/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('client/assets/vendors/isotope/isotope-min.js') }}"></script>
    <script src="{{ asset('client/assets/vendors/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('client/assets/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('client/assets/vendors/counter-up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('client/assets/vendors/counter-up/jquery.counterup.js') }}"></script>
    <script src="{{ asset('client/assets/js/mail-script.js') }}"></script>
    <script src="{{ asset('client/assets/js/theme.js') }}"></script>
    @stack('scripts')
</body>

</html>
