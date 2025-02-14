@extends('website.main.app')
@section('title','Shop')
@section('website.content')
    <section class="section-b-space pt-0">
        <div class="heading-banner">
            <div class="custom-container container">
                <h4 class="text-center">{{ $sub_category->name ?? '' }}</h4>

            </div>
        </div>
        </div>
    </section>
    <section class="section-b-space pt-0">
        <div class="custom-container container">
            <div class="row">
                <div class="col-3">
                    <div class="custom-accordion theme-scrollbar left-box">
                        <div class="left-accordion">
                            <h5>Back </h5><i class="back-button fa-solid fa-xmark"></i>
                        </div>
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="search-box">
                                <input type="search" name="text" placeholder="Search here..." id="search"><i
                                    class="iconsax" data-icon="search-normal-2"></i>
                            </div>
                            <div class="accordion-item">
                                {{-- <h2 class="accordion-header">
                                    <button class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseTwo"><span>Categories</span></button>
                                </h2> --}}
                                {{-- <div class="accordion-collapse collapse show" id="panelsStayOpen-collapseTwo">
                                    <div class="accordion-body">
                                        <ul class="catagories-side theme-scrollbar">
                                            <li>
                                                <input class="custom-checkbox" id="category1" type="checkbox"
                                                    name="text">
                                                <label for="category1">Fashion (30)</label>
                                            </li>
                                            <li>
                                                <input class="custom-checkbox" id="category2" type="checkbox"
                                                    name="text">
                                                <label for="category2">Trends</label>
                                            </li>
                                            <li>
                                                <input class="custom-checkbox" id="category3" type="checkbox"
                                                    name="text">
                                                <label for="category3">Women’s Shirts</label>
                                            </li>
                                            <li>
                                                <input class="custom-checkbox" id="category4" type="checkbox"
                                                    name="text">
                                                <label for="category4">Top T-shirt</label>
                                            </li>
                                            <li>
                                                <input class="custom-checkbox" id="category5" type="checkbox"
                                                    name="text">
                                                <label for="category5">Denim (8)</label>
                                            </li>
                                            <li>
                                                <input class="custom-checkbox" id="category6" type="checkbox"
                                                    name="text">
                                                <label for="category6">Grains & Beans (8)</label>
                                            </li>
                                            <li>
                                                <input class="custom-checkbox" id="category7" type="checkbox"
                                                    name="text">
                                                <label for="category7">Cosmopolis</label>
                                            </li>
                                            <li>
                                                <input class="custom-checkbox" id="category8" type="checkbox"
                                                    name="text">
                                                <label for="category8">Metropolis</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseFour"><span>Filter</span></button>
                                </h2>
                                <div class="accordion-collapse collapse show" id="panelsStayOpen-collapseFour">
                                    <div class="accordion-body">
                                        <div class="range-slider">
                                            <input id="min-price" class="range-slider-input" type="range" min="0"
                                                max="10000" step="1" value="100">
                                            <input id="max-price" class="range-slider-input" type="range" min="0"
                                                max="10000" step="1" value="10000">
                                            <div class="range-slider-display"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            {{-- <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseOne"><span>Color</span></button>
                                </h2>
                                <div class="accordion-collapse collapse show" id="panelsStayOpen-collapseOne">
                                    <div class="accordion-body">
                                        <div class="color-box">
                                            <ul class="color-variant">
                                                <li class="bg-color-purple"></li>
                                                <li class="bg-color-blue"></li>
                                                <li class="bg-color-red"></li>
                                                <li class="bg-color-yellow"></li>
                                                <li class="bg-color-coffee"></li>
                                                <li class="bg-color-chocolate"></li>
                                                <li class="bg-color-brown"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseSix"><span>Availability</span></button>
                                </h2>
                                <div class="accordion-collapse collapse show" id="panelsStayOpen-collapseSix">
                                    <div class="accordion-body">
                                        <ul class="catagories-side">
                                            <li>
                                                <input class="custom-radio" id="category9" type="radio"
                                                    checked="checked" name="radio">
                                                <label for="category9">In Stock(3)</label>
                                            </li>
                                            <li>
                                                <input class="custom-radio" id="category14" type="radio"
                                                    name="radio">
                                                <label for="category14">Out Of Stock(1)</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header tags-header">
                                    <button class="accordion-button"><span>Shipping & Delivery</span><span></span></button>
                                </h2>
                                <div class="accordion-collapse collapse show" id="panelsStayOpen-collapseSeven">
                                    <div class="accordion-body">
                                        <ul class="widget-card">
                                            <li><i class="iconsax" data-icon="truck-fast"></i>
                                                <div>
                                                    <h6>Free Shipping</h6>
                                                    <p>Free shipping for all US order</p>
                                                </div>
                                            </li>
                                            <li><i class="iconsax" data-icon="headphones"></i>
                                                <div>
                                                    <h6>Support 24/7</h6>
                                                    <p>Free shipping for all US order</p>
                                                </div>
                                            </li>
                                            <li><i class="iconsax" data-icon="exchange"></i>
                                                <div>
                                                    <h6>30 Days Return</h6>
                                                    <p>Free shipping for all US order</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="sticky">
                        <div class="top-filter-menu">
                            <div> <a class="filter-button btn">
                                    <h6> <i class="iconsax" data-icon="filter"></i>Filter Menu </h6>
                                </a>
                                <div class="category-dropdown">
                                    <label for="sort-by">Sort By :</label>
                                    <select class="form-select" id="sort-by" name="sortlist">
                                        <option value="best-selling">Best selling</option>
                                        <option value="popularity">Popularity</option>
                                        <option value="featured">Featured</option>
                                        <option value="alphabetical">Alphabetically, Z-A</option>
                                        <option value="price-high-low">High - Low Price</option>
                                        <option value="discount-high-low">% Off - High To Low</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="product-tab-content ratio1_3">
                            <div class="row row-cols-lg-4 row-cols-md-3 row-cols-2 grid-section view-option g-3 g-xl-4"
                                id="product-results">
                                @if ($products->isEmpty())
                                    <div class="no-products">
                                        <p>No products found.</p>
                                    </div>
                                @else
                                    @foreach ($products as $product)
                                        @include('website.pages.product.partials.product', [
                                            'product' => $product,
                                        ])
                                    @endforeach
                                @endif

                            </div>
                        </div>

                        {{-- <div class="pagination-wrap">
                            <ul class="pagination">
                                <li> <a class="prev" href="#"><i class="iconsax"
                                            data-icon="chevron-left"></i></a></li>
                                <li> <a href="#">1</a></li>
                                <li> <a class="active" href="#">2</a></li>
                                <li> <a href="#">3 </a></li>
                                <li> <a class="next" href="#"> <i class="iconsax"
                                            data-icon="chevron-right"></i></a></li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('website.js')
    <script src="{{ website_assets() }}/assets/js/filter-range-slider.js"></script>
    <script>
        $(document).ready(function() {
            // Function to update the displayed price range
            function updatePriceRangeDisplay() {
                const minPrice = $('#min-price').val();
                const maxPrice = $('#max-price').val();
                $('#price-range-display').text(`₹${formatPrice(minPrice)} - ₹${formatPrice(maxPrice)}`);
            }

            // Function to format price
            function formatPrice(value) {
                return new Intl.NumberFormat('en-IN').format(value);
            }

            // Initialize the price range display on page load
            updatePriceRangeDisplay();

            // Variable for debounce timeout
            let debounceTimeout;

            // Update the price display and send AJAX request when sliders are changed
            $('#min-price, #max-price, #search').on('input change', function() {
                // Clear the previous debounce timeout
                clearTimeout(debounceTimeout);

                // Set a new timeout to trigger after a 500ms delay
                debounceTimeout = setTimeout(function() {
                    updatePriceRangeDisplay();

                    const query = $('#search').val(); // Get the search query
                    const minPrice = $('#min-price').val(); // Get the min price from the slider
                    const maxPrice = $('#max-price').val(); // Get the max price from the slider

                    // Validation for correct min and max price
                    if (parseFloat(minPrice) > parseFloat(maxPrice)) {
                        alert('Minimum price cannot be greater than maximum price.');
                        return;
                    }

                    const slug =
                    "{{ $sub_category->slug }}";

                    $.ajax({
                        url: `{{ route('filter.product', ':slug') }}`.replace(':slug',
                            slug), // Replace :slug with the actual slug
                        method: 'GET',
                        data: {
                            search: query,
                            min_price: minPrice,
                            max_price: maxPrice,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function(response) {
                            if (response.html) {
                                $('#product-results').html(response
                                .html); // Update the product results
                            } else {
                                $('#product-results').html(
                                '<p>No products found.</p>'); // No products found
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error); // Handle errors
                            $('#product-results').html(
                                '<p>Something went wrong. Please try again later.</p>'
                                ); // Display error message
                        },
                    });
                }, 500); // Delay of 500ms
            });
        });
    </script>
@endsection
