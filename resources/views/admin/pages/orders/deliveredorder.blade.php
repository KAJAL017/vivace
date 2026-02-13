@extends('admin.main.app')
@section('admin-content')
@section('admin-title', 'Latest Orders')
@section('admin-css')
    <link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table/css/vendors/datatables.css">
    <link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table/css/vendors/datatable-extension.css">
    <link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table.css">
@endsection


<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h2>Delivered Orders</h2>
                    <div class="py-3">
                        <div class="dt-ext table-responsive custom-scrollbar">
                            <table class=" text-center" id="export-button">
                                <thead class="theadColor">
                                    <tr class="text-uppercase text-center">
                                        <th>#</th>
                                        <th>User Name</th>
                                        <th>Payment Method</th>
                                        <th>Payment ID</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $key => $order)
                                        <tr data-id="{{ $order->id }}" class="text-center">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ getUser($order->user_id)->name }}</td>
                                            <td>
                                                @if($order->payment_method == 'Online')
                                                    <span class="badge bg-success text-light px-2 py-1 fs-13">Online</span>
                                                @else
                                                    <span class="badge bg-warning text-light px-2 py-1 fs-13">COD</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($order->payment_id)
                                                    <span class="text-muted small">{{ $order->payment_id }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>₹{{ number_format($order->total_amount, 2) }}</td>
                                            <td><span
                                                    class="badge  bg-secondary text-light px-2 py-1 fs-13">Delivered</span>
                                            </td>
                                            <td>{{ $order->date }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <a href="{{ route('order.view', [$order->custom_order_id]) }}">
                                                       <button class="btn btn-secondary btn-sm">View</button>
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
    $(document).ready(function() {
        // Set CSRF token in AJAX headers
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Pass the route URL for deletion
        var deleteUrl = "{{ route('coupon.destroy', ['id' => ':id']) }}";

        // Handle delete button click
        $('.delete-btn').on('click', function() {
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
                        success: function(response) {
                            Swal.fire("Deleted!", response.success, "success").then(
                                () => {
                                    row
                                        .remove(); // Remove the row from the table
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
    });
</script>
@endsection
