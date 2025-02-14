@extends('admin.main.app')
@section('admin-content')
@section('admin-title', 'Cancel Orders')
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
                    <h2>Cancel Orders</h2>
                    <div class="py-3">
                        <div class="dt-ext table-responsive custom-scrollbar">
                            <table class=" text-center" id="export-button">
                                <thead class="theadColor">
                                    <tr class="text-uppercase text-center">
                                        <th>#</th>
                                        <th>User Name</th>
                                        <th>Payment Method</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $key => $order)
                                    <tr data-id="{{ $order->id }}" class="text-center" id="order-{{ $order->id }}">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ getUser($order->user_id)->name ?? ''}}</td>
                                        <td>
                                            <span class="badge bg-success text-light px-2 py-1 fs-13">{{ $order->payment_method }}</span>
                                        </td>
                                        <td>₹{{ number_format($order->total_amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-secondary text-light px-2 py-1 fs-13">Cancel</span>
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
    var updateOrderStatusUrl = "{{ route('order.updateStatus', ':orderId') }}";
</script>

<script>
    $(document).on('click', '.mark-delivered', function(e) {
    e.preventDefault();

    var orderId = $(this).data('id');
    var url = updateOrderStatusUrl.replace(':orderId', orderId); // Replace the :orderId placeholder with actual orderId

    // Show SweetAlert2 confirmation dialog
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you really want to mark this order as delivered?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, mark as delivered!',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            // Send AJAX request to update the order status
            $.ajax({
                url: url,  // Use the dynamic URL
                method: 'PUT',  // Assuming you're using PUT for updating
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),  // CSRF token
                    status: 'delivered'  // New order status
                },
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        Swal.fire('Delivered!', 'The order has been marked as delivered.', 'success');

                        // Update the order status in the table
                        $('#order-' + orderId + ' td:nth-child(5)').html('<span class="badge bg-success text-light px-2 py-1 fs-13">Delivered</span>');
                        window.location.href = '{{ route('DeliveredOrder') }}';
                    } else {
                        Swal.fire('Error!', 'Failed to mark the order as delivered. Please try again.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error!', 'Something went wrong. Please try again.', 'error');
                }
            });
        }
    });
});

</script>

@endsection
