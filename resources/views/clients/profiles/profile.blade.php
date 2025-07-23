@extends('clients.layouts.default')

@section('content')
<section class="profile_area section_gap">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-6">
                <h2 class="mb-4 text-center">User Profile</h2>

                {{-- Hiển thị thông báo --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                {{-- Form cập nhật --}}
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('client.profiles.update') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Name:</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                            </div>
                            <div class="form-group">
                                <label>Email:</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                            </div>
                            <div class="form-group">
                                <label>Phone:</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                            </div>
                            <div class="form-group">
                                <label>Address:</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
