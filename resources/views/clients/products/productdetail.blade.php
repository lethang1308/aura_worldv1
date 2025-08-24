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

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
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

    @if (!empty($error))
        <div class="container mt-5">
            <div class="alert alert-danger text-center">{{ $error }}</div>
            <div class="text-center">
                <a href="{{ route('client.home') }}" class="btn btn-primary mt-3">Quay về trang chủ</a>
            </div>
        </div>
    @else
        <section class="banner_area">
            <div class="banner_inner d-flex align-items-center">
                <div class="container">
                    <div class="banner_content d-md-flex justify-content-between align-items-center">
                        <div class="mb-3 mb-md-0">
                            <h2>Chi tiết sản phẩm</h2>
                            <p>Thông tin chi tiết về sản phẩm bạn quan tâm</p>
                        </div>
                        <div class="page_link">
                            <a href="{{ route('client.home') }}">Trang chủ</a>
                            <a href="#">Chi tiết sản phẩm</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

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
                                            <img class="d-block w-100" src="{{ asset('storage/' . $image->path) }}"
                                                alt="Ảnh sản phẩm">
                                        </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                    data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Trước</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                    data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Sau</span>
                                </a>
                                <ol class="carousel-indicators mt-3">
                                    @foreach ($sortedImages as $index => $image)
                                        <li data-target="#carouselExampleIndicators" data-slide-to="{{ $index }}"
                                            class="{{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $image->path) }}" class="d-block"
                                                width="60">
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 offset-lg-1">
                        <div class="s_product_text">
                            <h3>{{ $product->name }}</h3>
                            <h2 id="product-price">{{ number_format($product->base_price, 0, ',', '.') }} VNĐ</h2>
                            <ul class="list">
                                <li><a><span>Danh mục:</span> {{ $product->category->category_name }}</a></li>
                                <li><a><span>Thương hiệu:</span> {{ $product->brand->name }}</a></li>
                                <li>
                                    <a><span>Trạng thái:</span>
                                        @if ($product->status === 'active')
                                            <span class="text-success font-weight-bold">✅ Còn hàng</span>
                                        @else
                                            <span class="text-danger font-weight-bold">❌ Hết hàng</span>
                                        @endif
                                    </a>
                                </li>

                                <li class="mb-4">
                                    <span class="fw-bold text-dark fs-6 d-block mb-2">Dung tích:</span>
                                    <div class="d-flex flex-wrap gap-2" id="attribute-buttons">
                                        @php
                                            // Tìm dung tích có giá thấp nhất
                                            $lowestPriceAttr = null;
                                            $lowestPrice = PHP_INT_MAX;
                                            
                                            foreach ($attributeValues as $attr) {
                                                $price = $attr['price'] ?? 0;
                                                if ($price < $lowestPrice) {
                                                    $lowestPrice = $price;
                                                    $lowestPriceAttr = $attr;
                                                }
                                            }
                                        @endphp
                                        @foreach ($attributeValues as $attr)
                                            @php
                                                $variant = \App\Models\Variant::find($attr['variant_id']);
                                                $variantPrice = $attr['price'] ?? 0;
                                                $isOutOfStock = ($variant->stock_quantity ?? 0) <= 0;
                                                $isLowestPrice = $attr === $lowestPriceAttr;
                                            @endphp
                                            <button type="button"
                                                class="btn attribute-button {{ $isLowestPrice ? 'btn-success' : 'btn-outline-success' }} px-3 py-2 fw-semibold rounded-2"
                                                data-variant-id="{{ $attr['variant_id'] }}"
                                                data-price="{{ $variantPrice }}"
                                                data-stock="{{ $variant->stock_quantity ?? 0 }}">
                                                {{ $attr['value'] ?? 'Không rõ' }}
                                                @if ($isOutOfStock)
                                                    <span class="badge badge-danger ml-2">Hết hàng</span>
                                                @endif
                                            </button>
                                        @endforeach
                                    </div>
                                </li>
                                <li>
                                    <span id="stock-display">Số lượng còn lại: --</span>
                                </li>
                            </ul>
                            <p>{{ $product->description }}</p>

                            <div class="card_area">
                                <form method="POST" action="{{ route('client.carts.add') }}" id="add-to-cart-form">
                                    @csrf
                                    <div class="product_count">
                                        <label for="qty">Số lượng:</label>
                                        <input type="number" name="quantity" id="sst" value="1" min="1"
                                            class="input-text qty" />
                                        <button type="button" onclick="document.getElementById('sst').stepUp()"
                                            class="increase items-count"><i class="lnr lnr-chevron-up"></i></button>
                                        <button type="button" onclick="document.getElementById('sst').stepDown()"
                                            class="reduced items-count"><i class="lnr lnr-chevron-down"></i></button>
                                    </div>
                                    <input type="hidden" name="variant_id" id="variant_id_hidden" value="">
                                    <input type="hidden" name="product_name" value="{{ $product->name }}">
                                    <button type="submit" id="add-to-cart-button" class="main_btn">Thêm vào giỏ
                                        hàng</button>
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
                    <li class="nav-item"><a class="nav-link active" id="review-tab" data-toggle="tab" href="#review"
                            role="tab">Reviews</a></li>
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
                                            <h5>Tổng số sao</h5>
                                            <h4>{{ $average }}</h4>
                                            <h6>({{ str_pad($totalReviews, 2, '0', STR_PAD_LEFT) }} Bình luận)</h6>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="rating_list">
                                            <h3>Dựa trên {{ $totalReviews }} đánh giá</h3>
                                            <ul class="list">
                                                @for ($i = 5; $i >= 1; $i--)
                                                    <li>
                                                        <a href="#">{{ $i }} Sao
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
                                                <small
                                                    class="text-muted">{{ $review->created_at ? $review->created_at->format('d/m/Y H:i') : 'N/A' }}</small>
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
                                        <form id="review-form" class="row contact_form"
                                            action="{{ route('review.add', $product->id) }}" method="POST">
                                            @csrf
                                            <div id="review-alert"></div>
                                            <div class="col-md-12 mb-2">
                                                <select name="rating" class="form-control">
                                                    <option value="">Chọn số sao</option>
                                                    @for ($i = 5; $i >= 1; $i--)
                                                        <option value="{{ $i }}">
                                                            {!! str_repeat('&#9733;', $i) !!}
                                                        </option>
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
            document.addEventListener('DOMContentLoaded', function() {
                const buttons = document.querySelectorAll('.attribute-button');
                const priceDisplay = document.getElementById('product-price');
                const variantInput = document.getElementById('variant_id_hidden');
                const stockDisplay = document.getElementById('stock-display');
                const defaultPrice = '{{ $product->base_price }}';
                const form = document.getElementById('add-to-cart-form');
                const addToCartBtn = document.getElementById('add-to-cart-button');

                function formatCurrency(amount) {
                    return new Intl.NumberFormat('vi-VN').format(amount) + ' VNĐ';
                }

                function selectVariant(btn) {
                    const price = parseFloat(btn.dataset.price || 0);
                    const basePrice = parseFloat(defaultPrice);
                    const totalPrice = basePrice + price;

                    const variantId = btn.dataset.variantId;
                    const stock = parseInt(btn.dataset.stock || 0);

                    priceDisplay.innerText = formatCurrency(totalPrice);
                    variantInput.value = variantId;
                    stockDisplay.innerText = 'Số lượng còn lại: ' + stock;

                    // Style selected button
                    buttons.forEach(b => {
                        b.classList.remove('btn-success');
                        b.classList.add('btn-outline-success');
                    });
                    btn.classList.remove('btn-outline-success');
                    btn.classList.add('btn-success');

                    // Disable "Thêm vào giỏ hàng" nếu hết hàng
                    if (stock <= 0) {
                        addToCartBtn.disabled = true;
                        addToCartBtn.innerText = 'Hết hàng';
                        addToCartBtn.classList.add('disabled', 'btn-secondary');
                    } else {
                        addToCartBtn.disabled = false;
                        addToCartBtn.innerText = 'Thêm vào giỏ hàng';
                        addToCartBtn.classList.remove('disabled', 'btn-secondary');
                    }
                }

                // Tự động chọn dung tích có giá thấp nhất khi trang load
                const selectedButton = document.querySelector('.attribute-button.btn-success');
                if (selectedButton) {
                    selectVariant(selectedButton);
                }

                buttons.forEach(btn => {
                    btn.addEventListener('click', () => {
                        selectVariant(btn);
                    });
                });

                form.addEventListener('submit', function(e) {
                    if (!variantInput.value) {
                        e.preventDefault();
                        alert('Vui lòng chọn dung tích trước khi thêm vào giỏ hàng!');
                        return;
                    }

                    const selectedBtn = document.querySelector('.attribute-button.btn-success');
                    const stock = parseInt(selectedBtn?.dataset.stock || 0);
                    const quantity = parseInt(document.getElementById('sst').value || 1);

                    if (stock <= 0) {
                        e.preventDefault();
                        alert('Sản phẩm bạn chọn hiện đã hết hàng.');
                        return;
                    }

                    if (quantity > stock) {
                        e.preventDefault();
                        alert('Số lượng vượt quá số lượng còn trong kho.');
                        return;
                    }
                });

                // Ajax submit form đánh giá
                const reviewForm = document.getElementById('review-form');
                if (reviewForm) {
                    reviewForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const alertBox = document.getElementById('review-alert');
                        alertBox.innerHTML = '';

                        const formData = new FormData(reviewForm);
                        fetch(reviewForm.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': formData.get('_token'),
                                    'Accept': 'application/json'
                                },
                                body: formData
                            })
                            .then(response => response.json().then(data => ({
                                status: response.status,
                                body: data
                            })))
                            .then(({
                                status,
                                body
                            }) => {
                                if (status === 422) {
                                    // Validation errors
                                    const errors = Object.values(body.errors).flat();
                                    alertBox.innerHTML =
                                        `<div class="alert alert-danger">${errors.join('<br>')}</div>`;
                                } else if (status !== 200) {
                                    alertBox.innerHTML =
                                        `<div class="alert alert-danger">${body.message || 'Có lỗi xảy ra.'}</div>`;
                                } else {
                                    alertBox.innerHTML =
                                        `<div class="alert alert-success">${body.message}</div>`;
                                    reviewForm.reset();
                                    // Optional: reload danh sách đánh giá qua AJAX ở đây
                                }
                            })
                            .catch(() => {
                                alertBox.innerHTML =
                                    `<div class="alert alert-danger">Lỗi kết nối máy chủ.</div>`;
                            });
                    });
                }
            });
        </script>
    @endif
@endsection