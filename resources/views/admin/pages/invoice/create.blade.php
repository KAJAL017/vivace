@extends('admin.main.app')
@section('admin-content')
@section('admin-title', 'Create Coupon')


<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <form id="invoice-form" action="" method="post">
                    <div class="card-body">
                        <!-- Logo & title -->
                        <div class="pb-3 mb-4 position-relative border-bottom">
                            <div class="row justify-content-between">
                                <div class="col-lg-5">
                                    <div class="w-50 auth-logo border border-primary bg-light-subtle p-2 rounded"
                                        style="border-style: dashed !important;">
                                        <div class="profile-photo-edit">
                                            <input id="profile-img-file-input" type="file"
                                                class="profile-img-file-input">
                                            <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                <img src=""
                                                    class="logo-dark me-1 user-profile-image" alt="user-profile-image"
                                                    height="24">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="mb-3">
                                        <label for="invoice-no" class="form-label text-dark">Invoice Number :</label>
                                        <input type="text" id="invoice-no" class="form-control"
                                            placeholder="#INV-****" value="#INV-0758267/90">
                                    </div>
                                    <div class="mb-3">
                                        <label for="schedule-date" class="form-label text-dark">Issue Date :</label>
                                        <input type="text" id="schedule-date"
                                            class="form-control flatpickr-input active" placeholder="dd-mm-yyyy"
                                            readonly="readonly">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-between">
                            <div class="col-lg-5">
                                <h4 class="mb-3">Issue From :</h4>
                                <div class="mb-2">
                                    <input type="text" id="buyer-from" class="form-control" placeholder="First name">
                                </div>
                                <div class="mb-2">
                                    <textarea class="form-control" id="buyer-address" rows="3" placeholder="Enter address"></textarea>
                                </div>
                                <div class="mb-2">
                                    <input type="number" id="buyer-number" class="form-control" placeholder="Number">
                                </div>
                                <div class="mb-2">
                                    <input type="email" id="buyer-email" class="form-control"
                                        placeholder="Email Address">
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <h4 class="mb-3">Issue For :</h4>
                                <div class="mb-2">
                                    <input type="text" id="issuer-from" class="form-control"
                                        placeholder="First name">
                                </div>
                                <div class="mb-2">
                                    <textarea class="form-control" id="issuer-address" rows="3" placeholder="Enter address"></textarea>
                                </div>
                                <div class="mb-2">
                                    <input type="number" id="issuer-number" class="form-control" placeholder="Number">
                                </div>
                                <div class="mb-2">
                                    <input type="email" id="issuer-email" class="form-control"
                                        placeholder="Email Address">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="table-responsive table-borderless text-nowrap table-centered">
                                    <table class="table mb-0">
                                        <thead class="bg-dark bg-opacity-100">
                                            <tr>
                                                <th class="border-0 py-2">Product Name</th>
                                                <th class="border-0 py-2">Quantity</th>
                                                <th class="border-0 py-2">Price</th>
                                                <th class="border-0 py-2">Total</th>
                                                <th class="border-0 py-2">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="product-table-body">
                                            <tr>
                                                <td>
                                                    <div class="d-flex gap-3">
                                                        <div class="w-75">
                                                            <input type="text" class="form-control product-name"
                                                                placeholder="Product Name">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="quantity">
                                                        <div
                                                            class="input-step border bg-body-secondary p-1 rounded d-inline-flex overflow-visible">
                                                            <button type="button"
                                                                class="minus bg-light text-dark border-0 rounded-1 fs-20 lh-1 h-100">-</button>
                                                            <input type="number"
                                                                class="quantity-input text-dark text-center border-0 bg-body-secondary rounded h-100"
                                                                value="1" min="0" max="100">
                                                            <button type="button"
                                                                class="plus bg-light text-dark border-0 rounded-1 fs-20 lh-1 h-100">+</button>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <span class="input-group-text fs-20 bg-light text-dark"><i
                                                                class="bx bx-rupee"></i></span>
                                                        <input type="number" class="product-price form-control"
                                                            placeholder="000">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <span class="input-group-text fs-20 bg-light text-dark"><i
                                                                class="bx bx-rupee"></i></span>
                                                        <input type="number" class="product-total form-control"
                                                            placeholder="000" readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-danger remove-row">Remove</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table> <!-- end table -->
                                </div> <!-- end table responsive -->
                                <div class="text-end border-top">
                                    <div class="pt-3">
                                        <button id="add-more" type="button" class="btn btn-outline-primary">Add
                                            More</button>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-lg-4">
                                <label for="sub-total" class="form-label text-dark">Sub Total :</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text fs-20 bg-light text-dark"><i
                                            class="bx bx-rupee"></i></span>
                                    <input type="number" id="sub-total" class="form-control" placeholder="000"
                                        readonly>
                                </div>
                                <label for="discount-price" class="form-label text-dark">Discount :</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text fs-20 bg-light text-dark"><i
                                            class="bx bx-rupee"></i></span>
                                    <input type="number" id="discount-price" class="form-control"
                                        placeholder="000">
                                </div>
                                <label for="estimated-tax" class="form-label text-dark">Tax :</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text fs-20 bg-light text-dark"><i
                                            class="bx bx-rupee"></i></span>
                                    <input type="number" class="product-tax-percentage form-control"
                                        placeholder="Tax %" min="0" max="100">
                                </div>
                                <div class="border-top">
                                    <label for="grand-total" class="form-label text-dark pt-3">Grand Amount :</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text fs-20 bg-light text-dark"><i
                                                class="bx bx-rupee"></i></span>
                                        <input type="number" id="grand-total" class="form-control"
                                            placeholder="000" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary">Submit Invoice</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



</div>
@endsection
@section('admin-js')
<script src="{{ admin_assets() }}/assets/js/pages/invoice-add.js"></script>
<script>
    $(document).ready(function() {
        $('#add-more').click(function() {
            var newRow = `
            <tr>
                <td>
                    <div class="d-flex gap-3">
                        <div class="w-75">
                            <input type="text" class="form-control product-name" placeholder="Product Name">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="quantity">
                        <div class="input-step border bg-body-secondary p-1 rounded d-inline-flex overflow-visible">
                            <button type="button" class="minus bg-light text-dark border-0 rounded-1 fs-20 lh-1 h-100">-</button>
                            <input type="number" class="quantity-input text-dark text-center border-0 bg-body-secondary rounded h-100" value="1" min="0" max="100">
                            <button type="button" class="plus bg-light text-dark border-0 rounded-1 fs-20 lh-1 h-100">+</button>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <span class="input-group-text fs-20 bg-light text-dark"><i class="bx bx-rupee"></i></span>
                        <input type="number" class="product-price form-control" placeholder="000" min="0">
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <span class="input-group-text fs-20 bg-light text-dark"><i class="bx bx-rupee"></i></span>
                        <input type="number" class="product-total form-control" placeholder="000" readonly>
                    </div>
                </td>
                <td>
                    <button type="button" class="btn btn-danger remove-row">Remove</button>
                </td>
            </tr>`;
            $('#product-table-body').append(newRow);
        });

        // Handle input change to calculate totals
        $(document).on('input', '.quantity-input, .product-price', function() {
            var $row = $(this).closest('tr');
            var quantity = parseFloat($row.find('.quantity-input').val()) || 0;
            var price = parseFloat($row.find('.product-price').val()) || 0;
            var total = quantity * price;
            $row.find('.product-total').val(total.toFixed(2)); // Set total with two decimals

            calculateTotals();
        });

        // Event handler for increment and decrement buttons
        $(document).on('click', '.plus', function() {
            var $input = $(this).siblings('.quantity-input');
            var currentVal = parseInt($input.val());
            if (!isNaN(currentVal)) {
                $input.val(currentVal + 1).trigger('input'); // Update input and trigger calculation
            }
        });

        $(document).on('click', '.minus', function() {
            var $input = $(this).siblings('.quantity-input');
            var currentVal = parseInt($input.val());
            if (!isNaN(currentVal) && currentVal > 0) {
                $input.val(currentVal - 1).trigger('input'); // Update input and trigger calculation
            }
        });

        // Remove row event handler
        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
            calculateTotals();
        });

        // Calculate totals
        function calculateTotals() {
            var subtotal = 0;
            $('#product-table-body .product-total').each(function() {
                subtotal += parseFloat($(this).val()) || 0;
            });
            $('#sub-total').val(subtotal.toFixed(2)); // Set subtotal with two decimals

            var discount = parseFloat($('#discount-price').val()) || 0;
            var taxPercentage = parseFloat($('.product-tax-percentage').val()) || 0;
            var tax = (subtotal - discount) * (taxPercentage / 100);
            tax = tax < 0 ? 0 : tax; // Ensure tax is not negative
            var grandTotal = subtotal - discount + tax;

            $('#grand-total').val(grandTotal.toFixed(2)); // Set grand total with two decimals
        }

        // Invoice form submission
        $('#invoice-form').on('submit', function(e) {
            e.preventDefault();
            var invoiceData = {
                invoice_no: $('#invoice-no').val(),
                schedule_date: $('#schedule-date').val(),
                buyer_from: $('#buyer-from').val(),
                buyer_address: $('#buyer-address').val(),
                buyer_number: $('#buyer-number').val(),
                buyer_email: $('#buyer-email').val(),
                issuer_from: $('#issuer-from').val(),
                issuer_address: $('#issuer-address').val(),
                issuer_number: $('#issuer-number').val(),
                issuer_email: $('#issuer-email').val(),
                products: []
            };

            $('#product-table-body tr').each(function() {
                var product = {
                    name: $(this).find('.product-name').val(),
                    quantity: $(this).find('.quantity-input').val(),
                    price: $(this).find('.product-price').val(),
                    total: $(this).find('.product-total').val()
                };
                invoiceData.products.push(product);
            });

            $.ajax({
                url: '{{ route('invoice.store') }}',
                method: 'POST',
                data: invoiceData,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Invoice Submitted!',
                        text: 'Your invoice has been submitted successfully.',
                    });
                    $('#invoice-form')[0].reset();
                    $('#product-table-body').empty();
                    calculateTotals(); // Reset calculations after form reset
                },
                error: function(jqXHR) {
                    if (jqXHR.status === 422) {
                        // Handle validation errors
                        var errors = jqXHR.responseJSON.errors;
                        var errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value[0] +
                            '<br>'; // Use <br> for line breaks
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Errors',
                            html: errorMessage, // Ensure 'html' option is used to render HTML content
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Submission Failed',
                            text: 'There was an error submitting your invoice. Please try again.',
                        });
                    }
                }
            });
        });
    });
</script>

@endsection
