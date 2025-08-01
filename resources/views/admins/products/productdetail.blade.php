@extends('admins.layouts.default')

@section('content')

<body>

    <!-- START Wrapper -->
    <div class="wrapper">
        <!-- ==================================================== -->
        <!-- Start right Content here -->
        <!-- ==================================================== -->
        <div class="page-content">

            <!-- Start Container Fluid -->
            <div class="container-xxl">

                <div class="row">
                    <!-- Cột ảnh -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <!-- Crossfade -->
                                @php
                                    $sortedImages = $product->images->sortByDesc('is_featured')->values();
                                @endphp

                                <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel"
                                    data-bs-interval="2000">
                                    <div class="carousel-inner" role="listbox">
                                        @foreach ($sortedImages as $index => $image)
                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                <img src="{{ asset('storage/' . $image->path) }}" alt="Product Image"
                                                    class="img-fluid bg-light rounded">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="carousel-indicators m-0 mt-2 d-lg-flex d-none position-static h-100">
                                        @foreach ($sortedImages as $index => $image)
                                            <button type="button" data-bs-target="#carouselExampleFade"
                                                data-bs-slide-to="{{ $index }}"
                                                aria-label="Slide {{ $index + 1 }}"
                                                class="w-auto h-auto rounded bg-light {{ $index === 0 ? 'active' : '' }}">
                                                <img src="{{ asset('storage/' . $image->path) }}"
                                                    class="d-block avatar-xl" alt="swiper-indicator-img">
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cột thông tin + gộp chi tiết -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="badge bg-success text-light fs-14 py-1 px-2">Hàng mới về</h4>
                                <p class="mb-1">
                                    <a href="#!" class="fs-24 text-dark fw-medium">{{ $product->name }}</a>
                                </p>
                                <div class="d-flex gap-2 align-items-center">
                                    <ul class="d-flex text-warning m-0 fs-20  list-unstyled">
                                        <li><i class="bx bxs-star"></i></li>
                                        <li><i class="bx bxs-star"></i></li>
                                        <li><i class="bx bxs-star"></i></li>
                                        <li><i class="bx bxs-star"></i></li>
                                        <li><i class="bx bxs-star-half"></i></li>
                                    </ul>
                                    <p class="mb-0 fw-medium fs-18 text-dark">4.5 <span class="text-muted fs-13">(55
                                            Đánh giá)</span></p>
                                </div>
                                <h2 class="fw-medium my-3">{{ number_format($product->base_price, 0, ',', '.') }} ₫</h2>

                                <!-- Thông tin ngắn -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Thương hiệu:</strong>
                                            <span class="badge bg-primary">{{ $product->brand->name ?? 'Không có' }}</span>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Danh mục:</strong>
                                            <span class="badge bg-info">{{ $product->category->category_name ?? 'Không có' }}</span>
                                        </p>
                                    </div>
                                </div>

                                <!-- Mô tả -->
                                <h4 class="text-dark fw-medium">Mô tả:</h4>
                                <p class="text-muted">{{ $product->description ?? 'Không có mô tả.' }}</p>

                                <!-- Gộp chi tiết sản phẩm vào đây -->
                                <hr>
                                <h5 class="text-dark fw-semibold mt-3">Chi tiết sản phẩm:</h5>
                                <ul class="d-flex flex-column gap-2 list-unstyled fs-14 text-muted mb-0">
                                    <li><span class="fw-medium text-dark">Mã sản phẩm</span><span class="mx-2">:</span>{{ $product->id }}</li>
                                    {{-- <li><span class="fw-medium text-dark">Danh mục</span><span class="mx-2">:</span>{{ $product->category->category_name ?? 'Không có' }} --}}
                                        {{-- <small class="text-muted">(ID: {{ $product->category_id }})</small> --}}
                                    </li>
                                    <li><span class="fw-medium text-dark">Thương hiệu</span><span class="mx-2">:</span>{{ $product->brand->name ?? 'Không có' }}
                                        @if ($product->brand)
                                            <small class="text-muted">(ID: {{ $product->brand->id }})</small>
                                        @endif
                                    </li>
                                    {{-- <li><span class="fw-medium text-dark">Giá</span><span class="mx-2">:</span>{{ number_format($product->base_price, 0, ',', '.') }} ₫</li> --}}
                                    <li><span class="fw-medium text-dark">Ngày tạo</span><span class="mx-2">:</span>{{ $product->created_at->format('d/m/Y H:i') }}</li>
                                    <li><span class="fw-medium text-dark">Ngày cập nhật</span><span class="mx-2">:</span>{{ $product->updated_at->format('d/m/Y H:i') }}</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Nút riêng ngoài card -->
                        <div class="mt-3 d-flex">
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning me-2">Chỉnh sửa sản phẩm</a>
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Container Fluid -->

        </div>
        <!-- ==================================================== -->
        <!-- End Page Content -->
        <!-- ==================================================== -->

    </div>
    <!-- END Wrapper -->

    <!-- Vendor Javascript (Require in all Page) -->
    <script src="{{ asset('admin/assets/js/vendor.js') }}"></script>

    <!-- App Javascript (Require in all Page) -->
    <script src="{{ asset('admin/assets/js/app.js') }}"></script>

    <script src="{{ asset('admin/assets/js/pages/product-details.js') }}"></script>

</body>
@endsection
