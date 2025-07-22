@extends('clients.layouts.default')

@section('content')
        <!--================Home Banner Area =================-->
        <section class="home_banner_area mb-40">
            <div class="banner_inner d-flex align-items-center">
                <div class="container">
                    <div class="banner_content row">
                        <div class="col-lg-12">
                            <p class="sub text-uppercase">Perfume Collection</p>
                            <h3><span>Discover</span> Your <br />Signature <span>Scent</span></h3>
                            <h4>Gợi mở cảm xúc. Lưu giữ phong cách.<br> Hương thơm của bạn, câu chuyện của riêng bạn.</h4>
                            <a class="main_btn mt-40" href="#">Khám phá bộ sưu tập</a>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!--================End Home Banner Area =================-->

        <!-- Start feature Area -->
        <section class="feature-area section_gap_bottom_custom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="single-feature">
                            <a href="#" class="title">
                                <i class="flaticon-money"></i>
                                <h3>Money back gurantee</h3>
                            </a>
                            <p>Shall open divide a one</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="single-feature">
                            <a href="#" class="title">
                                <i class="flaticon-truck"></i>
                                <h3>Free Delivery</h3>
                            </a>
                            <p>Shall open divide a one</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="single-feature">
                            <a href="#" class="title">
                                <i class="flaticon-support"></i>
                                <h3>Alway support</h3>
                            </a>
                            <p>Shall open divide a one</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="single-feature">
                            <a href="#" class="title">
                                <i class="flaticon-blockchain"></i>
                                <h3>Secure payment</h3>
                            </a>
                            <p>Shall open divide a one</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End feature Area -->

        <!--================ Feature Product Area =================-->
        <section class="feature_product_area section_gap_bottom_custom">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="main_title">
                            <h2><span>Featured product</span></h2>
                            <p>Bring called seed first of third give itself now ment</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach ($products->take(6) as $product_featured)
                        <div class="col-lg-4 col-md-6">
                            <div class="single-product">
                                <div class="product-img">
                                    <img class="img-fluid w-100"
                                        src="{{ $product_featured->featuredImage ? asset('storage/' . $product_featured->featuredImage->path) : asset('admin/assets/images/product/placeholder.png') }}"
                                        alt="" />
                                    <div class="p_icon">
                                        <a href="{{ route('client.products.show', $product_featured->id) }}">
                                            <i class="ti-eye"></i>
                                        </a>
                                        <a href="#">
                                            <i class="ti-heart"></i>
                                        </a>
                                        <a href="#">
                                            <i class="ti-shopping-cart"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="product-btm">
                                    <a href="#" class="d-block">
                                        <h4>{{ $product_featured->name }}</h4>
                                    </a>
                                    <div class="mt-3">
                                        <span class="mr-4">{{ $product_featured->base_price }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!--================ End Feature Product Area =================-->

        <!--================ Offer Area =================-->
        <section class="offer_area" style="height: 750px">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="offset-lg-4 col-lg-6 text-center">
                        <div class="offer_content">
                            <h3 class="text-uppercase mb-40">nước hoa cao cấp</h3>
                            <h2 class="text-uppercase">Giảm 50%</h2>
                            <a href="#" class="main_btn mb-20 mt-5">Khám phá ngay</a>
                            <p>Ưu đãi có hạn – chỉ trong tuần này</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--================ End Offer Area =================-->

        <!--================ New Product Area =================-->
        <section class="new_product_area section_gap_top section_gap_bottom_custom">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="main_title">
                            <h2><span>new products</span></h2>
                            <p>Bring called seed first of third give itself now ment</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach ($products->sortByDesc('created_at')->take(5) as $index => $product)
                        @if ($loop->first)
                            <!-- Sản phẩm mới nhất -->
                            <div class="col-lg-6">
                                <div class="new_product">
                                    <h5 class="text-uppercase">collection of {{ $product->created_at->year }}</h5>
                                    <h3 class="text-uppercase">{{ $product->name }}</h3>
                                    <div class="product-img">
                                        <img class="img-fluid"
                                            src="{{ $product->featuredImage ? asset('storage/' . $product->featuredImage->path) : asset('admin/assets/images/product/placeholder.png') }}"
                                            alt="{{ $product->name }}" />
                                    </div>
                                    <h4>${{ number_format($product->base_price, 2) }}</h4>
                                    <a href="" class="main_btn">Add to cart</a>
                                </div>
                            </div>

                            <!-- Bắt đầu div 4 sản phẩm nhỏ -->
                            <div class="col-lg-6 mt-5 mt-lg-0">
                                <div class="row">
                                @else
                                    <div class="col-lg-6 col-md-6">
                                        <div class="single-product">
                                            <div class="product-img">
                                                <img class="img-fluid w-100"
                                                    src="{{ $product->featuredImage ? asset('storage/' . $product->featuredImage->path) : asset('admin/assets/images/product/placeholder.png') }}"
                                                    alt="{{ $product->name }}" />
                                                <div class="p_icon">
                                                    <a href="#"><i class="ti-eye"></i></a>
                                                    <a href="#"><i class="ti-heart"></i></a>
                                                    <a href="#"><i class="ti-shopping-cart"></i></a>
                                                </div>
                                            </div>
                                            <div class="product-btm">
                                                <a href="#" class="d-block">
                                                    <h4>{{ $product->name }}</h4>
                                                </a>
                                                <div class="mt-3">
                                                    <span
                                                        class="mr-4">${{ number_format($product->base_price, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        @endif
                    @endforeach
                </div> <!-- đóng .row -->
            </div>
            </div>
            </div>
        </section>
        <!--================ End New Product Area =================-->

        <!--================ Inspired Product Area =================-->
        <section class="inspired_product_area section_gap_bottom_custom">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="main_title">
                            <h2><span>Inspired products</span></h2>
                            <p>Bring called seed first of third give itself now ment</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach ($products->take(8) as $product_inspired)
                        <div class="col-lg-3 col-md-6">
                            <div class="single-product">
                                <div class="product-img">
                                    <img class="img-fluid w-100"
                                        src="{{ $product_inspired->featuredImage ? asset('storage/' . $product_inspired->featuredImage->path) : asset('admin/assets/images/product/placeholder.png') }}"
                                        alt="" />
                                    <div class="p_icon">
                                        <a href="#">
                                            <i class="ti-eye"></i>
                                        </a>
                                        <a href="#">
                                            <i class="ti-heart"></i>
                                        </a>
                                        <a href="#">
                                            <i class="ti-shopping-cart"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="product-btm">
                                    <a href="#" class="d-block">
                                        <h4>{{ $product_inspired->name }}</h4>
                                    </a>
                                    <div class="mt-3">
                                        <span class="mr-4">{{ $product_inspired->base_price }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
@endsection
