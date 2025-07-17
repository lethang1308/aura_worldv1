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
                                <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                    <div class="carousel-inner" role="listbox">
                                        <div class="carousel-item active">
                                            <img src="{{ asset('admin/assets/images/product/p-1.png') }}" alt=""
                                                class="img-fluid bg-light rounded">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{ asset('admin/assets/images/product/p-10.png') }}" alt=""
                                                class="img-fluid bg-light rounded">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{ asset('admin/assets/images/product/p-13.png') }}" alt=""
                                                class="img-fluid bg-light rounded">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{ asset('admin/assets/images/product/p-14.png') }}" alt=""
                                                class="img-fluid bg-light rounded">
                                        </div>
                                    </div>
                                    <div class="carousel-indicators m-0 mt-2 d-lg-flex d-none position-static h-100">
                                        <button type="button" data-bs-target="#carouselExampleFade"
                                            data-bs-slide-to="0" aria-current="true" aria-label="Slide 1"
                                            class="w-auto h-auto rounded bg-light active">
                                            <img src="{{ asset('admin/assets/images/product/p-1.png') }}" class="d-block avatar-xl"
                                                alt="swiper-indicator-img">
                                        </button>
                                        <button type="button" data-bs-target="#carouselExampleFade"
                                            data-bs-slide-to="1" aria-label="Slide 2"
                                            class="w-auto h-auto rounded bg-light">
                                            <img src="{{ asset('admin/assets/images/product/p-10.png') }}" class="d-block avatar-xl"
                                                alt="swiper-indicator-img">
                                        </button>
                                        <button type="button" data-bs-target="#carouselExampleFade"
                                            data-bs-slide-to="2" aria-label="Slide 3"
                                            class="w-auto h-auto rounded bg-light">
                                            <img src="{{ asset('admin/assets/images/product/p-13.png') }}" class="d-block avatar-xl"
                                                alt="swiper-indicator-img">
                                        </button>
                                        <button type="button" data-bs-target="#carouselExampleFade"
                                            data-bs-slide-to="3" aria-label="Slide 4"
                                            class="w-auto h-auto rounded bg-light">
                                            <img src="{{ asset('admin/assets/images/product/p-14.png') }}" class="d-block avatar-xl"
                                                alt="swiper-indicator-img">
                                        </button>
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

                                <div class="quantity mt-4">
                                    <h4 class="text-dark fw-medium mt-3">Quantity :</h4>
                                    <div
                                        class="input-step border bg-body-secondary p-1 mt-1 rounded d-inline-flex overflow-visible">
                                        <button type="button"
                                            class="minus bg-light text-dark border-0 rounded-1 fs-20 lh-1 h-100">-</button>
                                        <input type="number"
                                            class="text-dark text-center border-0 bg-body-secondary rounded h-100"
                                            value="1" min="0" max="100" readonly="">
                                        <button type="button"
                                            class="plus bg-light text-dark border-0 rounded-1 fs-20 lh-1 h-100">+</button>
                                    </div>
                                </div>
                                <h4 class="text-dark fw-medium">Description :</h4>
                                <p class="text-muted">{{ $product->description ?? 'No description available.' }}</p>
                                
                                <div class="mt-4">
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning me-2">Edit Product</a>
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
                                                class="mx-2">:</span>{{ $product->created_at->format('M d, Y') }}</li>
                                        <li><span class="fw-medium text-dark">Updated</span><span
                                                class="mx-2">:</span>{{ $product->updated_at->format('M d, Y') }}</li>
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