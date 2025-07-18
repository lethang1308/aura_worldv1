@extends('admins.layouts.default')

@section('content')
    <!-- START Wrapper -->
    <div class="wrapper">

        <!-- ==================================================== -->
        <!-- Start right Content here -->
        <!-- ==================================================== -->
        <div class="page-content">

            <!-- Start Container Fluid -->
            <div class="container-xxl">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center gap-1">
                                <h4 class="card-title flex-grow-1">All Categories List</h4>

                                <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">
                                    Add Category
                                </a>

                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle btn btn-sm btn-outline-light"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        This Month
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <!-- item-->
                                        <a href="#!" class="dropdown-item">Download</a>
                                        <!-- item-->
                                        <a href="#!" class="dropdown-item">Export</a>
                                        <!-- item-->
                                        <a href="#!" class="dropdown-item">Import</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0 table-hover table-centered">
                                        <thead class="bg-light-subtle">
                                            <tr>
                                                <th style="width: 20px;">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="customCheck1">
                                                        <label class="form-check-label" for="customCheck1"></label>
                                                    </div>
                                                </th>
                                                <th>Categories</th>
                                                <th>ID</th>
                                                <th>Parent Category</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($categories as $category)
                                                <tr>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="customCheck2">
                                                            <label class="form-check-label" for="customCheck2"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <p class="text-dark fw-medium fs-15 mb-0">
                                                                {{ $category->category_name }}</p>
                                                        </div>

                                                    </td>
                                                    <td>{{ $category->id }}</td>
                                                    <td>
                                                        @if ($category->parent_category_id === null)
                                                            <span class="text-primary fw-bold">Danh mục cha</span>
                                                        @elseif ($category->parentCategory)
                                                            <span class="text-success fw-semibold">
                                                                {{ $category->parentCategory->category_name }}
                                                            </span>
                                                        @else
                                                            <span class="text-muted">Chưa xác định</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <p class="text-dark fw-medium fs-15 mb-0">
                                                            {{ isset($category->description) && !empty($category->description) ? $category->description : 'Chưa có mô tả' }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        @if ($category->status === '1')
                                                            <span class="badge bg-success">Đang hoạt động</span>
                                                        @elseif($category->status === '0')
                                                            <span class="badge bg-danger">Ngừng hoạt động</span>
                                                        @else
                                                            <span class="badge bg-secondary">Không xác định</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $category->created_at ? $category->created_at->format('d/m/Y H:i') : 'N/A' }}
                                                    </td>
                                                    <td>
                                                        {{ $category->updated_at ? $category->updated_at->format('d/m/Y H:i') : 'N/A' }}
                                                    </td>

                                                    <td>
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <!-- Nút Sửa -->
                                                            <a href="{{ route('categories.edit', $category->id) }}"
                                                                class="btn btn-soft-primary btn-sm d-inline-flex align-items-center justify-content-center px-2 py-1 mb-2"
                                                                style="height: 32px; width: 32px;">
                                                                <iconify-icon icon="solar:pen-2-broken"
                                                                    class="align-middle fs-18"></iconify-icon>
                                                            </a>

                                                            <!-- Nút Xoá -->
                                                            <form action="{{ route('categories.destroy', $category->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Bạn có chắc muốn xoá danh mục này không?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-soft-danger btn-sm d-inline-flex align-items-center justify-content-center px-2 py-1"
                                                                    style="height: 32px; width: 32px;">
                                                                    <iconify-icon
                                                                        icon="solar:trash-bin-minimalistic-2-broken"
                                                                        class="align-middle fs-18"></iconify-icon>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                            <div class="card-footer border-top">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-end mb-0">
                                        <li class="page-item"><a class="page-link" href="javascript:void(0);">Previous</a>
                                        </li>
                                        <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void(0);">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Container Fluid -->
        </div>
        <!-- ==================================================== -->
        <!-- End Page Content -->
        <!-- ==================================================== -->


    </div>
@endsection
