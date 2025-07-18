@extends('admins.layouts.default')

@section('content')
    <div class="wrapper">
        <div class="page-content">
            <div class="container-xxl">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="d-flex card-header justify-content-between align-items-center">
                                <h4 class="card-title">Attribute Value List</h4>
                                <div>
                                    @if (!isset($trash) || !$trash)
                                        <a href="{{ route('attributeValues.trash') }}" class="btn btn-outline-danger btn-sm">Thùng rác</a>
                                    @else
                                        <a href="{{ route('attributeValues.list') }}" class="btn btn-outline-primary btn-sm">Quay lại danh sách</a>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-centered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Value</th>
                                                <th>Attribute</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($attributeValues as $val)
                                                <tr>
                                                    <td>{{ $val->id }}</td>
                                                    <td>{{ $val->value }}</td>
                                                    <td>{{ $val->attribute->name ?? 'N/A' }}</td>
                                                    <td>{{ $val->created_at ? $val->created_at->format('d/m/Y H:i') : 'N/A' }}
                                                    </td>
                                                    <td>{{ $val->updated_at ? $val->updated_at->format('d/m/Y H:i') : 'N/A' }}
                                                    </td>
                                                    <td>
                                                        @if (!isset($trash) || !$trash)
                                                            <a href="{{ route('attributeValues.edit', $val->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                            <form action="{{ route('attributeValues.destroy', $val->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Xoá giá trị này?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-danger">Delete</button>
                                                            </form>
                                                        @else
                                                            <form action="{{ route('attributeValues.restore', $val->id) }}" method="POST" style="display:inline-block">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="btn btn-success btn-sm">Khôi phục</button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">
                                                        @if (isset($trash) && $trash)
                                                            Không có giá trị nào trong thùng rác.
                                                        @else
                                                            Không có giá trị nào.
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div> <!-- /.table-responsive -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
