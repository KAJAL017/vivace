@extends('website.main.app')
@section('title','Collections')
@section('website.content')
    <section class="section-b-space pt-0">
        <div class="heading-banner">
            <div class="custom-container container">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4>Products</h4>
                    </div>
                    <div class="col-sm-6">
                        <ul class="breadcrumb float-end">
                            <li class="breadcrumb-item"> <a href="#">home /</a></li>
                            <li class=" active"> <a href="#">Discounted Products</a></li>
                        </ul>
                    </div>
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
                                                max="50000" step="1" value="50000">
                                            <div class="range-slider-display"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseTwo"><span>Categories</span></button>
                                </h2>
                                <div class="accordion-collapse collapse show" id="panelsStayOpen-collapseTwo">
                                    <div class="accordion-body">
                                        @php
                                            $categories = DB::table('categories')
                                                ->where(['is_deleted' => 0])
                                                ->get();
                                        @endphp
                                        <ul class="catagories-side theme-scrollbar">
                                            @foreach ($categories as $key => $category)
                                                <li>
                                                    <input class="custom-checkbox category-filter"
                                                        id="{{ $category->name }}{{ $key + 1 }}" type="checkbox"
                                                        value="{{ $category->id }}">
                                                    <label
                                                        for="{{ $category->name }}{{ $key + 1 }}">{{ $category->name }}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>


                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseTwo"><span>Sub Categories</span></button>
                                </h2>
                                <div class="accordion-collapse collapse show" id="panelsStayOpen-collapseTwo">
                                    <div class="accordion-body">
                                        @php
                                            $sub_categories = DB::table('sub_categories')
                                                ->where(['is_deleted' => 0])
                                                ->get();
                                        @endphp
                                        <ul class="catagories-side theme-scrollbar">
                                            @foreach ($sub_categories as $key => $sub_category)
                                                <li>
                                                    <input class="custom-checkbox subcategory-filter"
                                                        id="{{ $sub_category->name }}{{ $key + 1 }}" type="checkbox"
                                                        value="{{ $sub_category->id }}">
                                                    <label
                                                        for="{{ $sub_category->name }}{{ $key + 1 }}">{{ $sub_category->name }}

                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                        </div>

                        <div class="accordion-item">
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
            function updatePriceRangeDisplay() {
                const minPrice = $('#min-price').val();
                const maxPrice = $('#max-price').val();
                $('#price-range-display').text(`₹${formatPrice(minPrice)} - ₹${formatPrice(maxPrice)}`);
            }

            function formatPrice(value) {
                return new Intl.NumberFormat('en-IN').format(value);
            }

            updatePriceRangeDisplay();

            let debounceTimeout;

            function filterProducts() {
                clearTimeout(debounceTimeout);
                debounceTimeout = setTimeout(function() {
                    updatePriceRangeDisplay();
                    const query = $('#search').val();
                    const minPrice = $('#min-price').val();
                    const maxPrice = $('#max-price').val();
                    const categories = $('.category-filter:checked').map(function() {
                        return $(this).val();
                    }).get();
                    const subcategories = $('.subcategory-filter:checked').map(function() {
                        return $(this).val();
                    }).get();

                    if (parseFloat(minPrice) > parseFloat(maxPrice)) {
                        alert('Minimum price cannot be greater than maximum price.');
                        return;
                    }

                    $.ajax({
                        url: '{{ route('shop.product.filter') }}',
                        method: 'GET',
                        data: {
                            search: query,
                            min_price: minPrice,
                            max_price: maxPrice,
                            categories: categories,
                            subcategories: subcategories
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function(response) {
                            if (response.html) {
                                $('#product-results').html(response.html);
                            } else {
                                $('#product-results').html('<p>No products found.</p>');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            $('#product-results').html(
                                '<p>Something went wrong. Please try again later.</p>');
                        },
                    });
                }, 500);
            }

            $('#min-price, #max-price, #search').on('input change', filterProducts);
            $('.category-filter, .subcategory-filter').on('change', filterProducts);
        });
    </script>
@endsection
