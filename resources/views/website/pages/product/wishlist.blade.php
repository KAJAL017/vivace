@extends('website.main.app')
@section('title','Wishlist')
@section('website.content')
    <section class="section-b-space pt-0">
        <div class="heading-banner">
            <div class="custom-container container">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4>Wishlist</h4>
                    </div>
                    <div class="col-sm-6">
                        <ul class="breadcrumb float-end">
                            <li class="breadcrumb-item"> <a href="{{ route('website.home') }}">Home / </a></li>
                            <li class=""> <a href="#">Wishlist</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section class="section-b-space pt-0">
        <div class="custom-container container">
            <div class="row g-4">
                {{-- <div class="col-12">
                    <div class="cart-countdown"><img src="{{ website_assets() }}/assets/images/gif/fire-2.gif"
                            alt="">
                        <h6>Please, hurry! Someone has placed an order on one of the items you have in the cart. We'll keep
                            it for you for<span id="countdown"></span>minutes.</h6>
                    </div>
                </div> --}}
                @php
                    $WishlistData = WishlistProductData();
                @endphp
                <div class="col-xxl-12 col-xl-12">
                    <div class="wishlist-table">
                        <div class="table-title">
                            <h5>Wishlist<span id="wishlistTitle"> ({{ count($WishlistData) }} Items)</span></h5>
                            <button id="clearWishlistButton">Clear All</button>
                        </div>

                        <div class="table-responsive theme-scrollbar">
                            <table class="table" id="wishlist-table">
                                <thead>
                                    <tr>
                                        <th>Product </th>
                                        <th>Price </th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($WishlistData as $product)
                                        <tr>
                                            <td>
                                                <div class="wishlist-box">
                                                    <a href="#">
                                                        <img src="{{ $product['product']['image'] }}" alt=""
                                                            width="100px">
                                                    </a>
                                                    <div>
                                                        <a href="#">
                                                            <h6>{{ $product['product']['name'] }}</h6>
                                                        </a>
                                                        <p>Color:
                                                            <span>{{ ucfirst(strtolower(getColorData($product['wishlist_item']['color_id']))) }}</span>
                                                        </p>
                                                        <p>Size:
                                                            <span>{{ ucfirst(strtolower(getSizeData($product['wishlist_item']['size_id']))) }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>₹{{ $product['product']['price'] }}</td>
                                            <td>
                                                <a class="addToCartButton btn btn-success" href="javascript:void(0)"
                                                data-product-id="{{ $product['product']['id'] }}"
                                                data-color-id="{{ $product['wishlist_item']['color_id'] }}"
                                                data-size-id="{{ $product['wishlist_item']['size_id'] }}">Add to Cart</a>

                                                <a class="deleteButton" href="javascript:void(0)">
                                                    <i class="iconsax" data-icon="trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">
                                                <div class="no-data">
                                                    <img src="{{ website_assets() }}/assets/images/wishlist/empty-wishlist.gif"
                                                        alt="">
                                                    <h4>Your wishlist is empty!</h4>
                                                    <p>Browse our store and add items to your wishlist. <span>Start
                                                            Shopping</span></p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('website.js')
<script>
    // Assign the PHP session value to a JavaScript variable
    var userId = @json(session('user_id') ?? session('temporary_user_id'));
</script>

<script>
    $(document).on('click', '.addToCartButton', function(e) {
    e.preventDefault();

    // Get product details
    let productId = $(this).data('product-id');
    let colorId = $(this).data('color-id');
    let sizeId = $(this).data('size-id');
    let quantity = 1; // Default quantity to 1, you can modify this logic if necessary


    if (!userId) {
        toastr.error('You need to log in to add products to your cart.');
        return;
    }

    // Send AJAX request to add to cart
    $.ajax({
        url: '{{ route('add-to-cart') }}', // Define this route in Laravel to handle adding to cart
        type: 'POST',
        data: {
            product_id: productId,
            color_id: colorId,
            size_id: sizeId,
            quantity: quantity,
            user_id: userId, // Send the logged-in user ID
            _token: '{{ csrf_token() }}' // CSRF token for security
        },
        success: function(response) {
            if (response.success) {
                toastr.success('Product added to cart!');
                window.location.href = '{{ route('cart') }}';
            } else {
                toastr.error(response.message);
            }
        },
        error: function() {
            toastr.error('Failed to add product to cart.');
        }
    });
});

</script>
@endsection
