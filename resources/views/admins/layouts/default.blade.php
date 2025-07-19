<html lang="en" data-bs-theme="light" data-topbar-color="light" data-menu-color="dark" data-menu-size="sm-hover-active">
<!-- Mirrored from techzaa.in/larkon/admin/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 22 May 2025 16:24:31 GMT -->

<head>
    <!-- Title Meta -->
    <meta charset="utf-8">
    <title>Dashboard | Larkon - Responsive Admin Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully responsive premium admin dashboard template">
    <meta name="author" content="Techzaa">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- Thêm thư viện jsVectorMap vào head -->


    <!-- Vendor css (Require in all Page) -->
    <link href="{{ asset('admin/assets/css/vendor.min.css') }}">

    <!-- Icons css (Require in all Page) -->
    <link href="{{ asset('admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">

    <!-- App css (Require in all Page) -->
    <link href="{{ asset('admin/assets/css/app.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Theme Config js (Require in all Page) -->
    <script src="{{ asset('admin/assets/js/config.js') }}"></script>

    <link href="{{ asset('admin/assets/css/admin.css') }}" rel="stylesheet" type="text/css">

<body>

    <!-- START Wrapper -->
    <div class="wrapper">

        <!-- ========== Topbar Start ========== -->
        @include('admins.layouts.partials.header')

        <!-- ========== Topbar End ========== -->

        <!-- ========== App Menu Start ========== -->
        @include('admins.layouts.partials.menu')

        <!-- ========== App Menu End ========== -->

        <!-- ==================================================== -->
        <!-- Start right Content here -->
        <!-- ==================================================== -->

          @yield('content')
        <!-- ==================================================== -->
        <!-- End Page Content -->
        <!-- ==================================================== -->
    </div>
    <!-- END Wrapper -->


    <!-- Vendor Javascript (Require in all Page) -->
    <script src="{{ asset('admin/assets/js/vendor.js') }}"></script>

    <!-- App Javascript (Require in all Page) -->
    <script src="{{ asset('admin/assets/js/app.js') }}"></script>
    
    <svg id="SvgjsSvg1158" width="2" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1"
        xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev"
        style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;">
        <defs id="SvgjsDefs1159"></defs>
        <polyline id="SvgjsPolyline1160" points="0,0"></polyline>
        <path id="SvgjsPath1161"
            d="M-1 231.42666563796996L-1 231.42666563796996C-1 231.42666563796996 70.11466500778829 231.42666563796996 70.11466500778829 231.42666563796996C70.11466500778829 231.42666563796996 140.22933001557658 231.42666563796996 140.22933001557658 231.42666563796996C140.22933001557658 231.42666563796996 210.34399502336487 231.42666563796996 210.34399502336487 231.42666563796996C210.34399502336487 231.42666563796996 280.45866003115316 231.42666563796996 280.45866003115316 231.42666563796996C280.45866003115316 231.42666563796996 350.57332503894145 231.42666563796996 350.57332503894145 231.42666563796996C350.57332503894145 231.42666563796996 420.68799004672974 231.42666563796996 420.68799004672974 231.42666563796996C420.68799004672974 231.42666563796996 490.802655054518 231.42666563796996 490.802655054518 231.42666563796996C490.802655054518 231.42666563796996 560.9173200623063 231.42666563796996 560.9173200623063 231.42666563796996C560.9173200623063 231.42666563796996 631.0319850700946 231.42666563796996 631.0319850700946 231.42666563796996C631.0319850700946 231.42666563796996 701.1466500778829 231.42666563796996 701.1466500778829 231.42666563796996C701.1466500778829 231.42666563796996 771.2613150856712 231.42666563796996 771.2613150856712 231.42666563796996C771.2613150856712 231.42666563796996 771.2613150856712 231.42666563796996 771.2613150856712 231.42666563796996 ">
        </path>
    </svg>



    <div class="jvm-tooltip"></div>
</body>
<!-- Mirrored from techzaa.in/larkon/admin/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 22 May 2025 16:25:23 GMT -->

</html>
