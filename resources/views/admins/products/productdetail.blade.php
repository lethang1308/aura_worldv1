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
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="badge bg-success text-light fs-14 py-1 px-2">New Arrival</h4>
                                    <p class="mb-1">
                                        <a href="#!" class="fs-24 text-dark fw-medium">{{ $product->name }}</a>
                                    </p>
                                    <div class="d-flex gap-2 align-items-center">
                                        <ul class="d-flex text-warning m-0 fs-20  list-unstyled">
                                            <li>
                                                <i class="bx bxs-star"></i>
                                            </li>
                                            <li>
                                                <i class="bx bxs-star"></i>
                                            </li>
                                            <li>
                                                <i class="bx bxs-star"></i>
                                            </li>
                                            <li>
                                                <i class="bx bxs-star"></i>
                                            </li>
                                            <li>
                                                <i class="bx bxs-star-half"></i>
                                            </li>
                                        </ul>
                                        <p class="mb-0 fw-medium fs-18 text-dark">4.5 <span class="text-muted fs-13">(55
                                                Review)</span></p>
                                    </div>
                                    <h2 class="fw-medium my-3">${{ $product->base_price }} <span class="fs-16"></span></h2>

                                    <p><strong>Thương hiệu:</strong> {{ $product->brand->name ?? 'Không có' }}</p>

                                    <h4 class="text-dark fw-medium">Description :</h4>
                                    <p class="text-muted">{{ $product->description ?? 'No description available.' }}</p>

                                    <div class="mt-4">
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="btn btn-warning me-2">Edit Product</a>
                                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to List</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Items Detail</h4>
                                </div>
                                <div class="card-body">
                                    <div class="">
                                        <ul class="d-flex flex-column gap-2 list-unstyled fs-14 text-muted mb-0">
                                            <li><span class="fw-medium text-dark">Product ID</span><span
                                                    class="mx-2">:</span>{{ $product->id }}</li>
                                            <li><span class="fw-medium text-dark">Category ID</span><span
                                                    class="mx-2">:</span>{{ $product->category_id }}</li>
                                            <li><span class="fw-medium text-dark">Price</span><span
                                                    class="mx-2">:</span>${{ $product->base_price }}</li>
                                            <li><span class="fw-medium text-dark">Created</span><span
                                                    class="mx-2">:</span>{{ $product->created_at }}</li>
                                            <li><span class="fw-medium text-dark">Updated</span><span
                                                    class="mx-2">:</span>{{ $product->updated_at }}</li>
                                        </ul>
                                    </div>
                                </div>
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
