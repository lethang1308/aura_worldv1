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
                            <div class="d-flex card-header justify-content-between align-items-center">
                                <div>
                                    <h4 class="card-title">All Attribute List</h4>
                                </div>
                                <div>
                                    @if (!isset($trash) || !$trash)
                                        <a href="{{ route('attributes.trash') }}" class="btn btn-outline-danger btn-sm">Thùng rác</a>
                                    @else
                                        <a href="{{ route('attributes.index') }}" class="btn btn-outline-primary btn-sm">Quay lại danh sách</a>
                                    @endif
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
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Value</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($attributes as $attribute)
                                                <tr>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="check-{{ $attribute->id }}">
                                                            <label class="form-check-label"
                                                                for="check-{{ $attribute->id }}">&nbsp;</label>
                                                        </div>
                                                    </td>
                                                    <td>{{ $attribute->id }}</td>
                                                    <td>{{ $attribute->name }}</td>
                                                    <td>
                                                        @if ($attribute->attributeValues->count())
                                                            @foreach ($attribute->attributeValues as $value)
                                                                <span class="badge bg-primary">{{ $value->value }}</span>
                                                            @endforeach
                                                        @else
                                                            <span class="text-muted">Chưa có giá trị</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $attribute->created_at ? $attribute->created_at->format('d/m/Y H:i') : 'N/A' }}
                                                    </td>
                                                    <td>
                                                        {{ $attribute->updated_at ? $attribute->updated_at->format('d/m/Y H:i') : 'N/A' }}
                                                    </td>

                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            @if (!isset($trash) || !$trash)
                                                                <a href="{{ route('attributes.edit', $attribute->id) }}"
                                                                    class="btn btn-soft-primary btn-sm">
                                                                    <iconify-icon icon="solar:pen-2-broken"
                                                                        class="align-middle fs-18"></iconify-icon>
                                                                </a>
                                                                <form action="{{ route('attributes.destroy', $attribute->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Xoá thuộc tính này?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-soft-danger btn-sm">
                                                                        <iconify-icon
                                                                            icon="solar:trash-bin-minimalistic-2-broken"
                                                                            class="align-middle fs-18"></iconify-icon>
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <form action="{{ route('attributes.restore', $attribute->id) }}" method="POST" style="display:inline-block">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit" class="btn btn-success btn-sm">Khôi phục</button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">
                                                        @if (isset($trash) && $trash)
                                                            Không có thuộc tính nào trong thùng rác.
                                                        @else
                                                            Không có thuộc tính nào.
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforelse
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
                                        <li class="page-item"><a class="page-link" href="javascript:void(0);">Next</a></li>
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
