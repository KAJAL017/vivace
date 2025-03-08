@extends('admin.main.app')
@section('admin-content')
@section('admin-title', 'Manual Orders')
@section('admin-css')
    <link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table/css/vendors/datatables.css">
    <link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table/css/vendors/datatable-extension.css">
    <link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+Y5q5n5hb5g1L0sibVcOQVnN0R6+G" crossorigin="anonymous">
    </script>

@endsection
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h2>Shipped Orders</h2>
                    <div class="py-3">
                        <div class="dt-ext table-responsive custom-scrollbar">
                            <table class=" text-center" id="export-button">
                                <thead class="theadColor">
                                    <tr class="text-uppercase text-center">
                                        <th>#</th>
                                        <th>Order ID</th>
                                        <th>User Name</th>
                                        <th>Mobile</th>
                                        <th>Product Screenshot</th>
                                        <th>Payment Screenshot</th>
                                        <th>Date</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $key => $order)
                                        <tr data-id="{{ $order->id }}" class="text-center"
                                            id="order-{{ $order->id }}">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $order->order_id ?? '' }}</td>
                                            <td>{{ $order->name ?? '' }}</td>
                                            <td><span
                                                    class="badge bg-success text-light px-2 py-1 fs-13">{{ $order->mobile }}</span>
                                            </td>
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
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-success btn-sm shipped-btn"
                                                        data-id="{{ $order->id }}">
                                                        Update Tracking Details
                                                    </a>
                                                    @if (!empty($order->tracking_id))
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-primary mx-2 btn-sm view-tracking-btn"
                                                        data-id="{{ $order->id }}">
                                                        View
                                                    </a>
                                                @endif



                                                    <a href="javascript:void(0)"
                                                        class="btn btn-soft-danger btn-sm delete-btn mx-2">
                                                        Delete
                                                    </a>
                                                    <button class="btn btn-primary btn-sm view-address-btn"
                                                    data-name="{{ $order->name }}"
                                                    data-mobile="{{ $order->mobile }}"
                                                    data-alt-mobile="{{ $order->alternate_mobile }}"
                                                    data-street="{{ $order->street_address }}"
                                                    data-colony="{{ $order->colony }}"
                                                    data-pincode="{{ $order->pincode }}"
                                                    data-city="{{ $order->city }}"
                                                    data-state="{{ $order->state }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#addressModal">
                                                    View Address
                                                </button>
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
                    <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addressModalLabel">Order Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="modalName"></span></p>
                <p><strong>Mobile:</strong> <span id="modalMobile"></span></p>
                <p><strong>Alternate Mobile:</strong> <span id="modalAltMobile"></span></p>
                <p><strong>Street Address:</strong> <span id="modalStreet"></span></p>
                <p><strong>Colony:</strong> <span id="modalColony"></span></p>
                <p><strong>Pincode:</strong> <span id="modalPincode"></span></p>
                <p><strong>City:</strong> <span id="modalCity"></span></p>
                <p><strong>State:</strong> <span id="modalState"></span></p>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="trackingModal" tabindex="-1" aria-labelledby="trackingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="trackingModalLabel">Enter Tracking Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="trackingForm">
                    <input type="hidden" id="order_id">

                    <div class="mb-3">
                        <label for="tracking_id" class="form-label">Tracking ID</label>
                        <input type="text" class="form-control" id="tracking_id" placeholder="Enter Tracking ID" required>
                    </div>

                    <div class="mb-3">
                        <label for="tracking_link" class="form-label">Paste Tracking Link</label>
                        <input type="text" class="form-control" id="tracking_link"  placeholder="Enter Tracking Link" required>
                    </div>

                    <div class="mb-3">
                        <label for="tracking_slip" class="form-label">Upload Tracking Slip (Optional)</label>
                        <input type="file" class="form-control" id="tracking_slip">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="trackingDetailsModal" tabindex="-1" aria-labelledby="trackingDetailsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="trackingDetailsModalLabel">Tracking Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <style>
                /* Modal Content */
                #trackingModal .modal-content {
                    border-radius: 12px;
                    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
                    border: none;
                }

                /* Table Styling */
                #trackingModal .table {
                    border-radius: 8px;
                    overflow: hidden;
                    background: #fff;
                }

                /* Table Headers */
                #trackingModal .table th {
                    background: linear-gradient(to right, #4CAF50, #388E3C);
                    color: #000;
                    font-size: 14px;
                    padding: 12px;
                    text-align: left;
                    font-weight: bold;
                }

                /* Table Data */
                #trackingModal .table td {
                    padding: 12px;
                    font-size: 14px;
                    color: #333;
                    border: 1px solid #ddd;
                }

                /* Tracking Link */
                #modal_tracking_link {
                    color: #007bff;
                    font-weight: bold;
                    text-decoration: none;
                    transition: 0.3s;
                }

                #modal_tracking_link:hover {
                    color: #0056b3;
                    text-decoration: underline;
                }

                /* Tracking Slip Styling */
                #modal_tracking_slip img {
                    width: 100px;
                    height: auto;
                    border-radius: 8px;
                    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
                }
            </style>

            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="color: black">Tracking ID</th>
                        <td id="modal_tracking_id"></td>
                    </tr>
                    <tr>
                        <th style="color: black">Tracking Link</th>
                        <td><a href="#" id="modal_tracking_link" target="_blank"></a></td>
                    </tr>
                    <tr>
                        <th style="color: black">Tracking Slip</th>
                        <td id="modal_tracking_slip"></td>
                    </tr>
                </table>
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
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".view-address-btn").forEach((button) => {
        button.addEventListener("click", function () {
            document.getElementById("modalName").innerText = this.getAttribute("data-name");
            document.getElementById("modalMobile").innerText = this.getAttribute("data-mobile");
            document.getElementById("modalAltMobile").innerText = this.getAttribute("data-alt-mobile");
            document.getElementById("modalStreet").innerText = this.getAttribute("data-street");
            document.getElementById("modalColony").innerText = this.getAttribute("data-colony");
            document.getElementById("modalPincode").innerText = this.getAttribute("data-pincode");
            document.getElementById("modalCity").innerText = this.getAttribute("data-city");
            document.getElementById("modalState").innerText = this.getAttribute("data-state");
        });
    });
});

</script>

<script>
    $(document).ready(function() {
        $(".shipped-btn").on("click", function() {
            let orderId = $(this).data("id");
            $("#order_id").val(orderId);
            $("#trackingModal").modal("show");
        });

        $("#trackingForm").on("submit", function(e) {
            e.preventDefault();
            $(".error-message").remove(); // पुरानी errors remove करें

            let formData = new FormData();
            formData.append("order_id", $("#order_id").val());
            formData.append("tracking_id", $("#tracking_id").val());
            formData.append("tracking_link", $("#tracking_link").val());
            formData.append("tracking_slip", $("#tracking_slip")[0].files[0]);

            $.ajax({
                url: "{{ route('order.tracking.store') }}",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $("#trackingModal").modal("hide");
                    toastr.success(response.success);
                    $("#trackingForm")[0].reset();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            $("#" + field).after(
                                '<span class="text-danger error-message">' +
                                messages[0] + '</span>');
                        });
                    } else {
                        toastr.error("Something went wrong!");
                    }
                }
            });
        });
    });
</script>
<script>
$(document).ready(function() {
    $(document).on("click", ".shipped-btn", function() {
        let orderId = $(this).data("id");
        $("#order_id").val(orderId);
        $("#trackingModal").modal("show");
    });

    $(document).on("click", ".view-tracking-btn", function() {
        let orderId = $(this).data("id");

        $.ajax({
            url: "{{ route('order.tracking.view') }}",
            type: "GET",
            data: { order_id: orderId },
            success: function(response) {
                if (response.success) {
                    $("#modal_tracking_id").text(response.data.tracking_id);
                    $("#modal_tracking_link").attr("href", response.data.tracking_link)
                        .text(response.data.tracking_link);

                    if (response.data.tracking_slip) {
                        $("#modal_tracking_slip").html(
                            `<a href="${response.data.tracking_slip}" target="_blank" class="btn btn-success btn-sm">View Slip</a>`
                        );
                    } else {
                        $("#modal_tracking_slip").text("Not Available");
                    }

                    $("#trackingDetailsModal").modal("show");
                } else {
                    toastr.error("Tracking details not found!");
                }
            },
            error: function() {
                toastr.error("Something went wrong!");
            }
        });
    });
});

</script>

<script>
    $(document).on('click', '.view-images', function() {
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
    $(document).on('click', '.cancel-order', function(e) {
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
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Pushing...',
                            text: 'Please wait while we process the order.',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false
                        });
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location
                                    .reload(); // Reload the page after confirmation
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
                    error: function() {
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
