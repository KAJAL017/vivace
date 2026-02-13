
@extends('admin.main.app')
@section('admin-content')
@section('admin-title', 'Latest Orders')
@section('admin-css')
    <link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table/css/vendors/datatables.css">
    <link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table/css/vendors/datatable-extension.css">
    <link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table.css">
@endsection



<div class="container-xxl">

    <div class="row">
         <div class="col-xl-9 col-lg-8">
              <div class="row">
                   <div class="col-lg-12">
                        <div class="card">
                             <div class="card-body">
                                  <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                       <div>
                                            <h4 class="fw-medium text-dark d-flex align-items-center gap-2">#{{ $order->custom_order_id }}
                                              {{-- <span class="badge bg-success-subtle text-success  px-2 py-1 fs-13">Paid</span> --}}
                                              <span class="border border-warning text-warning fs-13 px-2 py-1 rounded">In Progress</span></h4>
                                            <p class="mb-0">Order / Order Details / #{{ $order->custom_order_id }} - <td> {{ $order->date }}</td></p>
                                       </div>
                                  </div>

                                  <div class="mt-4">
                                       <h4 class="fw-medium text-dark">Progress</h4>
                                  </div>
                                  <div class="row row-cols-xxl-5 row-cols-md-2 row-cols-1">
                                       <div class="col">
                                            <div class="progress mt-3" style="height: 10px;">
                                                 <div class="progress-bar progress-bar  progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 100%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="70">
                                                 </div>
                                            </div>
                                            <p class="mb-0 mt-2">Order Confirming</p>
                                       </div>
                                       <div class="col">
                                            <div class="progress mt-3" style="height: 10px;">
                                                 <div class="progress-bar progress-bar  progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 100%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="70">
                                                 </div>
                                            </div>
                                            <p class="mb-0 mt-2">Payment Pending</p>
                                       </div>
                                       <div class="col">
                                            <div class="progress mt-3" style="height: 10px;">
                                                 <div class="progress-bar progress-bar  progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 60%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="70">
                                                 </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 mt-2">
                                                 <p class="mb-0">Processing</p>
                                                 <div class="spinner-border spinner-border-sm text-warning" role="status">
                                                      <span class="visually-hidden">Loading...</span>
                                                 </div>
                                            </div>
                                       </div>
                                       <div class="col">
                                            <div class="progress mt-3" style="height: 10px;">
                                                 <div class="progress-bar progress-bar  progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="70">
                                                 </div>
                                            </div>
                                            <p class="mb-0 mt-2">Shipping</p>
                                       </div>
                                       <div class="col">
                                            <div class="progress mt-3" style="height: 10px;">
                                                 <div class="progress-bar progress-bar  progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="70">
                                                 </div>
                                            </div>
                                            <p class="mb-0 mt-2">Delivered</p>
                                       </div>
                                  </div>
                             </div>
                             <div class="card-footer d-flex flex-wrap align-items-center justify-content-between bg-light-subtle gap-2">
                                <p class="border rounded mb-0 px-2 py-1 bg-body">
                                    <i class='bx bx-arrow-from-left align-middle fs-16'></i>
                                    Estimated Delivery  date:
                                    <span class="text-dark fw-medium">
                                        {{-- {{  $order->date ->addDays(7)->format('M d , Y') }} --}}
                                    </span>
                                </p>
                             </div>
                        </div>
                        <input type="hidden" value="{{ $order->id }}">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Product</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0 table-hover table-centered">
                                        <thead class="bg-light-subtle border-bottom">
                                            <tr>
                                                <th>Product Name & Size</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order_items as $item)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="rounded bg-light avatar-md d-flex align-items-center justify-content-center">
                                                                <img src="{{ path() }}/{{ Product_first_image($item->product_id) }}" alt="" class="avatar-md">
                                                            </div>
                                                            <div>
                                                                <a href="#!" class="text-dark fw-medium fs-15">{{ $item->product_name }}</a>
                                                                <p class="text-muted mb-0 mt-1 fs-13"><span>Size: </span>{{  getSizeData($item->size_id) }}</p>
                                                                <p class="text-muted mb-0 mt-1 fs-13"><span>Color: </span>{{  getColorData($item->color_id) }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light-subtle">
                             <div class="card-body">
                                  <div class="row g-3 g-lg-0">
                                       <div class="col-lg-3 border-end">
                                            <div class="d-flex align-items-center gap-3 justify-content-between px-3">
                                                 <div>
                                                      <p class="text-dark fw-medium fs-16 mb-1">Date</p>
                                                      <p class="mb-0">{{ $order->date }}
                                                    </p>
                                                 </div>
                                                 <div class="avatar bg-light d-flex align-items-center justify-content-center rounded">
                                                      <iconify-icon icon="solar:calendar-date-bold-duotone" class="fs-35 text-primary"></iconify-icon>
                                                 </div>
                                            </div>
                                       </div>
                                       {{-- <div class="col-lg-3 border-end">
                                            <div class="d-flex align-items-center gap-3 justify-content-between px-3">
                                                 <div>
                                                      <p class="text-dark fw-medium fs-16 mb-1">Paid By</p>
                                                      <p class="mb-0">Gaston Lapierre</p>
                                                 </div>
                                                 <div class="avatar bg-light d-flex align-items-center justify-content-center rounded">
                                                      <iconify-icon icon="solar:user-circle-bold-duotone" class="fs-35 text-primary"></iconify-icon>
                                                 </div>
                                            </div>
                                       </div> --}}
                                       <div class="col-lg-3">
                                            <div class="d-flex align-items-center gap-3 justify-content-between px-3">
                                                 <div>
                                                      <p class="text-dark fw-medium fs-16 mb-1">Reference</p>
                                                      <p class="mb-0">#{{ $order->custom_order_id }}</p>
                                                 </div>
                                                 <div class="avatar bg-light d-flex align-items-center justify-content-center rounded">
                                                      <iconify-icon icon="solar:clipboard-text-bold-duotone" class="fs-35 text-primary"></iconify-icon>
                                                 </div>
                                            </div>
                                       </div>
                                  </div>
                             </div>
                        </div>
                   </div>
              </div>
         </div>

         <div class="col-xl-3 col-lg-4">
              <div class="card">
                   <div class="card-header">
                        <h4 class="card-title">Order Summary</h4>
                   </div>
                   <div class="card-footer d-flex align-items-center justify-content-between bg-light-subtle">
                        <div>
                             <p class="fw-medium text-dark mb-0">Total Amount</p>
                        </div>
                        <div>
                             <p class="fw-medium text-dark mb-0">₹{{ number_format($order->total_amount,2) }}</p>
                        </div>

                   </div>
              </div>

              <div class="card">
                   <div class="card-header">
                        <h4 class="card-title">Payment Details</h4>
                   </div>
                   <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                             <p class="mb-0 text-muted">Payment Method:</p>
                             <p class="mb-0 fw-medium">{{ $order->payment_method ?? 'N/A' }}</p>
                        </div>
                        @if($order->payment_id)
                        <div class="d-flex justify-content-between mb-2">
                             <p class="mb-0 text-muted">Payment ID:</p>
                             <p class="mb-0 fw-medium">{{ $order->payment_id }}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                             <p class="mb-0 text-muted">Status:</p>
                             <span class="badge bg-success-subtle text-success">Paid</span>
                        </div>
                        @else
                        <div class="d-flex justify-content-between">
                             <p class="mb-0 text-muted">Status:</p>
                             <span class="badge bg-warning-subtle text-warning">Cash on Delivery</span>
                        </div>
                        @endif
                   </div>
              </div>

              <div class="card">
                   <div class="card-header">
                        <h4 class="card-title">Customer Details</h4>
                   </div>
                   <div class="card-body">
                        <div class="d-flex align-items-center gap-2">

                            <img src="{{ getUser($order->user_id)->image ? path() . '/' . getUser($order->user_id)->image : path() . '/default.png' }}" alt="" class="avatar rounded-3 border border-light border-3">

                             <div>
                                  <p class="mb-1">{{ getUser($order->user_id)->name ?? '' }}</p>
                                  <a href="#!" class="link-primary fw-medium">{{ getUser($order->user_id)->email ?? '' }}</a>
                             </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                             <h5 class="">Contact Number</h5>
                        </div>
                        <p class="mb-1">{{ getUser($order->user_id)->phone }}</p>

                        <div class="d-flex justify-content-between mt-3">
                             <h5 class="">Shipping Address</h5>
                        </div>

                        <div style="font-family: Arial, sans-serif; color: #333;">
                            <p class="mb-1" style="margin-bottom: 8px; font-size: 14px; color: #555;">{{ getAddressData($order->shipping_address_id)->address ?? 'N/A' }}</p>
                            <p class="mb-1" style="margin-bottom: 8px; font-size: 14px; color: #555;">
                                {{ getAddressData($order->shipping_address_id)->city ?? 'N/A' }} {{ getAddressData($order->shipping_address_id)->pincode ?? 'N/A' }}
                            </p>
                            <p class="mb-1" style="margin-bottom: 8px; font-size: 14px; color: #555;">{{ getAddressData($order->shipping_address_id)->state ?? 'N/A' }}</p>
                            <p class="mb-1" style="margin-bottom: 8px; font-size: 14px; color: #555;">{{ getAddressData($order->shipping_address_id)->phone ?? 'N/A' }}</p>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                             <h5 class="">Billing Address</h5>
                        </div>

                        <div style="font-family: Arial, sans-serif; color: #333;">
                            <p class="mb-1" style="margin-bottom: 8px; font-size: 14px; color: #555;">{{ getAddressData($order->billing_address_id)->address ?? 'N/A' }}</p>
                            <p class="mb-1" style="margin-bottom: 8px; font-size: 14px; color: #555;">
                                {{ getAddressData($order->billing_address_id)->city ?? 'N/A' }} {{ getAddressData($order->billing_address_id)->pincode ?? 'N/A' }}
                            </p>
                            <p class="mb-1" style="margin-bottom: 8px; font-size: 14px; color: #555;">{{ getAddressData($order->billing_address_id)->state ?? 'N/A' }}</p>
                            <p class="mb-1" style="margin-bottom: 8px; font-size: 14px; color: #555;">{{ getAddressData($order->billing_address_id)->phone ?? 'N/A' }}</p>
                        </div>

                        @if ($order->is_confirm == 0 && $order->is_cancel ==0)
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Order Actions</h4>
                            </div>
                            <div class="card-body">
                                <button id="pushToShiprocket" class="btn btn-primary">Push to ShipRocket</button>
                            </div>
                        </div>
                        @endif


                   </div>

              </div>
         </div>
    </div>
</div>

@endsection
@section('admin-js')
<script>
    $('#pushToShiprocket').click(function() {
        const orderId = {{ $order->id }};
        $.ajax({
            url: '{{ route('admin.pushToShiprocket') }}',
            type: 'POST',
            data: {
                order_id: orderId,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                if (data.success) {
                    toastr.success('Order pushed to Shiprocket successfully.');
                    window.location.href = '{{ route('OngoingOrder') }}';
                } else {
                    toastr.error('Failed to push order to Shiprocket.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                toastr.error('An error occurred while pushing the order.');
            }
        });
    });
</script>
@endsection
