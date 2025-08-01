@extends('admins.layouts.default')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Error Message -->
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Form tìm kiếm -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('banners.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="search_title" class="form-label">Tiêu đề banner</label>
                        <input type="text" class="form-control" id="search_title" name="search_title"
                            value="{{ request('search_title') }}" placeholder="Tìm theo tiêu đề...">
                    </div>

                    <div class="col-md-3">
                        <label for="search_status" class="form-label">Trạng thái</label>
                        <select class="form-select" id="search_status" name="search_status">
                            <option value="">Tất cả trạng thái</option>
                            <option value="active" {{ request('search_status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="inactive" {{ request('search_status') == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Tìm kiếm
                            </button>
                            <a href="{{ route('banners.index') }}" class="btn btn-secondary">
                                <i class="fas fa-refresh"></i> Làm mới
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Danh sách Banner</h4>
                        <div>
                            <a href="{{ route('banners.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Thêm Banner
                            </a>
                            <a href="{{ route('banners.trash') }}" class="btn btn-warning">
                                <i class="fas fa-trash"></i> Thùng rác
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ảnh</th>
                                        <th>Tiêu đề</th>
                                        <th>Mô tả</th>
                                        <th>Link</th>
                                        <th>Loại banner</th>
                                        <th>Trạng thái</th>
                                        <th>Thứ tự</th>
                                        <th>Ngày tạo</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($banners as $banner)
                                        <tr>
                                            <td>{{ $banner->id }}</td>
                                            <td>
                                                @if($banner->image)
                                                    <img src="{{ asset('storage/' . $banner->image) }}" 
                                                         alt="{{ $banner->title }}" 
                                                         class="img-thumbnail" 
                                                         style="max-width: 100px; max-height: 60px;">
                                                @else
                                                    <span class="text-muted">Không có ảnh</span>
                                                @endif
                                            </td>
                                            <td>{{ $banner->title }}</td>
                                            <td>
                                                @if($banner->description)
                                                    {{ Str::limit($banner->description, 50) }}
                                                @else
                                                    <span class="text-muted">Không có mô tả</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($banner->link)
                                                    <a href="{{ $banner->link }}" target="_blank" class="text-primary">
                                                        {{ Str::limit($banner->link, 30) }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">Không có link</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($banner->type == 'main')
                                                    <span class="badge bg-primary">Banner chính</span>
                                                @else
                                                    <span class="badge bg-info">Banner phụ</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($banner->status == 'active')
                                                    <span class="badge bg-success">Hoạt động</span>
                                                @else
                                                    <span class="badge bg-secondary">Không hoạt động</span>
                                                @endif
                                            </td>
                                            <td>{{ $banner->sort_order }}</td>
                                            <td>{{ $banner->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('banners.show', $banner->id) }}" 
                                                       class="btn btn-sm btn-info" title="Xem chi tiết">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('banners.edit', $banner->id) }}" 
                                                       class="btn btn-sm btn-warning" title="Sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('banners.destroy', $banner->id) }}" 
                                                          method="POST" 
                                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa banner này?')"
                                                          style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">Không có banner nào</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $banners->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 