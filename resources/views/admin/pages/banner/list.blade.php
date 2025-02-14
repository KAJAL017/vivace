@extends('admin.main.app')
@section('admin-content')
@section('admin-title', 'Banners')
@section('admin-css')
    <link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table/css/vendors/datatables.css">
    <link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table/css/vendors/datatable-extension.css">
    <link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table.css">
@endsection

<!-- Start Container Fluid -->
@section('admin-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h2>Banners</h2>
                        <div class="d-flex justify-content-end align-items-end">
                            <a href="{{ route('banner.create') }}">
                                <div class="btn btn-success">Add banner</div>
                            </a>
                        </div>
                        <div class="py-3">
                            <div class="dt-ext table-responsive custom-scrollbar">
                                @foreach ($banners as $key => $banner)
                                <div class="row banner-row" data-id="{{ $banner->id }}">
                                    <div class="col-12 text-center">
                                        <img src="{{ url('public/uploads') }}/{{ $banner->banner }}" alt="" width="100%">
                                        <div class="d-flex justify-content-center align-items-center m-5">
                                            <a href="javascript:void(0)" class="btn btn-soft-danger btn-sm delete-btn">
                                                <iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon>
                                            </a>
                                            <a href="{{ route('banner.edit', [$banner->id]) }}" class="btn btn-success btn-sm mx-2">
                                                <iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach



                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
@endsection
<!-- End Container Fluid -->
@endsection

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
    $(document).ready(function() {
        // Set CSRF token in AJAX headers
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Pass the route URL for deletion
        var deleteUrl = "{{ route('banner.destroy', ['id' => ':id']) }}";

        // Handle delete button click using event delegation
        $(document).on('click', '.delete-btn', function() {
            var row = $(this).closest('.banner-row'); // Get the closest banner-row
            var id = row.data('id'); // Fetch the data-id value
            var url = deleteUrl.replace(':id', id); // Replace placeholder with actual id

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
                            Swal.fire("Deleted!", response.success, "success").then(() => {
                                row.remove(); // Dynamically remove the banner-row from the DOM
                            });
                        },
                        error: function(response) {
                            Swal.fire("Error", "An error occurred while deleting the record.", "error");
                        }
                    });
                } else {
                    Swal.fire("Your record is safe!");
                }
            });
        });
    });
</script>


@endsection
