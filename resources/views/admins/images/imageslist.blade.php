@extends('admins.layouts.default')

@section('content')
    <div class="wrapper">
        <div class="page-content">
            <div class="container-xxl">
                <div class="row">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title flex-grow-1">Danh sách ảnh sản phẩm</h4>

                        <form action="{{ route('products.images.list') }}" method="GET"
                            class="d-flex gap-2 align-items-center">
                            <select name="product_id" class="form-select form-select-sm">
                                <option value="">-- Chọn sản phẩm --</option>
                                @foreach ($products as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ request('product_id') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">Lọc</button>
                            <a href="{{ route('products.images.list') }}" class="btn btn-sm btn-secondary">
                                Xoá lọc
                            </a>
                        </form>
                    </div>

                    <div class="row g-3">
                        @forelse ($images as $image)
                            <div class="col-md-3">
                                <div class="card position-relative h-100 border {{ $image->is_featured ? 'border-success' : '' }}"
                                    style="max-height: 300px">
                                    {{-- Hiển thị ảnh --}}
                                    <img src="{{ asset('storage/' . $image->path) }}" class="card-img-top"
                                        style="height: 200px; object-fit: cover;" alt="Ảnh sản phẩm">

                                    {{-- Badge nếu là ảnh nổi bật --}}
                                    @if ($image->is_featured)
                                        <span class="badge bg-success position-absolute top-0 start-0 m-2">Ảnh nổi
                                            bật</span>
                                    @endif

                                    <div class="card-body p-2">
                                        <h6 class="text-truncate mb-1">{{ $image->product->name ?? 'Sản phẩm đã xoá' }}</h6>

                                        {{-- Nút xoá --}}
                                        <form action="{{ route('products.images.destroy', $image->id) }}" method="POST"
                                            class="d-inline float-end"
                                            onsubmit="return confirm('Bạn chắc chắn muốn xoá ảnh này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"><i class="bx bx-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center text-muted py-5">
                                <div class="mb-3">
                                    <i class="bx bx-image" style="font-size: 48px; color: #6c757d;"></i>
                                </div>
                                <h5 class="text-muted">No Images Found</h5>
                                <p class="text-muted">There are no product images in the system yet.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Custom Pagination --}}
                    @if (isset($images) && method_exists($images, 'hasPages') && $images->hasPages())
                        <div
                            class="d-flex flex-column flex-sm-row justify-content-between align-items-center mt-4 pt-3 border-top">
                            <!-- Hiển thị thông tin số lượng -->
                            <div class="mb-3 mb-sm-0">
                                <p class="text-muted mb-0 fs-13">
                                    Trang {{ $images->firstItem() }} / {{ $images->lastItem() }} của
                                    {{ $images->total() }} ảnh
                                </p>
                            </div>

                            <!-- Custom Pagination -->
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-rounded mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($images->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link" aria-hidden="true">
                                                <i class="bx bx-chevron-left"></i>
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $images->previousPageUrl() }}" rel="prev"
                                                aria-label="Previous">
                                                <i class="bx bx-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($images->getUrlRange(1, $images->lastPage()) as $page => $url)
                                        @if ($page == $images->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($images->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $images->nextPageUrl() }}" rel="next"
                                                aria-label="Next">
                                                <i class="bx bx-chevron-right"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link" aria-hidden="true">
                                                <i class="bx bx-chevron-right"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
