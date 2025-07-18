@extends('admins.layouts.default')

@section('content')
    <div class="wrapper">
        <div class="page-content">
            <div class="container-xxl">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="d-flex card-header justify-content-between align-items-center">
                                <div>
                                    <h4 class="card-title">All Customers List</h4>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0 table-hover table-centered">
                                    <thead class="bg-light-subtle">
                                        <tr>
                                            <th style="width: 20px;">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="customCheckAll">
                                                </div>
                                            </th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($customers as $customer)
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="check{{ $customer->id }}">
                                                    </div>
                                                </td>
                                                <td>{{ $customer->name }}</td>
                                                <td>{{ $customer->email }}</td>
                                                <td>{{ $customer->phone ?? 'User để trống' }}</td>
                                                <td>{{ $customer->address ?? 'User để trống' }}</td>
                                                <td>
                                                    @if ($customer->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Deactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $customer->created_at ? $customer->created_at->format('d/m/Y H:i') : 'N/A' }}
                                                </td>
                                                <td>
                                                    {{ $customer->updated_at ? $customer->updated_at->format('d/m/Y H:i') : 'N/A' }}
                                                </td>

                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('customers.edit', $customer->id) }}"
                                                            class="btn btn-soft-primary btn-sm">
                                                            <iconify-icon icon="solar:pen-2-broken"
                                                                class="align-middle fs-18"></iconify-icon>
                                                        </a>
                                                        <form action="{{ route('customers.destroy', $customer->id) }}"
                                                            method="POST" onsubmit="return confirm('Are you sure?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-soft-danger btn-sm">
                                                                <iconify-icon icon="solar:trash-bin-minimalistic-2-broken"
                                                                    class="align-middle fs-18"></iconify-icon>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No customers found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-footer border-top">
                                <div class="d-flex justify-content-end">
                                    {{ $customers->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
