@extends('admin.main.app')
@section('admin-title', 'Dashbaord')
@section('admin-content')
    <div class="container-fluid">

        <!-- Start here.... -->
        <div class="row">
            <div class="col-xxl-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <a href="{{ route('user.index') }}">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-md bg-soft-primary rounded">
                                                <iconify-icon icon="solar:cart-5-bold-duotone"
                                                    class="avatar-title fs-32 text-primary"></iconify-icon>
                                            </div>
                                        </div> <!-- end col -->
                                        <div class="col-6 text-end">
                                            <p class="text-muted mb-0 text-truncate">Our Customers</p>
                                            <h3 class="text-dark mt-1 mb-0">{{ $users }}</h3>
                                        </div> <!-- end col -->
                                    </div> <!-- end row-->
                                </a>
                            </div> <!-- end card body -->
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                    <div class="col-md-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <a href="{{ route('product.index') }}">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-md bg-soft-primary rounded">
                                                <iconify-icon icon="solar:cart-5-bold-duotone"
                                                    class="avatar-title fs-32 text-primary"></iconify-icon>
                                            </div>
                                        </div> <!-- end col -->
                                        <div class="col-6 text-end">
                                            <p class="text-muted mb-0 text-truncate">Total Products</p>
                                            <h3 class="text-dark mt-1 mb-0">{{ $products }}</h3>
                                        </div> <!-- end col -->
                                    </div> <!-- end row-->
                                </a>
                            </div> <!-- end card body -->
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                    <div class="col-md-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <a href="{{ route('brand.index') }}">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-md bg-soft-primary rounded">
                                                <iconify-icon icon="solar:cart-5-bold-duotone"
                                                    class="avatar-title fs-32 text-primary"></iconify-icon>
                                            </div>
                                        </div> <!-- end col -->
                                        <div class="col-6 text-end">
                                            <p class="text-muted mb-0 text-truncate">Brands</p>
                                            <h3 class="text-dark mt-1 mb-0">{{ $brands }}</h3>
                                        </div> <!-- end col -->
                                    </div> <!-- end row-->
                                </a>
                            </div> <!-- end card body -->
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                    <div class="col-md-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-md bg-soft-primary rounded">
                                            <iconify-icon icon="solar:cart-5-bold-duotone"
                                                class="avatar-title fs-32 text-primary"></iconify-icon>
                                        </div>
                                    </div> <!-- end col -->
                                    <div class="col-6 text-end">
                                        <p class="text-muted mb-0 text-truncate">Order Completed</p>
                                        <h3 class="text-dark mt-1 mb-0">1</h3>
                                    </div> <!-- end col -->
                                </div> <!-- end row-->
                            </div> <!-- end card body -->
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                    <div class="col-md-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-md bg-soft-primary rounded">
                                            <iconify-icon icon="solar:cart-5-bold-duotone"
                                                class="avatar-title fs-32 text-primary"></iconify-icon>
                                        </div>
                                    </div> <!-- end col -->
                                    <div class="col-6 text-end">
                                        <p class="text-muted mb-0 text-truncate">Order Ongoing</p>
                                        <h3 class="text-dark mt-1 mb-0">1</h3>
                                    </div> <!-- end col -->
                                </div> <!-- end row-->
                            </div> <!-- end card body -->
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                    <div class="col-md-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-md bg-soft-primary rounded">
                                            <iconify-icon icon="solar:cart-5-bold-duotone"
                                                class="avatar-title fs-32 text-primary"></iconify-icon>
                                        </div>
                                    </div> <!-- end col -->
                                    <div class="col-6 text-end">
                                        <p class="text-muted mb-0 text-truncate">Total Sales Till Now</p>
                                        <h3 class="text-dark mt-1 mb-0">1</h3>
                                    </div> <!-- end col -->
                                </div> <!-- end row-->
                            </div> <!-- end card body -->
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div> <!-- end col -->


        </div> <!-- end row -->


    </div>
@endsection
