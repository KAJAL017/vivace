@extends('admin.main.app')
@section('admin-content')
@section('admin-title', 'Products')
@section('admin-css')
    <link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table/css/vendors/js/datatables.css">
    <link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table/css/vendors/js/datatable-extension.css">
    <link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table.css">
@endsection

<!-- Start Container Fluid -->
@section('admin-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4>All Product List</h4>
                        <div class="d-flex justify-content-end align-items-end">
                            <a href="{{ route('product.create') }}">
                                <div class="btn btn-success">Add Product</div>
                            </a>
                        </div>
                        <div class="py-3">
                            <div class="dt-ext table-responsive custom-scrollbar">
                                <table class="text-center" id="export-button">
                                    <thead class="theadColor">
                                        <tr class="text-uppercase text-center">
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th>Collections</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $key => $product)
                                            <tr data-id="{{ $product->id }}" class="text-center">
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div
                                                            class=" bg-light avatar-md d-flex align-items-center justify-content-center">
                                                            <img src="{{ url('public/') }}/{{ Product_first_image($product->id) }}"
                                                                alt="" class="avatar-md">
                                                        </div>
                                                        <div>
                                                            <a href="#!"
                                                                class="text-dark fw-medium fs-15">{{ $product->name }}</a>
                                                        </div>
                                                    </div>

                                                </td>
                                                <td>{{ $product->categoryname }}</td>
                                                <td>{{ $product->brandname }}</td>
                                                <td>{{ $product->collectionName }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <a href="javascript:void(0)"
                                                            class=" rounded delete-btn">
                                                            <button class="btn btn-danger  btn-sm">Delete</button>
                                                        </a>
                                                        <a href="{{ route('product.edit', [$product->id]) }}"
                                                            class="mx-2">
                                                            <button class="btn btn-success btn-sm">Edit</button>
                                                        </a>
                                                        <a href="{{ route('product.copy', [$product->id]) }}"
                                                            class="mx-2">
                                                            <button class="btn btn-secondary btn-sm">Copy</button>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
@endsection
<!-- End Container Fluid -->


@section('admin-js')
    <script src="{{ admin_assets() }}/table/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ admin_assets() }}/table/js/datatable/datatable-extension/dataTables.buttons.min.js"></script>
    <script src="{{ admin_assets() }}/table/js/datatable/datatable-extension/jszip.min.js"></script>
    <script src="{{ admin_assets() }}/table/js/datatable/datatable-extension/buttons.colVis.min.js"></script>
    <script src="{{ admin_assets() }}/table/js/datatable/datatable-extension/pdfmake.min.js"></script>
    <script src="{{ admin_assets() }}/table/js/datatable/datatable-extension/vfs_fonts.js"></script>
    <script src="{{ admin_assets() }}/table/js/datatable/datatable-extension/dataTables.autoFill.min.js"></script>
    <script src="{{ admin_assets() }}/table/js/datatable/datatable-extension/dataTables.select.min.js"></script>
    <script src="{{ admin_assets() }}/table/js/datatable/datatable-extension/buttons.bootstrap5.min.js"></script>
    <script src="{{ admin_assets() }}/table/js/datatable/datatable-extension/buttons.html5.min.js"></script>
    <script src="{{ admin_assets() }}/table/js/datatable/datatable-extension/buttons.print.min.js"></script>
    <script src="{{ admin_assets() }}/table/js/datatable/datatable-extension/dataTables.bootstrap5.min.js"></script>
    <script src="{{ admin_assets() }}/table/js/datatable/datatable-extension/dataTables.responsive.min.js"></script>
    <script src="{{ admin_assets() }}/table/js/datatable/datatable-extension/responsive.bootstrap5.min.js"></script>
    <script src="{{ admin_assets() }}/table/js/datatable/datatable-extension/dataTables.keyTable.min.js"></script>
    <script src="{{ admin_assets() }}/table/js/datatable/datatable-extension/dataTables.colReorder.min.js"></script>
    <script src="{{ admin_assets() }}/table/js/datatable/datatable-extension/dataTables.fixedHeader.min.js"></script>
    <script src="{{ admin_assets() }}/table/js/datatable/datatable-extension/dataTables.rowReorder.min.js"></script>
    <script src="{{ admin_assets() }}/table/js/datatable/datatable-extension/dataTables.scroller.min.js"></script>
    <script src="{{ admin_assets() }}/table/js/datatable/datatable-extension/custom.js"></script>



    <script>
        var deleteUrl = "{{ route('product.destroy', ['id' => ':id']) }}";
            $('.delete-btn').on('click', function() {
                var row = $(this).closest('tr');
                var id = row.data('id');
                var url = deleteUrl.replace(':id', id);

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to recover this record!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'DELETE',
                            success: function(response) {
                                Swal.fire("Deleted!", response.success, "success").then(
                                    () => {
                                        row
                                            .remove();
                                    });
                            },
                            error: function(response) {
                                Swal.fire("Error",
                                    "An error occurred while deleting the record.",
                                    "error");
                            }
                        });
                    } else {
                        Swal.fire("Your record is safe!");
                    }
                });
            });
    </script>
@endsection
