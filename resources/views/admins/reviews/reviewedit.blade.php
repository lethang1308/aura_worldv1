@extends('admins.layouts.default')

@section('content')
<div class="container-xxl mt-4">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Sửa đánh giá</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Sản phẩm</label>
                    <input type="text" class="form-control" value="{{ $review->product->name ?? 'N/A' }}" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Người dùng</label>
                    <input type="text" class="form-control" value="{{ $review->user->name ?? 'N/A' }}" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Số sao</label>
                    <select name="rating" class="form-select" required>
                        @for($i=1; $i<=5; $i++)
                            <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    @error('rating')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Bình luận</label>
                    <textarea name="comment" class="form-control" rows="4" required>{{ old('comment', $review->comment) }}</textarea>
                    @error('comment')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('admin.reviews.list') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection 