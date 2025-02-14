@extends('admin.main.app')
@section('admin-content')
@section('admin-title', 'Coupons')
@section('admin-css')
<link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table/css/vendors/datatables.css">
<link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table/css/vendors/datatable-extension.css">
<link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table.css">
@endsection

<!-- Start Container Fluid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h2>Coupons</h2>
                    <div class="d-flex justify-content-end align-items-end">
                        <a href="{{ route('coupon.create') }}">
                            <div class="btn btn-success">Add Coupon</div>
                        </a>
                    </div>
                    <div class="py-3">
                        <div class="dt-ext table-responsive custom-scrollbar">
                            <table class=" text-center"
                                id="export-button">
                                <thead class="theadColor">
                                    <tr class="text-uppercase text-center">
                                        <th>#</th>
                                        <th>Coupon Name</th>
                                        <th>Value</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($coupons as $key => $coupon)
                                    <tr data-id="{{ $coupon->id }}" class="text-center">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $coupon->coupon_code }}</td>
                                        <td>{{ $coupon->discount_value }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::createFromFormat('d-m-Y', $coupon->start_date)->format('j M Y') }}
                                            {{ 'to' }}
                                            {{ \Carbon\Carbon::createFromFormat('d-m-Y', $coupon->end_date)->format('j M Y') }}
                                        </td>
                                        <td>{!! $coupon->coupon_type == 1 ? '<span class="badge  bg-success text-light px-2 py-1 fs-13">Percentage</span>' : '<span class="badge bg-light text-dark  px-2 py-1 fs-13">Fixed</span>' !!}</td>
                                        <td>
                                            {!! $coupon->status == 0
                                            ? '<span class="badge border border-danger text-danger px-2 py-1 fs-13">In
                                                Active</span>'
                                            : '<span
                                                class="badge border border-success text-success px-2 py-1 fs-13">Active</span>'
                                            !!}
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-soft-danger btn-sm delete-btn">
                                                    <iconify-icon icon="solar:trash-bin-minimalistic-2-broken"
                                                        class="align-middle fs-18"></iconify-icon>
                                                </a>
                                                <a href="{{ route('coupon.edit', [$coupon->id]) }}"
                                                    class="btn btn-success btn-sm mx-2">
                                                    <iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18">
                                                    </iconify-icon>
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
    $(document).ready(function () {
        // Set CSRF token in AJAX headers
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Pass the route URL for deletion
        var deleteUrl = "{{ route('coupon.destroy', ['id' => ':id']) }}";

        // Handle delete button click
        $('.delete-btn').on('click', function () {
            var row = $(this).closest('tr');
            var id = row.data('id');
            var url = deleteUrl.replace(':id', id); // Correctly replace placeholder

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
                        success: function (response) {
                            Swal.fire("Deleted!", response.success, "success").then(
                                () => {
                                    row
                                        .remove(); // Remove the row from the table
                                });
                        },
                        error: function (response) {
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
    });

</script>
@endsection
