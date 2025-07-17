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
                                    <h4 class="card-title">All Customers List</h4>
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
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="customCheck7">
                                                        <label class="form-check-label" for="customCheck7">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td>Leonie Meister</td>
                                                <td><a href="javascript: void(0);" class="text-body">#INV9027</a> </td>
                                                <td>0123456789</td>
                                                <td>$1,367</td>
                                                <td> $3,651 </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="#!" class="btn btn-light btn-sm"><iconify-icon
                                                                icon="solar:eye-broken"
                                                                class="align-middle fs-18"></iconify-icon></a>
                                                        <a href="#!" class="btn btn-soft-primary btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#staticBackdrop"><iconify-icon
                                                                icon="solar:pen-2-broken"
                                                                class="align-middle fs-18"></iconify-icon></a>
                                                        <a href="#!" class="btn btn-soft-danger btn-sm"><iconify-icon
                                                                icon="solar:trash-bin-minimalistic-2-broken"
                                                                class="align-middle fs-18"></iconify-icon></a>
                                                    </div>
                                                </td>
                                            </tr>
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
    <!-- END Wrapper -->
@endsection
