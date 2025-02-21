@extends('admin.main.app')
@section('admin-content')
@section('admin-title', 'Manual Orders')
@section('admin-css')
    <link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table/css/vendors/datatables.css">
    <link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table/css/vendors/datatable-extension.css">
    <link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+Y5q5n5hb5g1L0sibVcOQVnN0R6+G" crossorigin="anonymous"></script>

@endsection
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h2>Manual Orders</h2>
                    <div class="py-3">
                        <div class="dt-ext table-responsive custom-scrollbar">
                            <table class=" text-center" id="export-button">
                                <thead class="theadColor">
                                    <tr class="text-uppercase text-center">
                                        <th>#</th>
                                        <th>Order ID</th>
                                        <th>User Name</th>
                                        <th>Mobile</th>
                                        <th>Alternate Mobile</th>
                                        <th>Street Address</th>
                                        <th>Colony</th>
                                        <th>Pincode</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Product Screenshot</th>
                                        <th>Payment Screenshot</th>
                                        <th>Date</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $key => $order)
                                        <tr data-id="{{ $order->id }}" class="text-center" id="order-{{ $order->id }}">
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $order->order_id ?? '' }}</td>
                                            <td>{{ $order->name ?? '' }}</td>
                                            <td><span class="badge bg-success text-light px-2 py-1 fs-13">{{ $order->mobile }}</span></td>
                                            <td><span class="badge bg-secondary text-light px-2 py-1 fs-13">{{ $order->alternate_mobile }}</span></td>
                                            <td>{{ $order->street_address }}</td>
                                            <td>{{ $order->colony }}</td>
                                            <td>{{ $order->pincode }}</td>
                                            <td>{{ $order->city }}</td>
                                            <td>{{ $order->state }}</td>
                                            <td>
                                                @php
                                                    $productScreenshots = json_decode($order->product_screenshot, true);
                                                @endphp
                                                @if ($productScreenshots && is_array($productScreenshots))
                                                    <button class="btn btn-info btn-sm view-images"
                                                        data-images="{{ implode(',', array_map('url', $productScreenshots)) }}"
                                                        data-title="Product Images">View Product Images</button>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $paymentScreenshots = json_decode($order->payment_screenshot, true);
                                                @endphp
                                                @if ($paymentScreenshots && is_array($paymentScreenshots))
                                                    <button class="btn btn-info btn-sm view-images"
                                                        data-images="{{ implode(',', array_map('url', $paymentScreenshots)) }}"
                                                        data-title="Payment Images">View Payment Images</button>
                                                @endif
                                            </td>
                                            <td>{{ $order->date }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center ">
                                                    <a href="#" class="cancel-order" data-id="{{ $order->id }}">
                                                        <button class="btn btn-success btn-sm">Push To Shiprocket</button>
                                                    </a>
                                                    <a href="#" class="" data-id="{{ $order->id }}">
                                                        <button class="btn btn-success btn-sm">Push To Manual</button>
                                                    </a>
                                                    <a href="javascript:void(0)" class="btn btn-soft-danger btn-sm delete-btn mx-2">
                                                        <iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon>
                                                    </a>
                                                </div>
                                            </a>
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

<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Images</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner" id="carouselImages"></div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


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
    $(document).on('click', '.view-images', function () {
        const images = $(this).data('images').split(',');
        const title = $(this).data('title');

        // Update modal title
        $('#imageModalLabel').text(title);

        // Clear existing images in the carousel
        $('#carouselImages').empty();

        // Add images to the carousel
        images.forEach((image, index) => {
            $('#carouselImages').append(`
                <div class="carousel-item ${index === 0 ? 'active' : ''}">
                    <img src="${image}" class="d-block w-100" alt="${title}">
                </div>
            `);
        });

        // Show the modal
        $('#imageModal').modal('show');
    });
</script>


<script>
    $(document).on('click', '.cancel-order', function(e) {
        e.preventDefault();

        var orderId = $(this).data('id');

        // Show SweetAlert2 confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you really want to cancel this order?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No, keep it',
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to update the order status to canceled
                $.ajax({
                    url: '{{ route('order.updateCanceltatus', ':orderId') }}'.replace(
                        ':orderId', orderId),
                    method: 'PUT',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token
                    },
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            Swal.fire('Cancelled!', 'The order has been cancelled.',
                                'success');

                            // Update the order status in the table
                            $('#order-' + orderId + ' td:nth-child(5)').html(
                                '<span class="badge bg-danger text-light px-2 py-1 fs-13">Cancelled</span>'
                                );
                            window.location.href = '{{ route('CancelOrder') }}';
                        } else {
                            Swal.fire('Error!',
                                'Failed to cancel the order. Please try again.', 'error'
                                );
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Something went wrong. Please try again.',
                            'error');
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).on('click', '.cancel-order', function (e) {
        e.preventDefault();

        let orderId = $(this).data('id'); // Get the order ID

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to push this order to Shiprocket?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, push it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Perform AJAX request to push data to Shiprocket
                $.ajax({
                    url: '{{ route('maual-order-push-to-shiprocket') }}', // Define your Laravel route
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        order_id: orderId
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: 'Pushing...',
                            text: 'Please wait while we process the order.',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false
                        });
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload(); // Reload the page after confirmation
                            });
                        } else {
                            Swal.fire({
                                title: 'Failed!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong. Please try again later.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Set CSRF token in AJAX headers
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Pass the route URL for deletion
        var deleteUrl = "{{ route('manual.order.destroy', ['id' => ':id']) }}";

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
