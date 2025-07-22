@extends('admins.layouts.default')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="" class="row g-3">
                    <div class="col-md-4">
                        <label for="search_product" class="form-label">Tên sản phẩm</label>
                        <input type="text" class="form-control" id="search_product" name="search_product" value="{{ request('search_product') }}" placeholder="Tìm theo tên sản phẩm...">
                    </div>
                    <div class="col-md-4">
                        <label for="search_user" class="form-label">Người dùng</label>
                        <input type="text" class="form-control" id="search_user" name="search_user" value="{{ request('search_user') }}" placeholder="Tìm theo tên người dùng...">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100"><i class="bx bx-search me-1"></i>Tìm kiếm</button>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <a href="{{ route('admin.reviews.list') }}" class="btn btn-outline-secondary w-100"><i class="bx bx-refresh me-1"></i>Reset</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title flex-grow-1">Danh sách đánh giá sản phẩm</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th>ID</th>
                                        <th>Sản phẩm</th>
                                        <th>Người dùng</th>
                                        <th>Số sao</th>
                                        <th>Bình luận</th>
                                        <th>Ngày tạo</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($reviews as $review)
                                    <tr>
                                        <td>{{ $review->id }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $review->product->name ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $review->user->name ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            @for($i=1; $i<=5; $i++)
                                                <i class="bx {{ $i <= $review->rating ? 'bxs-star text-warning' : 'bx-star text-muted' }}"></i>
                                            @endfor
                                            ({{ $review->rating }})
                                        </td>
                                        <td>{{ $review->comment }}</td>
                                        <td>
                                            {{ $review->created_at ? $review->created_at->format('d/m/Y H:i') : 'N/A' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                            <form action="{{ route('admin.reviews.delete', $review->id) }}" method="POST" style="display:inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa?')"><i class="bx bx-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Không có đánh giá nào.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{-- Phân trang nếu có --}}
                        @if(method_exists($reviews, 'links'))
                            <div class="mt-3">{{ $reviews->links() }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 