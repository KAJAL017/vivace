<div class="user-details-modal">
    <!-- User Header -->
    <div class="user-header">
        <div class="user-avatar-large">
            {{ strtoupper(substr($user->name, 0, 2)) }}
        </div>
        <div class="user-info-header">
            <h3 class="user-name-large">{{ $user->name }}</h3>
            <div class="user-contact-info">
                <span class="contact-item">
                    <iconify-icon icon="solar:letter-bold"></iconify-icon>
                    {{ $user->email ?? 'N/A' }}
                </span>
                <span class="contact-item">
                    <iconify-icon icon="solar:phone-bold"></iconify-icon>
                    {{ $user->phone ?? 'N/A' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="user-stats-grid">
        <div class="stat-box">
            <div class="stat-icon blue">
                <iconify-icon icon="solar:bag-bold"></iconify-icon>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $total_orders }}</div>
                <div class="stat-label">Total Orders</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon green">
                <iconify-icon icon="solar:dollar-bold"></iconify-icon>
            </div>
            <div class="stat-content">
                <div class="stat-value">₹{{ number_format($total_spent, 2) }}</div>
                <div class="stat-label">Total Spent</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon orange">
                <iconify-icon icon="solar:clock-circle-bold"></iconify-icon>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $pending_orders }}</div>
                <div class="stat-label">Pending Orders</div>
            </div>
        </div>
    </div>

    <!-- Addresses -->
    <div class="section-box">
        <h4 class="section-title">
            <iconify-icon icon="solar:map-point-bold"></iconify-icon>
            Saved Addresses
        </h4>
        @if($addresses && $addresses->count() > 0)
            <div class="addresses-grid">
                @foreach($addresses as $address)
                <div class="address-card">
                    <div class="address-type">
                        <iconify-icon icon="solar:home-bold"></iconify-icon>
                        Address
                    </div>
                    <div class="address-text">
                        @php
                            $addressParts = [];
                            
                            // Check all possible address fields
                            if(isset($address->address) && !empty($address->address)) {
                                $addressParts[] = $address->address;
                            }
                            if(isset($address->address_line1) && !empty($address->address_line1)) {
                                $addressParts[] = $address->address_line1;
                            }
                            if(isset($address->address_line2) && !empty($address->address_line2)) {
                                $addressParts[] = $address->address_line2;
                            }
                            if(isset($address->street) && !empty($address->street)) {
                                $addressParts[] = $address->street;
                            }
                            if(isset($address->city) && !empty($address->city)) {
                                $addressParts[] = $address->city;
                            }
                            if(isset($address->state) && !empty($address->state)) {
                                $addressParts[] = $address->state;
                            }
                            if(isset($address->zip_code) && !empty($address->zip_code)) {
                                $addressParts[] = $address->zip_code;
                            }
                            if(isset($address->pincode) && !empty($address->pincode)) {
                                $addressParts[] = $address->pincode;
                            }
                            if(isset($address->country) && !empty($address->country)) {
                                $addressParts[] = $address->country;
                            }
                        @endphp
                        
                        @if(count($addressParts) > 0)
                            {{ implode(', ', $addressParts) }}
                        @else
                            Address details not available
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <iconify-icon icon="solar:map-point-broken"></iconify-icon>
                <p>No saved addresses</p>
            </div>
        @endif
    </div>
</div>
