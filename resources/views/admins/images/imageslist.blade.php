@extends('admins.layouts.default')

@section('content')
    <div class="wrapper">
        <div class="page-content">
            <div class="container-xxl">
                <div class="row">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title flex-grow-1">All Product List</h4>
                    </div>

                    <div class="row g-3">
                        @forelse ($images as $image)
                            <div class="col-md-3">
                                <div
                                    class="card position-relative h-100 border {{ $image->is_featured ? 'border-success' : '' }}">
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
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger"><i class="bx bx-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center text-muted">Không có ảnh nào.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
