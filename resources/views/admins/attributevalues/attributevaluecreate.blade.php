@extends('admins.layouts.default')

@section('content')
<div class="wrapper">
    <div class="page-content">
        <div class="container-xxl">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="d-flex card-header justify-content-between align-items-center">
                            <h4 class="card-title">Add Attribute Value</h4>
                            <a href="{{ route('attributeValues.list') }}" class="btn btn-outline-primary btn-sm">
                                Back to List
                            </a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('attributeValues.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Attribute</label>
                                    <select name="attribute_id" class="form-control" required>
                                        @foreach($attributes as $attr)
                                            <option value="{{ $attr->id }}">{{ $attr->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Value</label>
                                    <input type="text" name="value" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-success">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
