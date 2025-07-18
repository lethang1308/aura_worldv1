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
                            <a href="{{ route('attributeValues.create') }}" class="btn btn-sm btn-primary">
                                + Add Value
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-centered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Value</th>
                                            <th>Attribute</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($attributeValues as $val)
                                            <tr>
                                                <td>{{ $val->id }}</td>
                                                <td>{{ $val->value }}</td>
                                                <td>{{ $val->attribute->name ?? 'N/A' }}</td>
                                                <td>
                                                    <a href="{{ route('attributeValues.edit', $val->id) }}"
                                                       class="btn btn-sm btn-warning">Edit</a>
                                                    <form action="{{ route('attributeValues.destroy', $val->id) }}"
                                                          method="POST" style="display:inline-block"
                                                          onsubmit="return confirm('Xoá giá trị này?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
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
