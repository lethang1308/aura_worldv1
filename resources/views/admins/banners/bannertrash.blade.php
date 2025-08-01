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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Thùng rác - Banner</h4>
                        <div>
                            <a href="{{ route('banners.index') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left"></i> Quay lại danh sách
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
                                        <th>Trạng thái</th>
                                        <th>Thứ tự</th>
                                        <th>Ngày xóa</th>
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
                                                @if($banner->status == 'active')
                                                    <span class="badge bg-success">Hoạt động</span>
                                                @else
                                                    <span class="badge bg-secondary">Không hoạt động</span>
                                                @endif
                                            </td>
                                            <td>{{ $banner->sort_order }}</td>
                                            <td>{{ $banner->deleted_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <form action="{{ route('banners.restore', $banner->id) }}" 
                                                          method="POST" 
                                                          style="display: inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-success" 
                                                                title="Khôi phục"
                                                                onclick="return confirm('Bạn có chắc chắn muốn khôi phục banner này?')">
                                                            <i class="fas fa-undo"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('banners.forceDelete', $banner->id) }}" 
                                                          method="POST" 
                                                          style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                                title="Xóa vĩnh viễn"
                                                                onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn banner này? Hành động này không thể hoàn tác!')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">Thùng rác trống</td>
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