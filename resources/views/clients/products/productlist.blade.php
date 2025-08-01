@extends('clients.layouts.default')

@section('content')
    <!--================Khu vực Banner Trang chủ =================-->
    <section class="banner_area">
        <div class="banner_inner d-flex align-items-center">
            <div class="container">
                <div class="banner_content d-md-flex justify-content-between align-items-center">
                    <div class="mb-3 mb-md-0">
                        <h2>Danh mục Sản phẩm</h2>
                        <p>Rất nhiều sản phẩm đang chờ bạn khám phá</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================Kết thúc Khu vực Banner Trang chủ =================-->

    <!--================Khu vực Sản phẩm Danh mục =================-->
    <section class="cat_product_area section_gap">
        <div class="container">
            <form action="{{ route('client.products') }}" method="GET">
                <div class="row flex-row-reverse">
                    <!-- DANH SÁCH SẢN PHẨM -->
                    <div class="col-lg-9">
                        <div class="product_top_bar d-flex justify-content-between align-items-center mb-3">
                            <input type="text" name="keyword" class="form-control mr-2"
                                placeholder="Tìm kiếm sản phẩm..." value="{{ request('keyword') }}">
                            <button class="btn btn-outline-success" type="submit">Tìm</button>
                            <a href="{{ route('client.products') }}" class="btn btn-outline-secondary ml-2">Xóa tất cả</a>
                        </div>

                        <div class="latest_product_inner">
                            <div class="row">
                                @forelse ($products as $product)
                                    <div class="col-lg-4 col-md-6 mb-4">
                                        <div class="single-product">
                                            <div class="product-img">
                                                <img class="card-img"
                                                    src="{{ $product->featuredImage ? asset('storage/' . $product->featuredImage->path) : asset('admin/assets/images/product/placeholder.png') }}"
                                                    alt="" />
                                                <div class="p_icon">
                                                    <a href="{{ route('client.products.show', $product->id) }}">
                                                        <i class="ti-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="product-btm mt-3">
                                                <a href="{{ route('client.products.show', $product->id) }}" class="d-block">
                                                    <h4>{{ $product->name }}</h4>
                                                </a>
                                                <div>
                                                    <span class="mr-4">{{ number_format($product->base_price, 0, ',', '.') }} VNĐ</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="ml-3">Không có sản phẩm nào phù hợp.</p>
                                @endforelse
                            </div>
                        </div>

                        {{-- PHÂN TRANG --}}
                        @if ($products->hasPages())
                            <nav class="mt-4" aria-label="Điều hướng trang">
                                <ul class="pagination pagination-rounded justify-content-center mb-0">
                                    {{-- Liên kết Trang Trước --}}
                                    @if ($products->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link" aria-hidden="true"><i
                                                    class="bx bx-chevron-left"></i></span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="{{ $products->appends(request()->query())->previousPageUrl() }}"
                                                rel="prev" aria-label="Trang trước">
                                                <i class="bx bx-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Các phần tử Phân trang --}}
                                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                        @if ($page == $products->currentPage())
                                            <li class="page-item active"><span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item"><a class="page-link"
                                                    href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach

                                    {{-- Liên kết Trang Sau --}}
                                    @if ($products->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="{{ $products->appends(request()->query())->nextPageUrl() }}"
                                                rel="next" aria-label="Trang sau">
                                                <i class="bx bx-chevron-right"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link" aria-hidden="true"><i
                                                    class="bx bx-chevron-right"></i></span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        @endif
                    </div>

                    <!-- BỘ LỌC -->
                    <div class="col-lg-3">
                        <div class="left_sidebar_area">
                            <!-- Thương hiệu -->
                            <aside class="left_widgets p_filter_widgets mt-4">
                                <div class="l_w_title">
                                    <h3>Thương hiệu</h3>
                                </div>
                                <div class="widgets_inner">
                                    @foreach ($brands as $brand)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="brands[]"
                                                value="{{ $brand->id }}"
                                                {{ is_array(request('brands')) && in_array($brand->id, request('brands')) ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ $brand->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </aside>

                            <!-- Danh mục -->
                            <aside class="left_widgets p_filter_widgets">
                                <div class="l_w_title">
                                    <h3>Danh mục</h3>
                                </div>
                                <div class="widgets_inner">
                                    @foreach ($categories as $category)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="categories[]"
                                                value="{{ $category->id }}"
                                                {{ is_array(request('categories')) && in_array($category->id, request('categories')) ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ $category->category_name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </aside>

                            <!-- Thuộc tính -->
                            <aside class="left_widgets p_filter_widgets mt-4">
                                <div class="l_w_title">
                                    <h3>Thuộc tính</h3>
                                </div>
                                <div class="widgets_inner">
                                    @foreach ($attributeValues->groupBy('attribute_id') as $group)
                                        <h5>{{ $group->first()->attribute->name }}</h5>
                                        @foreach ($group as $value)
                                            <label>
                                                <input type="checkbox" name="attribute_value_ids[]"
                                                    value="{{ $value->id }}"
                                                    {{ in_array($value->id, request()->get('attribute_value_ids', [])) ? 'checked' : '' }}>
                                                {{ $value->value }}
                                            </label><br>
                                        @endforeach
                                    @endforeach
                                </div>
                            </aside>

                            <!-- Giá -->
                            <aside class="left_widgets p_filter_widgets mt-4">
                                <div class="l_w_title">
                                    <h3>Lọc theo giá</h3>
                                </div>
                                <div class="widgets_inner">
                                    <label>Giá từ:</label>
                                    <input type="number" name="min_price" class="form-control mb-2"
                                        value="{{ request('min_price') }}" placeholder="0">

                                    <label>Đến:</label>
                                    <input type="number" name="max_price" class="form-control"
                                        value="{{ request('max_price') }}" placeholder="1000000">
                                </div>
                            </aside>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!--================Kết thúc Khu vực Sản phẩm Danh mục =================-->
@endsection