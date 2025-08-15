<header class="header_area">
    <div class="top_menu">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="float-left">
                        <p>Điện thoại: +84 901 234 567</p>
                        <p>Email: info@perfumeshop.vn</p>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="float-right">
                        <ul class="right_side">
                            <li>
                                <a href="#">
                                    Thẻ quà tặng
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Theo dõi đơn hàng
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Liên hệ
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main_menu">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light w-100">
                <!-- Brand and toggle get grouped for better mobile display -->
                <a class="navbar-brand logo_h" href="{{ route('client.home') }}">
                    <img src="{{ asset('client/assets/img/logo.png') }}" alt="" width="100" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse offset w-100" id="navbarSupportedContent">
                    <div class="row w-100 mr-0">
                        <div class="col-lg-7 pr-0">
                            <ul class="nav navbar-nav center_nav pull-right">
                                <li class="nav-item active">
                                    <a class="nav-link" href="{{ route('client.home') }}">Trang chủ</a>
                                </li>
                                <li class="nav-item submenu dropdown">
                                    <a href="{{ route('client.products') }}" class="nav-link">Nước hoa</a>
                                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"
                                        role="button" aria-haspopup="true" aria-expanded="false"></a>
                                    <ul class="dropdown-menu">
                                        @foreach ($categories as $category_parent)
                                            @if (is_null($category_parent->parent_category_id))
                                                <li class="nav-item">
                                                    <a class="nav-link"
                                                        href="{{ route('client.products', ['category' => $category_parent->id]) }}">
                                                        {{ $category_parent->category_name }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>

                                <li class="nav-item submenu dropdown">
                                    <a href="{{ route('client.brands') }}" class="nav-link">Thương hiệu</a>
                                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"
                                        role="button" aria-haspopup="true" aria-expanded="false"></a>
                                    <ul class="dropdown-menu">
                                        @foreach ($brands as $brand)
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    href="{{ route('client.products', ['brand' => $brand->id]) }}">
                                                    {{ $brand->name }}
                                                </a>

                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="nav-item submenu dropdown">
                                    <a href="{{ route('client.knowledge') }}" class="nav-link">Kiến thức</a>
                                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"
                                        role="button" aria-haspopup="true" aria-expanded="false"></a>
                                    <ul class="dropdown-menu">
                                         <li class="nav-item">
                                            <a class="nav-link" href="#">Cách chọn</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Cách bảo quản</a>
                                        </li> 
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Xu hướng</a>
                                        </li> 
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('client.contact') }}">Liên hệ</a>
                                </li>
                            </ul>
                        </div>

                        <div class="col-lg-5 pr-0">
                            <ul class="nav navbar-nav navbar-right right_nav pull-right">

                                <li class="nav-item">
                                    <a href="{{ route('client.carts') }}" class="icons">
                                        <i class="ti-shopping-cart"></i>
                                    </a>
                                </li>
                                <li class="nav-item submenu dropdown">
                                    <a href="#" class="nav-link dropdown-toggle icons" data-toggle="dropdown"
                                        role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti-user" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('client.profiles') }}">Thông tin cá
                                            nhân</a>
                                        <a class="dropdown-item" href="{{ route('password.change') }}">Đổi mật
                                            khẩu</a>
                                        <li><a href="{{ route('client.orders') }}">Đơn hàng của tôi</a></li>
                                        <a class="dropdown-item text-danger" href="{{ route('logout') }}">Đăng
                                            xuất</a>
                                    </ul>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
