<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="img/favicon.png" type="image/png" />
    <title>Eiser ecommerce</title>
    <!-- Bootstrap CSS -->
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('shipper/assets/css/shipper.css') }}">
</head>

<body>
    <!--================Header Menu Area =================-->
    @include('shippers.layouts.partials.header')
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
    @include('shippers.layouts.partials.footer')
    <!--================ End footer Area  =================-->

    <!-- Optional JavaScript -->

</body>

</html>
