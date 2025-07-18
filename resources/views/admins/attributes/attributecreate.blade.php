@extends('admins.layouts.default')

@section('content')
    <div class="wrapper">
        <div class="page-content">
            <div class="container-xxl">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="d-flex card-header justify-content-between align-items-center">
                                <h4 class="card-title">Create New Attribute</h4>
                                <a href="{{ route('attributes.index') }}" class="btn btn-outline-primary btn-sm">
                                    Back to List
                                </a>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('attributes.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <!-- Attribute Name -->
                                        <div class="col-md-6 mb-3">
                                            <label for="attribute-name" class="form-label text-dark">Attribute Name</label>
                                            <input type="text" name="name" id="attribute-name" class="form-control"
                                                placeholder="Enter attribute name" required>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary">Save Attribute</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
