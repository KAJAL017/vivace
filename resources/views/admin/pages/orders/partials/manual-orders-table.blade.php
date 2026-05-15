<div class="table-container" style="padding: 0; overflow-x: auto;">
    <table class="orders-table" style="width: 100%; border-collapse: collapse;">
        <thead style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
            <tr>
                <th style="padding: 1rem; text-align: left; font-weight: 600; font-size: 0.875rem; color: #2c3e50; text-transform: uppercase; letter-spacing: 0.5px; width: 5%;">#</th>
                <th style="padding: 1rem; text-align: left; font-weight: 600; font-size: 0.875rem; color: #2c3e50; text-transform: uppercase; letter-spacing: 0.5px; width: 10%;">Order ID</th>
                <th style="padding: 1rem; text-align: left; font-weight: 600; font-size: 0.875rem; color: #2c3e50; text-transform: uppercase; letter-spacing: 0.5px; width: 15%;">Customer</th>
                <th style="padding: 1rem; text-align: left; font-weight: 600; font-size: 0.875rem; color: #2c3e50; text-transform: uppercase; letter-spacing: 0.5px; width: 12%;">Mobile</th>
                <th style="padding: 1rem; text-align: left; font-weight: 600; font-size: 0.875rem; color: #2c3e50; text-transform: uppercase; letter-spacing: 0.5px; width: 10%;">Date</th>
                <th style="padding: 1rem; text-align: left; font-weight: 600; font-size: 0.875rem; color: #2c3e50; text-transform: uppercase; letter-spacing: 0.5px; width: 10%;">Status</th>
                <th style="padding: 1rem; text-align: left; font-weight: 600; font-size: 0.875rem; color: #2c3e50; text-transform: uppercase; letter-spacing: 0.5px; width: 10%;">Images</th>
                <th style="padding: 1rem; text-align: left; font-weight: 600; font-size: 0.875rem; color: #2c3e50; text-transform: uppercase; letter-spacing: 0.5px; width: 28%;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $key => $order)
            <tr data-id="{{ $order->id }}" style="border-bottom: 1px solid #f0f0f0; transition: all 0.3s ease;">
                <td style="padding: 1rem; vertical-align: middle; color: #495057; font-size: 0.9375rem;">{{ $orders->firstItem() + $key }}</td>
                <td style="padding: 1rem; vertical-align: middle;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <iconify-icon icon="solar:tag-bold" style="color: #3498db; font-size: 1.125rem;"></iconify-icon>
                        <span style="font-weight: 700; color: #2c3e50; font-family: 'Courier New', monospace;">{{ $order->order_id }}</span>
                    </div>
                </td>
                <td style="padding: 1rem; vertical-align: middle;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.75rem; flex-shrink: 0;">
                            {{ strtoupper(substr($order->name ?? 'U', 0, 2)) }}
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                            <span style="font-weight: 600; color: #2c3e50; font-size: 0.9375rem;">{{ $order->name ?? 'N/A' }}</span>
                        </div>
                    </div>
                </td>
                <td style="padding: 1rem; vertical-align: middle;">
                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                        <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem;">
                            <iconify-icon icon="solar:phone-bold" style="color: #27ae60; font-size: 1.125rem;"></iconify-icon>
                            <span>{{ $order->mobile }}</span>
                        </div>
                        @if($order->alternate_mobile)
                        <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8125rem; color: #7f8c8d;">
                            <iconify-icon icon="solar:phone-bold" style="font-size: 1rem;"></iconify-icon>
                            <span>{{ $order->alternate_mobile }}</span>
                        </div>
                        @endif
                    </div>
                </td>
                <td style="padding: 1rem; vertical-align: middle;">
                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <iconify-icon icon="solar:calendar-bold" style="color: #e74c3c; font-size: 1.125rem;"></iconify-icon>
                            <span style="font-weight: 600; color: #2c3e50; font-size: 0.875rem;">
                                @php
                                    $orderDate = null;
                                    if(isset($order->date)) {
                                        try {
                                            $orderDate = \Carbon\Carbon::parse($order->date);
                                        } catch (\Exception $e) {
                                            $orderDate = null;
                                        }
                                    }
                                @endphp
                                @if($orderDate)
                                    {{ $orderDate->format('d M Y') }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </div>
                    </div>
                </td>
                <td style="padding: 1rem; vertical-align: middle;">
                    @if($order->is_confirm == 1)
                        <span style="padding: 0.375rem 0.75rem; border-radius: 6px; font-size: 0.8125rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.375rem; background: #d1e7dd; color: #0f5132;">
                            <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
                            Shipped
                        </span>
                    @elseif($order->is_proceed == 1)
                        <span style="padding: 0.375rem 0.75rem; border-radius: 6px; font-size: 0.8125rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.375rem; background: #cfe2ff; color: #084298;">
                            <iconify-icon icon="solar:clock-circle-bold"></iconify-icon>
                            Ongoing
                        </span>
                    @else
                        <span style="padding: 0.375rem 0.75rem; border-radius: 6px; font-size: 0.8125rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.375rem; background: #fff3cd; color: #856404;">
                            <iconify-icon icon="solar:star-bold"></iconify-icon>
                            Pending
                        </span>
                    @endif
                </td>
                <td style="padding: 1rem; vertical-align: middle;">
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        @php
                            $productScreenshots = json_decode($order->product_screenshot, true);
                            $paymentScreenshots = json_decode($order->payment_screenshot, true);
                        @endphp
                        @if($productScreenshots && is_array($productScreenshots))
                            <button class="view-images" data-images="{{ implode(',', array_map('url', $productScreenshots)) }}" data-title="Product Images" style="padding: 0.375rem 0.75rem; background: #3498db; color: white; border: none; border-radius: 6px; font-size: 0.75rem; cursor: pointer; transition: all 0.3s ease;">
                                Product
                            </button>
                        @endif
                        @if($paymentScreenshots && is_array($paymentScreenshots))
                            <button class="view-images" data-images="{{ implode(',', array_map('url', $paymentScreenshots)) }}" data-title="Payment Images" style="padding: 0.375rem 0.75rem; background: #27ae60; color: white; border: none; border-radius: 6px; font-size: 0.75rem; cursor: pointer; transition: all 0.3s ease;">
                                Payment
                            </button>
                        @endif
                    </div>
                </td>
                <td style="padding: 1rem; vertical-align: middle;">
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center;">
                        @if($order->is_confirm != 1 && $order->is_proceed != 1)
                            <!-- Pending Status Actions -->
                            <button class="proceed-btn" data-id="{{ $order->id }}" style="padding: 0.5rem 0.75rem; background: #27ae60; color: white; border: none; border-radius: 6px; font-size: 0.8125rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                                Proceed
                            </button>
                        @elseif($order->is_proceed == 1 && $order->is_confirm != 1)
                            <!-- Ongoing Status Actions -->
                            <button class="push-order" data-id="{{ $order->id }}" style="padding: 0.5rem 0.75rem; background: #3498db; color: white; border: none; border-radius: 6px; font-size: 0.8125rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                                Push to ShipRocket
                            </button>
                            <button class="confirm-manual" data-id="{{ $order->id }}" style="padding: 0.5rem 0.75rem; background: #f39c12; color: white; border: none; border-radius: 6px; font-size: 0.8125rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                                Push to Manual
                            </button>
                        @elseif($order->is_confirm == 1)
                            <!-- Shipped Status Actions -->
                            <button class="update-tracking-btn" data-id="{{ $order->id }}" style="padding: 0.5rem 0.75rem; background: #27ae60; color: white; border: none; border-radius: 6px; font-size: 0.8125rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                                Update Tracking
                            </button>
                        @endif
                        
                        <button class="view-address-btn" data-name="{{ $order->name }}" data-mobile="{{ $order->mobile }}" data-alt-mobile="{{ $order->alternate_mobile }}" data-street="{{ $order->street_address }}" data-colony="{{ $order->colony }}" data-pincode="{{ $order->pincode }}" data-city="{{ $order->city }}" data-state="{{ $order->state }}" data-bs-toggle="modal" data-bs-target="#addressModal" style="padding: 0.5rem 0.75rem; background: #9b59b6; color: white; border: none; border-radius: 6px; font-size: 0.8125rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                            Address
                        </button>
                        
                        <button class="print-address-btn" data-order-id="{{ $order->order_id }}" data-name="{{ $order->name }}" data-mobile="{{ $order->mobile }}" data-alt-mobile="{{ $order->alternate_mobile }}" data-street="{{ $order->street_address }}" data-colony="{{ $order->colony }}" data-pincode="{{ $order->pincode }}" data-city="{{ $order->city }}" data-state="{{ $order->state }}" style="padding: 0.5rem 0.75rem; background: #16a085; color: white; border: none; border-radius: 6px; font-size: 0.8125rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                            Print
                        </button>
                        
                        <button class="delete-btn" data-id="{{ $order->id }}" style="padding: 0.5rem; background: #e74c3c; color: white; border: none; border-radius: 6px; font-size: 1rem; cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px;">
                            <iconify-icon icon="solar:trash-bin-minimalistic-2-broken"></iconify-icon>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 3rem; color: #7f8c8d;">
                    <iconify-icon icon="solar:inbox-line-broken" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></iconify-icon>
                    <p style="margin: 0; font-size: 1rem; font-weight: 600;">No orders found</p>
                    <p style="margin: 0.5rem 0 0 0; font-size: 0.875rem;">Try adjusting your filters</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    // Print Address Function - Vanilla JS
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('print-address-btn')) {
            e.preventDefault();
            const btn = e.target;
            const orderId = btn.getAttribute('data-order-id');
            const name = btn.getAttribute('data-name');
            const mobile = btn.getAttribute('data-mobile');
            const altMobile = btn.getAttribute('data-alt-mobile');
            const street = btn.getAttribute('data-street');
            const colony = btn.getAttribute('data-colony');
            const pincode = btn.getAttribute('data-pincode');
            const city = btn.getAttribute('data-city');
            const state = btn.getAttribute('data-state');
            
            // Create clean filename from customer name
            const cleanName = (name || 'Customer').replace(/[^a-zA-Z0-9]/g, '_');
            const fileName = `${cleanName}_ShippingLabel`;
            
            // Create print window
            const printWindow = window.open('', '_blank', 'width=800,height=600');
            
            // Clean Professional Shipping Label
            const printContent = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>${fileName}</title>
                    <style>
                        @page {
                            size: A4;
                            margin: 20mm;
                        }
                        
                        * {
                            margin: 0;
                            padding: 0;
                            box-sizing: border-box;
                        }
                        
                        body {
                            font-family: 'Georgia', 'Times New Roman', serif;
                            background: white;
                            -webkit-print-color-adjust: exact;
                            print-color-adjust: exact;
                        }
                        
                        .label-container {
                            width: 100%;
                            max-width: 650px;
                            margin: 0 auto;
                            background: white;
                            padding: 40px;
                            text-align: center;
                        }
                        
                        /* VC Logo */
                        .vc-logo {
                            width: 150px;
                            height: auto;
                            margin: 0 auto 10px;
                            display: block;
                        }
                        
                        /* Company Title */
                        .company-title {
                            font-size: 24px;
                            font-weight: 400;
                            color: #b8b8b8;
                            letter-spacing: 12px;
                            text-transform: uppercase;
                            margin-top: 10px;
                            margin-bottom: 60px;
                            font-family: 'Georgia', serif;
                        }
                        
                        /* Customer Name */
                        .customer-name {
                            font-size: 32px;
                            font-weight: bold;
                            color: #000;
                            margin-bottom: 30px;
                            font-family: 'Georgia', serif;
                        }
                        
                        /* Phone Numbers */
                        .phone-number {
                            font-size: 24px;
                            font-weight: 400;
                            color: #000;
                            margin-bottom: 18px;
                            font-family: 'Georgia', serif;
                        }
                        
                        /* Address Lines */
                        .address-line {
                            font-size: 22px;
                            line-height: 1.8;
                            color: #000;
                            margin-bottom: 12px;
                            font-family: 'Georgia', serif;
                        }
                        
                        .city-line {
                            font-size: 22px;
                            color: #000;
                            margin-bottom: 12px;
                            font-family: 'Georgia', serif;
                        }
                        
                        .state-line {
                            font-size: 22px;
                            color: #000;
                            margin-bottom: 80px;
                            font-family: 'Georgia', serif;
                        }
                        
                        /* Footer Section */
                        .footer-section {
                            margin-top: 80px;
                            padding-top: 30px;
                        }
                        
                        .tagline {
                            font-size: 18px;
                            font-style: italic;
                            color: #b8b8b8;
                            margin-bottom: 15px;
                            font-family: 'Georgia', serif;
                        }
                        
                        .instagram {
                            font-size: 16px;
                            color: #b8b8b8;
                            margin-bottom: 20px;
                            font-family: 'Georgia', serif;
                        }
                        
                        .store-address {
                            font-size: 16px;
                            color: #b8b8b8;
                            line-height: 1.6;
                            margin-bottom: 5px;
                            font-family: 'Georgia', serif;
                        }
                        
                        .store-phone {
                            font-size: 16px;
                            color: #b8b8b8;
                            font-family: 'Georgia', serif;
                        }
                        
                        @media print {
                            body {
                                margin: 0;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="label-container">
                        <!-- VC Logo Image -->
                        <img src="http://localhost/vivace/public/website_assets/assets/vc.jpeg" alt="VC Logo" class="vc-logo">
                        
                        <!-- Company Title -->
                        <div class="company-title">VIVACE COLLECTIONS</div>
                        
                        <!-- Customer Name -->
                        <div class="customer-name">${name || 'N/A'}</div>
                        
                        <!-- Phone Numbers -->
                        <div class="phone-number">${mobile || 'N/A'}</div>
                        ${altMobile && altMobile !== 'null' && altMobile !== 'undefined' ? `<div class="phone-number">${altMobile}</div>` : ''}
                        
                        <!-- Address Lines -->
                        <div class="address-line">${street || 'N/A'}</div>
                        ${colony && colony !== 'null' && colony !== 'undefined' ? `<div class="address-line">${colony}</div>` : ''}
                        <div class="city-line">${city || 'N/A'}</div>
                        <div class="city-line">${state || 'N/A'}</div>
                        <div class="state-line">${pincode || 'N/A'}</div>
                        
                        <!-- Footer Section -->
                        <div class="footer-section">
                            <div class="tagline">Lively Trends for Lively People</div>
                            <div class="instagram">@vivacecollections</div>
                            <div class="store-address">Shop No. 1, Ground Floor, Shree Ganesh Complex,</div>
                            <div class="store-address">Near Railway Station, Mumbai - 400001</div>
                            <div class="store-phone">+91 98765 43210</div>
                        </div>
                    </div>
                    
                    <script>
                        // Set document title for PDF filename
                        document.title = '${fileName}';
                        
                        window.onload = function() {
                            setTimeout(function() {
                                window.print();
                            }, 250);
                        }
                    <\/script>
                </body>
                </html>
            `;
            
            printWindow.document.write(printContent);
            printWindow.document.close();
        }
    });
</script>
