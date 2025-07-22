@extends('clients.layouts.default')

@section('content')
<section class="banner_area">
    <div class="banner_inner d-flex align-items-center">
        <div class="container">
            <div class="banner_content d-md-flex justify-content-between align-items-center">
                <div class="mb-3 mb-md-0">
                    <h2>Thương Hiệu Nước Hoa</h2>
                    <p>Khám phá những thương hiệu nổi bật trên thị trường</p>
                </div>
                <div class="page_link">
                    <a href="">Trang chủ</a>
                    <a href="#">Thương hiệu</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="brand_list_area section_gap">
    <div class="container">
        <div class="row justify-content-center">
            @foreach($brands as $brand)
                <div class="col-lg-2 col-md-3 col-4 mb-4 text-center">
                    <a href="{{ route('client.products', ['brand' => $brand->id]) }}" title="Sản phẩm từ {{ $brand->name }}">
                        <div class="border p-2 bg-white shadow-sm rounded">
                            <img src="{{ asset($brand->logo) }}"
                                 alt="{{ $brand->name }}" class="img-fluid mb-2" style="max-height: 50px; object-fit: contain;">
                            <h6 class="mt-1 text-dark">{{ $brand->name }}</h6>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
