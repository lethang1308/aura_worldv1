@extends('admins.layouts.default')

@section('content')
<body>

    <!-- START Wrapper -->
    <div class="wrapper">
        <!-- Start right Content here -->
        <!-- ==================================================== -->
        <div class="page-content">

            <!-- Start Container Fluid -->
            <div class="container-xxl">

                <div class="row">
                    <div class="col-xl-3 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <img src="{{ asset('admin/assets/images/product/p-1.png') }}" alt="" class="img-fluid rounded bg-light">
                                <div class="mt-3">
                                    <h4>{{ isset($product) ? $product->name : 'New Product' }} <span class="fs-14 text-muted ms-1">(Fashion)</span>
                                    </h4>
                                    <h5 class="text-dark fw-medium mt-3">Price :</h5>
                                    <h4 class="fw-semibold text-dark mt-2 d-flex align-items-center gap-2">
                                        <span class="text-muted">${{ isset($product) ? $product->base_price : '0' }}</span>
                                    </h4>
                                </div>
                            </div>
                            <div class="card-footer bg-light-subtle">
                                <div class="row g-2">
                                    <div class="col-lg-6">
                                        <button type="submit" form="product-form" class="btn btn-outline-secondary w-100">{{ isset($product) ? 'Update Product' : 'Create Product' }}</button>
                                    </div>
                                    <div class="col-lg-6">
                                        <a href="{{ route('products.index') }}" class="btn btn-primary w-100">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-9 col-lg-8 ">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add Product Photo</h4>
                            </div>
                            <div class="card-body">
                                <!-- File Upload -->
                                <form action="https://techzaa.in/" method="post" class="dropzone"
                                    id="myAwesomeDropzone" data-plugin="dropzone"
                                    data-previews-container="#file-previews"
                                    data-upload-preview-template="#uploadPreviewTemplate">
                                    <div class="fallback">
                                        <input name="file" type="file" multiple />
                                    </div>
                                    <div class="dz-message needsclick">
                                        <i class="bx bx-cloud-upload fs-48 text-primary"></i>
                                        <h3 class="mt-4">Drop your images here, or <span class="text-primary">click to
                                                browse</span></h3>
                                        <span class="text-muted fs-13">
                                            1600 x 1200 (4:3) recommended. PNG, JPG and GIF files are allowed
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Product Information</h4>
                            </div>
                            <div class="card-body">
                                <form id="product-form" action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST">
                                    @csrf
                                    @if(isset($product))
                                        @method('PUT')
                                    @endif
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="product-name" class="form-label">Product Name</label>
                                                <input type="text" id="product-name" name="name" class="form-control"
                                                    placeholder="Items Name" value="{{ isset($product) ? $product->name : old('name') }}" required>
                                                @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="product-categories" class="form-label">Product Categories</label>
                                            <select class="form-control" id="product-categories" name="category_id" data-choices
                                                data-choices-groups data-placeholder="Select Categories" required>
                                                <option value="">Choose a categories</option>
                                                <option value="1" {{ (isset($product) && $product->category_id == 1) ? 'selected' : '' }}>Fashion</option>
                                                <option value="2" {{ (isset($product) && $product->category_id == 2) ? 'selected' : '' }}>Electronics</option>
                                            </select>
                                            @error('category_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-lg-4">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control bg-light-subtle" id="description" name="description" rows="7"
                                                    placeholder="Short description about the product">{{ isset($product) ? $product->description : old('description') }}</textarea>
                                                @error('description')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Pricing Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="product-price" class="form-label">Price</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text fs-20"><i class='bx bx-dollar'></i></span>
                                            <input type="number" id="product-price" name="base_price" class="form-control"
                                                placeholder="000" value="{{ isset($product) ? $product->base_price : old('base_price') }}" required>
                                        </div>
                                        @error('base_price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
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

</body>
@endsection
