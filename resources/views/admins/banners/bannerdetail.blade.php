@extends('admins.layouts.default')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Chi tiết Banner</h4>
                        <div>
                            <a href="{{ route('banners.edit', $banner->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Chỉnh sửa
                            </a>
                            <a href="{{ route('banners.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="150">ID:</th>
                                        <td>{{ $banner->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tiêu đề:</th>
                                        <td>{{ $banner->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mô tả:</th>
                                        <td>
                                            @if($banner->description)
                                                {{ $banner->description }}
                                            @else
                                                <span class="text-muted">Không có mô tả</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Link:</th>
                                        <td>
                                            @if($banner->link)
                                                <a href="{{ $banner->link }}" target="_blank" class="text-primary">
                                                    {{ $banner->link }}
                                                </a>
                                            @else
                                                <span class="text-muted">Không có link</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Loại banner:</th>
                                        <td>
                                            @if($banner->type == 'main')
                                                <span class="badge bg-primary">Banner chính (Carousel)</span>
                                            @else
                                                <span class="badge bg-info">Banner phụ (Dưới trang)</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái:</th>
                                        <td>
                                            @if($banner->status == 'active')
                                                <span class="badge bg-success">Hoạt động</span>
                                            @else
                                                <span class="badge bg-secondary">Không hoạt động</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Thứ tự hiển thị:</th>
                                        <td>{{ $banner->sort_order }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày tạo:</th>
                                        <td>{{ $banner->created_at->format('d/m/Y H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Cập nhật lần cuối:</th>
                                        <td>{{ $banner->updated_at->format('d/m/Y H:i:s') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <h5>Ảnh Banner</h5>
                                    @if($banner->image)
                                        <img src="{{ asset('storage/' . $banner->image) }}" 
                                             alt="{{ $banner->title }}" 
                                             class="img-fluid rounded" 
                                             style="max-width: 100%; max-height: 400px;">
                                        <div class="mt-2">
                                            <small class="text-muted">Đường dẫn: {{ $banner->image }}</small>
                                        </div>
                                    @else
                                        <div class="border rounded p-4 text-muted">
                                            <i class="fas fa-image fa-3x mb-3"></i>
                                            <p>Không có ảnh</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 