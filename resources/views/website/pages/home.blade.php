@extends('website.main.app')
@section('title', 'Home')
@section('website.content')
    @php
        $banners = DB::table('banners')
            ->where(['is_deleted' => 0])
            ->where('is_active', 1)
            ->orderByRaw('index_number IS NULL ASC, index_number ASC')
            ->get();
    @endphp

    {{-- ===== HERO BANNER SLIDER ===== --}}
    <style>
        /* Full-bleed banner — viewport se bahar nikalo kisi bhi parent constraint se */
        .hero-banner-wrap {
            position: relative;
            width: 100vw;
            left: 50%;
            transform: translateX(-50%);
            overflow: hidden;
            line-height: 0; /* removes inline-block gap below image */
        }
        .hero-banner-wrap .carousel-item picture,
        .hero-banner-wrap .carousel-item img {
            width: 100%;
            display: block;
            height: auto;
            max-height: 650px;
            object-fit: cover;
            object-position: center center;
        }
        /* Prev/Next arrows — thoda bada aur visible */
        .hero-banner-wrap .carousel-control-prev,
        .hero-banner-wrap .carousel-control-next {
            width: 48px;
            height: 48px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0,0,0,0.35);
            border-radius: 50%;
            opacity: 1;
        }
        .hero-banner-wrap .carousel-control-prev { left: 16px; }
        .hero-banner-wrap .carousel-control-next { right: 16px; }

        /* Mobile: thodi chhoti height */
        @media (max-width: 767px) {
            .hero-banner-wrap .carousel-item picture,
            .hero-banner-wrap .carousel-item img {
                max-height: 260px;
            }
        }
        @media (min-width: 768px) and (max-width: 1023px) {
            .hero-banner-wrap .carousel-item picture,
            .hero-banner-wrap .carousel-item img {
                max-height: 420px;
            }
        }
    </style>

    <div class="hero-banner-wrap">
        <div id="heroBannerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">

            {{-- Indicators (dots) --}}
            @if($banners->count() > 1)
            <div class="carousel-indicators">
                @foreach($banners as $k => $b)
                    <button type="button"
                            data-bs-target="#heroBannerCarousel"
                            data-bs-slide-to="{{ $k }}"
                            class="{{ $k == 0 ? 'active' : '' }}"
                            aria-label="Slide {{ $k + 1 }}">
                    </button>
                @endforeach
            </div>
            @endif

            <div class="carousel-inner">
                @forelse($banners as $key => $banner)
                    @php
                        $hasImageKit = !empty($banner->imagekit_url);
                        $urlDesktop  = $banner->imagekit_url_desktop ?? null;
                        $urlTablet   = $banner->imagekit_url_tablet  ?? null;
                        $urlMobile   = $banner->imagekit_url_mobile  ?? null;
                        $urlOriginal = $hasImageKit
                            ? $banner->imagekit_url
                            : url('uploads/' . ltrim($banner->banner, '/'));
                        $useResponsive = $hasImageKit && $urlMobile && $urlTablet && $urlDesktop;
                    @endphp
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <a href="{{ $banner->url ?: '#' }}" style="display:block; line-height:0;">
                            @if($useResponsive)
                                {{-- ImageKit: browser device ke hisaab se sahi size + WebP choose karega --}}
                                <picture>
                                    <source media="(max-width: 767px)"  srcset="{{ $urlMobile }}"  type="image/webp">
                                    <source media="(max-width: 1023px)" srcset="{{ $urlTablet }}"  type="image/webp">
                                    <source                              srcset="{{ $urlDesktop }}" type="image/webp">
                                    <img src="{{ $urlDesktop }}"
                                         alt="Banner {{ $key + 1 }}"
                                         loading="{{ $key == 0 ? 'eager' : 'lazy' }}"
                                         fetchpriority="{{ $key == 0 ? 'high' : 'auto' }}">
                                </picture>
                            @else
                                {{-- Local fallback --}}
                                <img src="{{ $urlOriginal }}"
                                     alt="Banner {{ $key + 1 }}"
                                     loading="{{ $key == 0 ? 'eager' : 'lazy' }}">
                            @endif
                        </a>
                    </div>
                @empty
                    {{-- Koi banner nahi toh kuch nahi dikhao --}}
                @endforelse
            </div>

            @if($banners->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#heroBannerCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroBannerCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            @endif

        </div>
    </div>
    {{-- ===== END HERO BANNER ===== --}}




    {{-- ===== SHOP BY CATEGORY GRID ===== --}}
    <style>
        .category-grid-section {
            padding: 48px 0;
            background: #fff;
        }
        .category-grid-section .section-title {
            text-align: center;
            margin-bottom: 28px;
        }
        .category-grid-section .section-title h2 {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #1a1a1a;
            position: relative;
            display: inline-block;
            padding-bottom: 10px;
        }
        .category-grid-section .section-title h2::after {
            content: '';
            position: absolute;
            bottom: 0; left: 50%;
            transform: translateX(-50%);
            width: 50px; height: 3px;
            background: #1a1a1a;
            border-radius: 2px;
        }

        /* Container — same as header/footer */
        .cat-grid-wrap {
            width: 100%;
            padding-right: var(--bs-gutter-x, 0.75rem);
            padding-left:  var(--bs-gutter-x, 0.75rem);
            margin-right: auto;
            margin-left:  auto;
        }
        /* Match Bootstrap container breakpoints */
        @media (min-width: 576px)  { .cat-grid-wrap { max-width: 540px; } }
        @media (min-width: 768px)  { .cat-grid-wrap { max-width: 720px; } }
        @media (min-width: 992px)  { .cat-grid-wrap { max-width: 960px; } }
        @media (min-width: 1200px) { .cat-grid-wrap { max-width: 1140px; } }
        @media (min-width: 1400px) { .cat-grid-wrap { max-width: 1320px; } }
        @media (min-width: 1500px) { .cat-grid-wrap { max-width: 1440px; } }
        @media (min-width: 1700px) { .cat-grid-wrap { max-width: 1670px; } }

        /* 3×3 grid */
        .cat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        /* Tablet: 3 columns still */
        @media (max-width: 991px) {
            .cat-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
            }
        }

        /* Mobile: 2 columns */
        @media (max-width: 575px) {
            .cat-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 6px;
            }
        }

        /* Each card — height auto, no crop */
        .cat-card {
            position: relative;
            overflow: hidden;
            display: block;
            background: #f5f5f5;
            text-decoration: none;
            border-radius: 6px;
        }
        .cat-card picture,
        .cat-card img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Dark gradient overlay — bottom pe */
        .cat-card::after {
            content: '';
            position: absolute;
            left: 0; right: 0; bottom: 0;
            height: 50%;
            background: linear-gradient(
                to bottom,
                transparent 0%,
                rgba(0,0,0,0.65) 100%
            );
            pointer-events: none;
            border-radius: 0 0 6px 6px;
        }

        /* Category name */
        .cat-card .cat-name {
            position: absolute;
            bottom: 14px;
            left: 0; right: 0;
            text-align: center;
            color: #fff;
            font-size: 0.85rem;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            z-index: 2;
            text-shadow: 0 2px 6px rgba(0,0,0,0.6);
            padding: 0 8px;
        }

        @media (max-width: 575px) {
            .cat-card .cat-name {
                font-size: 0.7rem;
                letter-spacing: 1px;
                bottom: 10px;
            }
        }
    </style>

    <div class="category-grid-section">
        <div class="section-title">
            <h2>Shop By Category</h2>
        </div>
        @php
            $homeCategories = DB::table('categories')
                ->where('is_deleted', 0)
                ->where('is_active', 1)
                ->get();
        @endphp
        @if($homeCategories->count() > 0)
        <div class="cat-grid-wrap custom-container container">
            <div class="cat-grid">
                @foreach($homeCategories as $cat)
                    <a class="cat-card" href="{{ route('filter.product.category', $cat->id) }}">
                        @php
                            $hasCatIK   = !empty($cat->imagekit_url_desktop);
                            $catDesktop = $cat->imagekit_url_desktop ?? null;
                            $catTablet  = $cat->imagekit_url_tablet  ?? null;
                            $catMobile  = $cat->imagekit_url_mobile  ?? null;
                            $catLocal   = $cat->image
                                ? upload_url($cat->image)
                                : url('public/5.png');
                        @endphp
                        @if($hasCatIK && $catMobile && $catTablet)
                            <picture>
                                <source media="(max-width: 575px)"  srcset="{{ $catMobile }}"  type="image/webp">
                                <source media="(max-width: 991px)"  srcset="{{ $catTablet }}"  type="image/webp">
                                <source                              srcset="{{ $catDesktop }}" type="image/webp">
                                <img src="{{ $catDesktop }}" alt="{{ $cat->name }}" loading="lazy">
                            </picture>
                        @else
                            <img src="{{ $catLocal }}" alt="{{ $cat->name }}" loading="lazy">
                        @endif
                        <span class="cat-name">{{ $cat->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    {{-- ===== END SHOP BY CATEGORY ===== --}}


    {{-- ===== COLLECTIONS SLIDER ===== --}}
    <style>
        .collections-section {
            padding: 48px 0 40px;
            background: #fff;
        }
        .collections-section .sec-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .collections-section .sec-head h2 {
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #1a1a1a;
            margin: 0;
            position: relative;
            padding-bottom: 8px;
        }
        .collections-section .sec-head h2::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 40px; height: 3px;
            background: #1a1a1a;
            border-radius: 2px;
        }
        .collections-section .sec-head a {
            font-size: 0.85rem;
            font-weight: 600;
            color: #1a1a1a;
            text-decoration: none;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #1a1a1a;
            padding-bottom: 2px;
            white-space: nowrap;
        }
        .collections-section .sec-head a:hover {
            opacity: 0.6;
        }

        /* Scroll wrapper */
        .col-slider-outer {
            position: relative;
        }
        .col-slider-track {
            display: flex;
            gap: 16px;
            overflow-x: auto;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;       /* Firefox */
            padding-bottom: 4px;
        }
        .col-slider-track::-webkit-scrollbar { display: none; }

        /* Each collection card */
        .col-card {
            flex: 0 0 calc(25% - 12px);   /* 4 visible on desktop */
            min-width: 260px;
            text-decoration: none;
            color: #1a1a1a;
        }
        @media (max-width: 991px) {
            .col-card { flex: 0 0 calc(33.33% - 11px); min-width: 200px; }
        }
        @media (max-width: 575px) {
            .col-card { flex: 0 0 calc(50% - 8px); min-width: 150px; }
            .col-slider-track { gap: 10px; }
        }

        .col-card-img {
            width: 100%;
            aspect-ratio: 3 / 4;
            overflow: hidden;
            background: #f0f0f0;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .col-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top center;
            display: block;
        }
        .col-card-name {
            font-size: 0.82rem;
            font-weight: 600;
            text-align: center;
            letter-spacing: 0.3px;
            color: #1a1a1a;
            line-height: 1.3;
        }

        /* Prev / Next arrow buttons */
        .col-slider-btn {
            position: absolute;
            top: 40%;
            transform: translateY(-50%);
            width: 36px; height: 36px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            z-index: 5;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
            transition: background 0.2s;
        }
        .col-slider-btn:hover { background: #f5f5f5; }
        .col-slider-btn.prev { left: -18px; }
        .col-slider-btn.next { right: -18px; }
        .col-slider-btn svg { width: 16px; height: 16px; }
        @media (max-width: 575px) {
            .col-slider-btn { display: none; }
        }
    </style>

    @php
        $sliderCollections = DB::table('collections')
            ->where('is_deleted', 0)
            ->orderBy('id', 'DESC')
            ->get();
    @endphp

    @if($sliderCollections->count() > 0)
    <div class="collections-section">
        <div class="custom-container container">
            <div class="sec-head">
                <h2>Our Collections</h2>
                <a href="{{ route('collections') }}">View All →</a>
            </div>
            <div class="col-slider-outer">
                {{-- Prev button --}}
                <button class="col-slider-btn prev" id="colPrev" aria-label="Previous">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>

                <div class="col-slider-track" id="colTrack">
                    @foreach($sliderCollections as $col)
                        <a class="col-card" href="{{ route('collction.filter', $col->id) }}">
                            <div class="col-card-img">
                                @php
                                    $colImg = !empty($col->imagekit_url_desktop)
                                        ? $col->imagekit_url_desktop
                                        : (!empty($col->imagekit_url)
                                            ? $col->imagekit_url
                                            : ($col->image_path ? url('uploads/' . $col->image_path) : url('public/5.png')));
                                @endphp
                                <img src="{{ $colImg }}"
                                     alt="{{ $col->name }}"
                                     loading="lazy"
                                     onerror="this.src='{{ url('public/5.png') }}'">
                            </div>
                            <div class="col-card-name">{{ $col->name }}</div>
                        </a>
                    @endforeach
                </div>

                {{-- Next button --}}
                <button class="col-slider-btn next" id="colNext" aria-label="Next">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        (function(){
            var track = document.getElementById('colTrack');
            var btnPrev = document.getElementById('colPrev');
            var btnNext = document.getElementById('colNext');
            if(!track) return;

            var scrollAmt = function(){ return track.offsetWidth * 0.75; };

            btnNext && btnNext.addEventListener('click', function(){
                track.scrollBy({ left: scrollAmt(), behavior: 'smooth' });
            });
            btnPrev && btnPrev.addEventListener('click', function(){
                track.scrollBy({ left: -scrollAmt(), behavior: 'smooth' });
            });
        })();
    </script>
    @endif
    {{-- ===== END COLLECTIONS SLIDER ===== --}}

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

    {{-- ===== WATCH & SHOP — REELS SECTION ===== --}}
    @php
        $homeReels = DB::table('reels')
            ->leftJoin('products', 'products.id', '=', 'reels.product_id')
            ->leftJoin(
                DB::raw('(SELECT MIN(id) as id, product_id FROM product_attributes GROUP BY product_id) as pa_min'),
                'products.id', '=', 'pa_min.product_id'
            )
            ->leftJoin('product_attributes', 'product_attributes.id', '=', 'pa_min.id')
            ->leftJoin(
                DB::raw('(SELECT MIN(id) as id, product_id FROM product_images GROUP BY product_id) as pi_min'),
                'products.id', '=', 'pi_min.product_id'
            )
            ->leftJoin('product_images', 'product_images.id', '=', 'pi_min.id')
            ->where('reels.is_active', 1)
            ->orderBy('reels.sort_order', 'asc')
            ->orderBy('reels.id', 'desc')
            ->select(
                'reels.id',
                'reels.reel_url',
                'reels.video_url',
                'reels.views',
                'reels.platform',
                'products.name as product_name',
                'products.slug as product_slug',
                'products.first_image as product_first_image',
                'product_attributes.price',
                'product_attributes.mrp',
                'product_images.file_path as product_image',
                'product_images.imagekit_url as product_image_ik'
            )
            ->get();
    @endphp

    @if($homeReels->count() > 0)
    <style>
        .watch-shop-section {
            padding: 48px 0 40px;
            background: #fff;
        }
        .watch-shop-section .ws-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .watch-shop-section .ws-head h2 {
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #1a1a1a;
            margin: 0;
            padding-bottom: 8px;
            position: relative;
        }
        .watch-shop-section .ws-head h2::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 40px; height: 3px;
            background: #1a1a1a;
            border-radius: 2px;
        }

        /* Scroll track */
        .ws-track-outer { position: relative; }
        .ws-track {
            display: flex;
            gap: 14px;
            overflow-x: auto;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            padding-bottom: 4px;
        }
        .ws-track::-webkit-scrollbar { display: none; }

        /* Each reel card */
        .ws-card {
            flex: 0 0 calc(20% - 12px);
            min-width: 180px;
            text-decoration: none;
            color: #1a1a1a;
            display: flex;
            flex-direction: column;
        }
        @media (max-width: 991px) { .ws-card { flex: 0 0 calc(33.33% - 10px); min-width: 160px; } }
        @media (max-width: 575px) { .ws-card { flex: 0 0 calc(50% - 8px); min-width: 140px; } .ws-track { gap: 10px; } }

        /* Video embed container */
        .ws-thumb {
            position: relative;
            width: 100%;
            aspect-ratio: 9 / 16;
            border-radius: 12px;
            overflow: hidden;
            background: #111;
            margin-bottom: 10px;
        }
        .ws-thumb iframe {
            width: 300%; height: 300%;
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            border: 0;
            pointer-events: none;
        }
        /* For non-instagram iframes — normal size */
        .ws-thumb iframe.normal-embed {
            width: 100%; height: 100%;
            top: 0; left: 0;
            transform: none;
        }
        /* Click overlay — product pe redirect */
        .ws-thumb .ws-click-overlay {
            position: absolute;
            inset: 0;
            z-index: 3;
            cursor: pointer;
            background: transparent;
        }
        /* Views badge */
        .ws-thumb .views-badge {
            position: absolute;
            bottom: 8px; left: 8px;
            background: rgba(0,0,0,0.55);
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 10px;
            z-index: 4;
            pointer-events: none;
        }

        /* Product info below */
        .ws-product {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 2px;
        }
        .ws-product-img {
            width: 36px; height: 36px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
            border: 1px solid #e9ecef;
        }
        .ws-product-info { flex: 1; min-width: 0; }
        .ws-product-name {
            font-size: 0.78rem;
            font-weight: 600;
            color: #1a1a1a;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.3;
        }
        .ws-product-price {
            font-size: 0.78rem;
            color: #555;
            margin-top: 2px;
        }
        .ws-product-price .price { font-weight: 700; color: #1a1a1a; }
        .ws-product-price .mrp   { text-decoration: line-through; color: #aaa; margin-left: 4px; font-size: 0.72rem; }

        /* Prev/Next */
        .ws-btn {
            position: absolute;
            top: 40%; transform: translateY(-50%);
            width: 36px; height: 36px;
            background: #fff; border: 1px solid #ddd;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; z-index: 5;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
            transition: background 0.2s;
        }
        .ws-btn:hover { background: #f5f5f5; }
        .ws-btn.prev { left: -18px; }
        .ws-btn.next { right: -18px; }
        .ws-btn svg { width: 16px; height: 16px; }
        @media (max-width: 575px) { .ws-btn { display: none; } }
    </style>

    <div class="watch-shop-section">
        <div class="custom-container container">
            <div class="ws-head">
                <h2>Watch &amp; Shop</h2>
            </div>
            <div class="ws-track-outer">
                <button class="ws-btn prev" id="wsPrev">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>

                <div class="ws-track" id="wsTrack">
                    @foreach($homeReels as $reel)
                    @php
                        $url = $reel->video_url ?? $reel->reel_url ?? '';
                        $embedUrl    = null;
                        $isDirectMp4 = false;
                        $isInstagram = false;

                        // Direct video URL (ImageKit stored or MP4)
                        if (!empty($reel->video_url) || preg_match('/\.(mp4|webm|ogg|mov)(\?.*)?$/i', $url)) {
                            $isDirectMp4 = true;
                        }
                        // Google Drive
                        elseif (str_contains($url, 'drive.google.com')) {
                            preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $url, $m);
                            if (!empty($m[1])) {
                                $embedUrl = 'https://drive.google.com/file/d/' . $m[1] . '/preview?autoplay=1';
                            }
                        }
                        // YouTube
                        elseif (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) {
                            preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $m);
                            if (!empty($m[1])) {
                                $embedUrl = 'https://www.youtube.com/embed/' . $m[1]
                                    . '?autoplay=1&mute=1&loop=1&playlist=' . $m[1]
                                    . '&controls=0&rel=0&playsinline=1&modestbranding=1';
                            }
                        }

                        $productUrl = $reel->product_slug
                            ? route('view.product', $reel->product_slug)
                            : null;

                        $productImg = !empty($reel->product_image_ik)
                            ? $reel->product_image_ik
                            : (!empty($reel->product_image)
                                ? url('uploads/' . $reel->product_image)
                                : null);
                    @endphp

                    <div class="ws-card">
                        <div class="ws-thumb">
                            @if($isDirectMp4 && !empty($url))
                                <video src="{{ $url }}"
                                    autoplay muted loop playsinline
                                    style="width:100%;height:100%;position:absolute;top:0;left:0;object-fit:cover;">
                                </video>
                            @elseif($embedUrl)
                                <iframe src="{{ $embedUrl }}"
                                    class="normal-embed"
                                    frameborder="0"
                                    allow="autoplay; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen scrolling="no" loading="lazy">
                                </iframe>
                            @else
                                <div style="width:100%;height:100%;background:#222;display:flex;align-items:center;justify-content:center;">
                                    <iconify-icon icon="mdi:play-circle" style="font-size:3rem;color:white;opacity:0.7;"></iconify-icon>
                                </div>
                            @endif

                            @if($productUrl)
                            <div class="ws-click-overlay"
                                 onclick="window.location.href='{{ $productUrl }}'"
                                 title="{{ $reel->product_name }}">
                            </div>
                            @endif

                            @if($reel->views > 0)
                            <span class="views-badge">{{ number_format($reel->views) }} Views</span>
                            @endif
                        </div>

                        {{-- Product info below --}}
                        @if($reel->product_name && $productUrl)
                        <a href="{{ $productUrl }}" class="ws-product" style="text-decoration:none;">
                            @if($productImg)
                            <img src="{{ $productImg }}" alt="" class="ws-product-img">
                            @endif
                            <div class="ws-product-info">
                                <div class="ws-product-name">{{ $reel->product_name }}</div>
                                @if($reel->price)
                                <div class="ws-product-price">
                                    <span class="price">₹ {{ number_format($reel->price) }}</span>
                                    @if($reel->mrp && $reel->mrp > $reel->price)
                                        <span class="mrp">₹ {{ number_format($reel->mrp) }}</span>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </a>
                        @endif
                    </div>
                    @endforeach
                </div>

                <button class="ws-btn next" id="wsNext">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>
            </div>
        </div>
    </div>

    <script>
    (function(){
        var track = document.getElementById('wsTrack');
        var prev  = document.getElementById('wsPrev');
        var next  = document.getElementById('wsNext');
        if(!track) return;
        var amt = function(){ return track.offsetWidth * 0.75; };
        next && next.addEventListener('click', function(){ track.scrollBy({ left: amt(), behavior:'smooth' }); });
        prev && prev.addEventListener('click', function(){ track.scrollBy({ left: -amt(), behavior:'smooth' }); });
    })();
    </script>
    @endif
    {{-- ===== END WATCH & SHOP ===== --}}


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
