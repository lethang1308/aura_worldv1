@extends('clients.layouts.default')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Đóng">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Đóng">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!--=============== Banner Area ===============-->
    <section class="banner_area">
        <div class="banner_inner d-flex align-items-center">
            <div class="container">
                <div class="banner_content d-md-flex justify-content-between align-items-center">
                    <div class="mb-3 mb-md-0">
                        <h2>Product Details</h2>
                        <p>Very us move be blessed multiply night</p>
                    </div>
                    <div class="page_link">
                        <a href="{{ route('client.home') }}">Home</a>
                        <a href="#">Product Details</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--=============== Product Area ===============-->
    <div class="product_image_area">
        <div class="container">
            <div class="row s_product_inner">
                <div class="col-lg-6">
                    <div class="s_product_img">
                        @php
                            $sortedImages = $product->images->sortByDesc('is_featured')->values();
                        @endphp
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($sortedImages as $index => $image)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img class="d-block w-100" src="{{ asset('storage/' . $image->path) }}" alt="Product Image">
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                            <ol class="carousel-indicators mt-3">
                                @foreach ($sortedImages as $index => $image)
                                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $image->path) }}" class="d-block" width="60">
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 offset-lg-1">
                    <div class="s_product_text">
                        <h3>{{ $product->name }}</h3>
                        <h2 id="product-price">{{ $product->base_price }}$</h2>
                        <ul class="list">
                            <li><a><span>Category</span>{{ $product->category->category_name }}</a></li>
                            <li><a><span>Brand</span>{{ $product->brand->name }}</a></li>
                            <li class="mb-4">
                                <span class="fw-bold text-dark fs-6 d-block mb-2">Dung tích:</span>
                                <div class="d-flex flex-wrap gap-2" id="attribute-buttons">
                                    @foreach ($attributeValues as $attr)
                                        <button type="button"
                                            class="btn btn-outline-success attribute-button {{ $loop->first ? 'btn-success' : '' }} px-3 py-2 fw-semibold rounded-2"
                                            data-variant-id="{{ $attr['variant_id'] }}"
                                            data-price="{{ $attr['price'] ?? $product->base_price }}">
                                            {{ $attr['value'] ?? 'N/A' }}
                                        </button>
                                    @endforeach
                                </div>
                            </li>
                            <li>
                                <a><span>Availability</span>: {{ $product->status == 'active' ? 'Còn hàng' : 'Hết hàng' }}</a>
                            </li>
                        </ul>
                        <p>{{ $product->description }}</p>
                        <div class="card_area">
                            <form method="POST" action="{{ route('client.carts.add') }}" id="add-to-cart-form">
                                @csrf
                                <div class="product_count">
                                    <label for="qty">Quantity:</label>
                                    <input type="number" name="quantity" id="sst" value="1" min="1" class="input-text qty" />
                                    <button type="button" onclick="document.getElementById('sst').stepUp()" class="increase items-count"><i class="lnr lnr-chevron-up"></i></button>
                                    <button type="button" onclick="document.getElementById('sst').stepDown()" class="reduced items-count"><i class="lnr lnr-chevron-down"></i></button>
                                </div>
                                <input type="hidden" name="variant_id" id="variant_id_hidden" value="">
                                <button type="submit" class="main_btn">Thêm vào giỏ</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--=============== Review Area ===============-->
    <section class="product_description_area">
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab">Reviews</a></li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="review" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-6">
                            @php
                                $totalReviews = $product->reviews->count();
                                $totalStars = $product->reviews->sum('rating');
                                $average = $totalReviews > 0 ? round($totalStars / $totalReviews, 1) : 0;

                                $starCounts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
                                foreach ($product->reviews as $rev) {
                                    $starCounts[$rev->rating] = ($starCounts[$rev->rating] ?? 0) + 1;
                                }
                            @endphp
                            <div class="row total_rate">
                                <div class="col-6">
                                    <div class="box_total">
                                        <h5>Overall</h5>
                                        <h4>{{ $average }}</h4>
                                        <h6>({{ str_pad($totalReviews, 2, '0', STR_PAD_LEFT) }} Reviews)</h6>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="rating_list">
                                        <h3>Based on {{ $totalReviews }} Reviews</h3>
                                        <ul class="list">
                                            @for ($i = 5; $i >= 1; $i--)
                                                <li>
                                                    <a href="#">{{ $i }} Star
                                                        @for ($j = 0; $j < 5; $j++)
                                                            <i class="fa fa-star{{ $j < $i ? '' : '-o' }}"></i>
                                                        @endfor
                                                        {{ str_pad($starCounts[$i] ?? 0, 2, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                </li>
                                            @endfor
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="review_list">
                                @forelse ($product->reviews as $review)
                                    <div class="review_item mb-3">
                                        <div class="media-body">
                                            <h5>{{ $review->user->name }}</h5>
                                            <div class="mb-1 text-warning">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fa fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                                @endfor
                                            </div>
                                            <p class="mb-0">{{ $review->comment }}</p>
                                            <small class="text-muted">{{ $review->created_at ? $review->created_at->format('d/m/Y H:i') : 'N/A' }}</small>
                                        </div>
                                    </div>
                                @empty
                                    <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="review_box">
                                <h4>Thêm đánh giá</h4>
                                @auth
                                    <form class="row contact_form" action="{{ route('review.add', $product->id) }}" method="POST">
                                        @csrf
                                        <div class="col-md-12 mb-2">
                                            <select name="rating" class="form-control" required>
                                                <option value="">Chọn số sao</option>
                                                @for ($i = 5; $i >= 1; $i--)
                                                    <option value="{{ $i }}">{{ $i }} sao</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <textarea class="form-control" name="comment" rows="3" placeholder="Nhận xét của bạn (tùy chọn)"></textarea>
                                        </div>
                                        <div class="col-md-12 text-right">
                                            <button type="submit" class="btn submit_btn">Gửi đánh giá</button>
                                        </div>
                                    </form>
                                @else
                                    <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để viết đánh giá.</p>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.attribute-button');
            const priceDisplay = document.getElementById('product-price');
            const variantInput = document.getElementById('variant_id_hidden');
            const defaultPrice = '{{ $product->base_price }}';
            const form = document.getElementById('add-to-cart-form');

            buttons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const price = btn.dataset.price;
                    const variantId = btn.dataset.variantId;

                    priceDisplay.innerText = (price && price !== 'N/A') ? price + '$' : defaultPrice + '$';
                    variantInput.value = variantId;

                    buttons.forEach(b => {
                        b.classList.remove('btn-primary');
                        b.classList.add('btn-outline-secondary');
                    });
                    btn.classList.remove('btn-outline-secondary');
                    btn.classList.add('btn-primary');
                });
            });

            form.addEventListener('submit', function (e) {
                if (!variantInput.value) {
                    e.preventDefault();
                    alert('Vui lòng chọn dung tích trước khi thêm vào giỏ hàng!');
                }
            });
        });
    </script>
@endsection
