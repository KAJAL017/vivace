@extends('website.main.app')
@section('title', 'Home')
@section('website.content')
    @php
        $banners = DB::table('banners')
            ->where(['is_deleted' => 0])
            ->whereNotNull('index_number')
            ->orderBy('index_number', 'asc')
            ->get();
    @endphp
    <section class="section-space home-section-4 main-banner">
        <div class="custom-container container">
            <div class="row">
                <div class="col-12">
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($banners as $key => $banner)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                   <a href="{{ $banner->url }}">
                                    <img loading="lazy"  class="img-fluid w-100" src="{{ url('public/uploads/' . $banner->banner) }}"
                                    alt="Banner {{ $key + 1 }}" style="object-fit: cover;">
                                   </a>
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Add Bootstrap 5 scripts for the carousel to work -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>




    <section class="section-t-space second-banner">
        <div class="custom-container container">
            <div class="row">
                <div class="col-xxl-5 col-lg-8 offer-box-1">
                    <div class="row gy-4 ratio_45">
                        <div class="col-12">
                            @php
                                $banner_table_1 = DB::table('banner_table_1')->first();
                            @endphp
                            <div class="collection-banner p-left">
                                @if ($banner_table_1 && $banner_table_1->banner)
                                    <a href="{{ $banner_table_1->link }}">
                                        <img loading="lazy"  class="bg-img" src="{{ url('public/uploads') }}/{{ $banner_table_1->banner }}"
                                            alt="Banner Image" />
                                    </a>
                                @else
                                    <p>No banner image available.</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-12">
                            @php
                                $banner_table_2 = DB::table('banner_table_2')->first();
                            @endphp
                            <div class="collection-banner p-right">
                                @if ($banner_table_2 && $banner_table_2->banner)
                                    <a href="{{ $banner_table_2->link }}">
                                        <img loading="lazy"  class="bg-img" src="{{ url('public/uploads') }}/{{ $banner_table_2->banner }}"
                                            alt="Banner Image" />
                                    </a>
                                @else
                                    <p>No banner image available.</p> <!-- Or show a placeholder image -->
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xxl-3 col-4 d-none d-lg-block">
                    <div class="special-offer-slider">
                        <h4>Special Offer</h4>
                        <div class="swiper special-offer-slide">
                            <div class="swiper-wrapper trending-products">
                                @foreach ($special_products as $product)
                                    <div class="swiper-slide product-box-3">
                                        <div class="img-wrapper">
                                            <div class="product-image ratio_apos"><a class="pro-first"
                                                    href="{{ route('view.product', [$product->slug]) }}">
                                                    <img  loading="lazy"  class="bg-img"
                                                        src="{{ path() }}/{{ Product_first_image($product->id) }}"
                                                        alt="product" /></a><a class="pro-sec"
                                                    href="{{ route('view.product', [$product->slug]) }}">
                                                    <img loading="lazy"  class="bg-img"
                                                        src="{{ path() }}/{{ get_second_image($product->id) }}"
                                                        alt="product" /></a></div>
                                        </div>
                                        <div class="product-detail">
                                            <a href="{{ route('view.product', [$product->slug]) }}">
                                                <h6>{{ $product->name }}</h6>
                                            </a>
                                            <p>₹{{ $product->price }}
                                                <del>₹{{ $product->mrp }}</del>
                                            </p>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>
                <div class="col-4 d-none d-xxl-block">
                    <div class="offer-banner-3 ratio1_3">
                        <a href="#">
                            @php
                                $banner_table_3 = DB::table('banner_table_3')->first();
                            @endphp

                            @if ($banner_table_3 && $banner_table_3->banner)
                                <a href="{{ $banner_table_3->link }}">
                                    <img loading="lazy"  class="bg-img" src="{{ url('public/uploads') }}/{{ $banner_table_3->banner }}"
                                        alt="Banner Image" />
                                </a>
                            @else
                                <p>No banner image available.</p> <!-- You can replace this with a placeholder image -->
                            @endif
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- end Banner & Offer Section -->

    @php
        $sub_categories = DB::table('sub_categories')
            ->where(['is_deleted' => 0])
            ->get();
    @endphp

    <section class="section-t-space">
        <div class="container-fluid fashion-images">
            <div class="swiper fashion-images-slide">
                <div class="swiper-wrapper ratio_square-2">
                    @foreach ($sub_categories as $category)
                    <div class="swiper-slide">
                        <div class="fashion-box">
                            <a href="{{ route('view.subcategories.collection', [$category->slug]) }}">
                                <img
                                    class="img-fluid"
                                    src="{{ url($category->image ?? 'public/5.png') }}"
                                    alt="{{ $category->name }}">
                            </a>
                        </div>
                        <h5>{{ $category->name }}</h5>
                    </div>
                @endforeach



                </div>
            </div>
        </div>
    </section>


    <section class="section-t-space">
        <div class="custom-container container">
            <div class="row align-items-center">
                <div class="col-xl-3 col-lg-4 col-12">
                    <div class="banner-content">
                        <h2>Explore Our New Collection<span> </span></h2>
                        <div class="link-hover-anim underline"><a
                                class="btn btn_underline link-strong link-strong-unhovered"
                                href="{{ route('collections') }}">View All Collections
                                <svg>
                                    <use href="{{ route('collections') }}"></use>
                                </svg></a><a class="btn btn_underline link-strong link-strong-hovered"
                                href="{{ route('collections') }}">View All Collections
                                <svg>
                                    <use href="{{ route('collections') }}"></use>
                                </svg></a></div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8 col-12">
                    <div class="row gy-4 ratio_square">
                        @foreach ($collections as $collection)
                            <div class="col-md-4 col-sm-6 col-12"><a class="banner mb-0 p-left"
                                    href="{{ route('collction.filter', [$collection->id]) }}">
                                    <img loading="lazy"  class="bg-img" src="{{ url('public/uploads') }}/{{ $collection->image_path }}"
                                        alt="banner-img">
                                    <div class="banner-contain w-auto">
                                        <h4>{{ $collection->name }}</h4>
                                    </div>
                                </a>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-b-space">
        <div class="custom-container container">
            <div class="swiper logo-slider">
                <div class="swiper-wrapper">
                    @foreach ($brands as $brand)
                        <div class="swiper-slide">
                            <a href="{{ route('filter.product.brand', [$brand->id]) }}">
                                <img loading="lazy"  src="{{ url('public/uploads') }}/{{ $brand->image }}" alt="logo"
                                    width="150px"></a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- PRODUCTS SECTION -->
    <section class="section-t-space">
        <div class="custom-container container product-contain">
            <div class="title">
                <h3>Our Clothing Products </h3>
                <svg>
                    <use href="#">
                    </use>
                </svg>
            </div>
            <div class="row trending-products">
                <div class="col-12">
                    <div class="theme-tab-1">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item" role="presentation"><a class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#features-products" role="tab" aria-controls="features-products"
                                    aria-selected="true">
                                    <h6>Featured</h6>
                                </a></li>
                            <li class="nav-item" role="presentation"><a class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#latest-products" role="tab" aria-controls="latest-products"
                                    aria-selected="false">
                                    <h6>Latest</h6>
                                </a></li>
                            <li class="nav-item" role="presentation"><a class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#seller-products" role="tab" aria-controls="seller-products"
                                    aria-selected="false">
                                    <h6>Best Seller </h6>
                                </a></li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-12 ratio_square">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="features-products" role="tabpanel"
                                    tabindex="0">
                                    <div class="row g-4" id="featured-products-container">
                                        @if ($featured_products->isNotEmpty())
                                            @foreach ($featured_products as $product)
                                                <div class="col-xxl-3 col-md-4 col-6" style="border-radius: 10px">
                                                    @include('website.pages.product.partials.product', [
                                                        'loadmore_product' => $product,
                                                    ])
                                                </div>
                                            @endforeach
                                            <div class="col-12 d-flex justify-content-center mt-4 mb-4">
                                                <button id="see-more-featured-products" class="btn btn-dark btn-lg "
                                                    style="background: transparent;border-radius:50px;color:black">See
                                                    More </button>
                                            </div>
                                        @else
                                            <h3>Product Not Available</h3>
                                        @endif
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="latest-products" role="tabpanel" tabindex="0">
                                    <div class="row g-4" id="latest-products-container">
                                        @if ($newarrival_products->isNotEmpty())
                                            @foreach ($newarrival_products as $product)
                                            <div class="col-xxl-3 col-md-4 col-6" style="border-radius: 10px">
                                                @include('website.pages.product.partials.product', [
                                                    'loadmore_product' => $product,
                                                ])
                                            </div>
                                            @endforeach
                                            <div class="col-12 d-flex justify-content-center mt-4 mb-4">
                                                <button id="see-more-latest-products" class="btn btn-dark btn-lg "
                                                    style="background: transparent;border-radius:50px;color:black">See
                                                    More </button>
                                            </div>
                                        @else
                                            <h3>Product Not Available</h3>
                                        @endif
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="seller-products" role="tabpanel" tabindex="0">
                                    <div class="row g-4" id="bestseller-products-container">
                                        @if ($BestSeller_products->isNotEmpty())
                                            @foreach ($BestSeller_products as $product)
                                            <div class="col-xxl-3 col-md-4 col-6" style="border-radius: 10px">
                                                @include('website.pages.product.partials.product', [
                                                    'loadmore_product' => $product,
                                                ])
                                            </div>
                                            @endforeach
                                            <div class="col-12 d-flex justify-content-center mt-4 mb-4">
                                                <button id="see-more-bestseller-products" class="btn btn-dark btn-lg "
                                                    style="background: transparent;border-radius:50px;color:black">See
                                                    More </button>
                                            </div>
                                        @else
                                            <h3>Product Not Available</h3>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end Product Section -->


    <!-- Brands SLider -->

    <!-- End Brands Slider -->
@endsection

@section('website.js')
    <script>
        let featuredPage = 1;


        function loadMoreFeautredProducts() {
            $.ajax({
                url: "{{ route('load.more.featured.products') }}",
                method: "GET",
                data: {
                    page: ++featuredPage
                },
                success: function(response) {
                    if (response.html) {
                        $('#featured-products-container').append(response.html);
                        $('#featured-products-container').append($('#see-more-featured-products').parent());
                        if (response.hasMore === false) {
                            $('#see-more-featured-products').parent().addClass('d-none');
                        }
                    }
                },
                error: function() {
                    alert('Something went wrong while loading more products.');
                }
            });
        }
        $('#see-more-featured-products').on('click', function() {
            loadMoreFeautredProducts();
        });
    </script>
    <script>
        let LatestPage = 1;

        function loadMoreLatestProducts() {
            $.ajax({
                url: "{{ route('load.more.latest.products') }}",
                method: "GET",
                data: {
                    page: ++LatestPage
                },
                success: function(response) {
                    if (response.html) {
                        $('#latest-products-container').append(response.html);
                        $('#latest-products-container').append($('#see-more-latest-products').parent());
                        if (response.hasMore === false) {
                            $('#see-more-latest-products').parent().addClass('d-none');
                        }
                    }
                },
                error: function() {
                    alert('Something went wrong while loading more products.');
                }
            });
        }
        $('#see-more-latest-products').on('click', function() {
            loadMoreLatestProducts();
        });
    </script>
  <script>
    let BestSeller = 1;
    function loadMoreBestSellerProducts() {
        $.ajax({
            url: "{{ route('load.more.seller.products') }}",
            method: "GET",
            data: {
                page: ++BestSeller
            },
            success: function(response) {
                if (response.html) {
                    $('#bestseller-products-container').append(response.html);
                }
                if (response.hasMore === false) {
                    $('#see-more-bestseller-products').parent().addClass('d-none');
                }
            },
            error: function() {
                alert('Something went wrong while loading more products.');
            }
        });
    }

    $('#see-more-bestseller-products').on('click', function() {
        loadMoreBestSellerProducts();
    });
</script>

@endsection
