<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Vivace Collections">
    <meta name="keywords"
        content="traditional clothing, sarees, lehengas, ethnic wear, kurtas, Indian clothing, Vivace Collections, traditional fashion, handcrafted clothing, Indian ethnic wear">
    <meta name="robots" content="index, follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Vivace Collections">
    <link rel="icon" href="{{ path() }}/favicon-32x32.png" type="image/x-icon">
    <link rel="shortcut icon" href="{{ path() }}/favicon-32x32.png" type="image/x-icon">
    <link rel="manifest" href="{{ path() }}/manifest.json">
    <title> @yield('title') | Vivace Collections </title>
    <!-- Favicon icon-->
    <link rel="icon" href="{{ path() }}/favicon-32x32.png" type="image/x-icon">
    <link rel="shortcut icon" href="{{ path() }}/favicon-32x32.png" type="image/x-icon">
    <!-- Google Font Outfit-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&amp;display=swap" rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{ website_assets() }}/assets/css/vendors/fontawesome.css">
    <!-- Iconsax icon-->
    <link rel="stylesheet" type="text/css" href="{{ website_assets() }}/assets/css/vendors/iconsax.css">
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" id="rtl-link"
        href="{{ website_assets() }}/assets/css/vendors/bootstrap.css">
    <link rel="stylesheet" type="text/css"
        href="{{ website_assets() }}/assets/css/vendors/swiper-slider/swiper-bundle.min.css">
    <link rel="stylesheet" type="text/css" href="{{ website_assets() }}/assets/css/vendors/toastify.css">
    <link rel="stylesheet" type="text/css" href="{{ website_assets() }}/assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        /* Spinner container */
        #spinner {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }

        /* Spinner animation */
        .spinner {
            border: 8px solid #f3f3f3;
            /* Light grey */
            border-top: 8px solid #3498db;
            /* Blue */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }

        /* Keyframes for spinner animation */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            /* Translucent white */
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            pointer-events: none;
            /* Disable interactions */
        }

        .spinner {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #main-content {
            opacity: 0;
            /* Initially hidden */
        }
    </style>
    @yield('website-css')

</head>

<body class="layout-4 skeleton_body" id="skeleton_body">


    <div class="tap-top">
        <div><i class="fa-solid fa-angle-up"></i></div>
    </div><span class="cursor"><span class="cursor-move-inner"><span class="cursor-inner"></span></span><span
            class="cursor-move-outer"><span class="cursor-outer"></span></span></span>
    <div id="loading-overlay">
        <!-- Spinner element -->
        <div class="spinner"></div>
    </div>

    <div id="spinner">
        <div class="spinner"></div>
    </div>

    <header>
        <div class="top_header">
            <p>Free Coupe Code: Summer Sale On Selected items Use:<span>NEW 26</span><a href="#"> SHOP NOW</a>
            </p>
        </div>
        <div class="custom-container container header-1">
            <div class="row">
                <div class="col-12 p-0">
                    <div class="mobile-fix-option">
                        <ul>
                            <li> <a href="{{ route('website.home') }}"><i class="iconsax"
                                        data-icon="home-1"></i>Home</a></li>
                            <li><a href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop"
                                    aria-controls="offcanvasTop"><i class="iconsax"
                                        data-icon="search-normal-2"></i>Search</a>
                            </li>
                            <li class="shopping-cart"> <a href="{{ route('cart') }}"><i class="iconsax"
                                        data-icon="shopping-cart"></i>Cart</a></li>
                            <li><a href="{{ route('wishlist') }}"><i class="iconsax" data-icon="heart"></i>My
                                    Wish</a></li>
                            @php
                                $islogin = getUserData();
                            @endphp
                            @if ($islogin)
                                <li> <a href="{{ route('account') }}"><i class="iconsax"
                                            data-icon="user-2"></i>Account</a></li>
                            @else
                                <li> <a href="{{ route('login') }}"><i class="iconsax"
                                            data-icon="user-2"></i>Account</a></li>
                            @endif

                        </ul>
                    </div>
                    <div class="offcanvas offcanvas-start" id="staticBackdrop" data-bs-backdrop="static"
                        tabindex="-1" aria-labelledby="staticBackdropLabel">
                        <div class="offcanvas-header">
                            <h3 class="offcanvas-title" id="staticBackdropLabel">Offcanvas</h3>
                            <button class="btn-close" type="button" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div></div>I will not close if you click outside of me.
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <!-- mobile Logo -->
                    <div class="main-menu"> <a class="brand-logo" href="{{ route('website.home') }}"
                            style="width: 340px"> <img class="img-fluid for-light" width="340px"
                                src="{{ url('public') }}/vivaceLogo (1).png" alt="logo"><img
                                class="img-fluid for-dark"
                                src="{{ website_assets() }}/assets/images/logo/logo-white-4.png" alt="logo"></a>

                        @php
                            $homecategories = DB::table('categories')
                                ->where('is_deleted', 0)
                                ->where('show_in_top_bar', 1)
                                ->get();

                            $homecategories->map(function ($homecategories) {
                                $homecategories->subcategories = DB::table('sub_categories')
                                    ->where('is_deleted', 0)
                                    ->where('category_id', $homecategories->id)
                                    ->get();
                                return $homecategories;
                            });

                        @endphp
                        <style>
                            /* Hide submenu initially */
                            .nav-submenu {
                                display: none;
                                position: absolute;
                                background-color: white;
                                list-style: none;
                                padding: 0;
                                margin: 0;
                                border: 1px solid #ddd;
                                z-index: 1000;
                            }

                            /* Position the submenu below the parent */
                            .nav-menu li {
                                position: relative;
                            }

                            /* Show submenu on hover */
                            .nav-menu li:hover>.nav-submenu {
                                display: block;
                            }

                            /* Style submenu items */
                            .nav-submenu li {
                                padding: 10px;
                                border-bottom: 1px solid #ddd;
                            }

                            /* Last item without border */
                            .nav-submenu li:last-child {
                                border-bottom: none;
                            }

                            /* Style for nav link */
                            .nav-link {
                                text-decoration: none;
                                display: flex;
                                align-items: center;
                                justify-content: space-between;
                            }
                        </style>


                        <nav id="main-nav">
                            <ul class="nav-menu sm-horizontal theme-scrollbar" id="sm-horizontal">
                                <li class="mobile-back" id="mobile-back">Back <i class="fa-solid fa-angle-right ps-2"
                                        aria-hidden="true"></i>
                                </li>
                                @foreach ($homecategories as $category)
                                    <li> <a class="nav-link" href="#">{{ $category->name }}<span> <i
                                                    class="fa-solid fa-angle-down"></i></span></a>
                                        @php
                                            $chunks = $category->subcategories->chunk(4);
                                        @endphp
                                        @foreach ($chunks as $chunk)
                                            <ul class="nav-submenu">
                                                @foreach ($chunk as $subcategory)
                                                    <li> <a
                                                            href="{{ route('view.subcategories.collection', [$subcategory->slug]) }}">{{ $subcategory->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endforeach
                                    </li>
                                @endforeach
                                <li>
                                    <a class="nav-link" href="{{ route('view.discounted.product') }}">Discounted </a>
                                </li>
                                <li>
                                    <a class="nav-link" href="{{ route('view.brands') }}">Brands</a>
                                </li>
                            </ul>
                        </nav>




                        <div class="sub_header">
                            <div class="toggle-nav" id="toggle-nav"><i
                                    class="fa-solid fa-bars-staggered sidebar-bar"></i></div>
                            <ul class="justify-content-end">
                                <li>
                                    <button href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop"
                                        aria-controls="offcanvasTop"><i class="iconsax"
                                            data-icon="search-normal-2"></i></button>
                                </li>
                                <li> <a href="{{ route('wishlist') }}"><i class="iconsax" data-icon="heart"></i></a>
                                </li>
                                <li class="onhover-div"><a href="#"><i class="iconsax"
                                            data-icon="user-2"></i></a>

                                    @if (Session::has('user_login') && Session::get('user_login') === true)
                                        <div class="onhover-show-div user">
                                            <ul>
                                                <li><a href="{{ route('account') }}">Profile</a></li>
                                                <li><a href="{{ route('logout') }}">Logout</a></li>
                                            </ul>
                                        </div>
                                    @else
                                        <div class="onhover-show-div user">
                                            <ul>
                                                <li><a href="{{ route('login') }}">Login</a></li>
                                                <li><a href="{{ route('website.auth.register') }}">Register</a></li>
                                            </ul>
                                        </div>
                                    @endif
                                </li>
                                @php
                                    $countCartData = getCartData();
                                @endphp
                                <li class="onhover-div shopping-cart"> <a class="p-0" href="{{ route('cart') }}">
                                        <div class="shoping-prize"><i class="iconsax pe-2" data-icon="basket-2">
                                            </i>{{ count($countCartData) }} items</div>
                                    </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- HERO SECTION ----------------------------------------------->


    @yield('website.content')



    <!-- footer start -->
    <footer class="layout-light footer-2">
        <section class="section-b-space footer-1">
            <div class="custom-container container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="footer-content">
                            <div class="footer-logo">
                                <a class="brand-logo" href="{{ route('website.home') }}" style="width: 340px">
                                    <img class="img-fluid for-light" src="{{ url('public') }}/vivaceLogo (1).png"
                                        alt="logo" width="340px">
                                    <img class="img-fluid for-dark" src="{{ url('public') }}/vivaceLogo (1).png"
                                        alt="logo"></a>
                            </div>
                            <ul>
                                <li> <i class="iconsax" data-icon="location"></i>
                                    <h6>Vivace Collection Chotta Bazaar Near Sheikhul Alam Hospital Karanagar, Srinagar,
                                        Jammu and Kashmir 190010</h6>
                                </li>
                                <li> <i class="iconsax" data-icon="phone-calling"></i>
                                    <h6> +91 78895 38626</h6>
                                </li>
                                <li> <i class="iconsax" data-icon="mail"></i>
                                    <h6>Info@vivacecollections</h6>
                                </li>
                            </ul>
                            <ul class="social-icon">
                                <li> <a href="https://www.facebook.com/profile.php?id=100063795769574"
                                        target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                                </li>
                                <li> <a href="https://g.co/kgs/LdtP5Q7" target="_blank"><i
                                            class="fa-brands fa-google"></i></a></li>
                                <li> <a href="https://www.instagram.com/vivace_collections?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="
                                        target="_blank"><i class="fa-brands fa-instagram"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col offset-xl-1">
                        <div class="footer-content">
                            <div>
                                <div class="footer-title d-md-block">
                                    <h5>Quick Links</h5>
                                    <ul class="footer-details ">
                                        <li> <a class="nav" href="{{ route('website.home') }}">Home</a></li>
                                        <li> <a class="nav" href="{{ route('login') }}">Shop</a></li>
                                        <li> <a class="nav" href="{{ route('login') }}">About Us</a></li>
                                        <li> <a class="nav" href="{{ route('contact') }}">Contact</a></li>


                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="footer-content">
                            @php
                                $sub_categories = DB::table('sub_categories')
                                    ->where(['is_deleted' => 0])
                                    ->orderBy('id', 'DESC')
                                    ->limit(6)
                                    ->get();
                            @endphp
                            <div>
                                <div class="footer-title d-md-block">
                                    <h5>Categories</h5>
                                    <ul class="footer-details ">
                                        @foreach ($sub_categories as $category)
                                            <li> <a class="nav"
                                                    href="{{ route('filter.product.sub_category', [$category->slug]) }}">{{ $category->name }}</a>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="footer-content">
                            <div>
                                <div class="footer-title d-md-block">
                                    <h5>Get Help</h5>
                                    <ul class="footer-details ">
                                        <li> <a class="nav" href="{{ route('website.home') }}">Your Orders</a>
                                        </li>
                                        <li> <a class="nav" href="{{ route('contact') }}">Your Account</a></li>
                                        <li> <a class="nav" href="{{ route('privacy-Policy') }}">Track Orders</a>
                                        </li>
                                        <li> <a class="nav" href="{{ route('refund') }}">Your Wishlist</a>
                                        <li> <a class="nav" href="{{ route('terms') }}">Shopping FAQs</a>
                                        </li>
                                        <li> <a class="nav" href="{{ route('shipping') }}">Shipping Policy</a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="footer-content">
                            <div>
                                <div class="footer-title d-md-block">
                                    <h5>My Account</h5>
                                    <ul class="footer-details ">
                                        <li> <a class="nav" href="{{ route('website.home') }}">My Account</a></li>
                                        <li> <a class="nav" href="{{ route('contact') }}">Login/Register</a></li>
                                        <li> <a class="nav" href="{{ route('privacy-Policy') }}">Cart</a></li>
                                        <li> <a class="nav" href="{{ route('refund') }}">Order History</a>
                                        <li> <a class="nav" href="{{ route('terms') }}">Delivery FAQs</a>
                                        </li>
                                        <li class="social-app mb-0">
                                            <h5 class="mb-2 text-content">Download App :</h5>
                                            <ul class="installPWA">
                                                <li class="mb-0 ">
                                                    <a href="javascript:void(0)"  >
                                                        <img src="https://themes.pixelstrap.com/fastkart/assets/images/playstore.svg"
                                                            class="blur-up lazyloaded" alt="Download from Play Store">
                                                    </a>
                                                </li>
                                                <li class="mb-0">
                                                    <a href="javascript:void(0)"  >
                                                        <img src="https://themes.pixelstrap.com/fastkart/assets/images/appstore.svg"
                                                            class="blur-up lazyloaded" alt="Download from App Store">
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>


                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="sub-footer">
            <div class="custom-container container">
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <div class="footer-end">
                            <h6>© Copyright All Rights Reserved | Vivace</h6>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <div class="payment-card-bottom">
                            <ul>
                                <li> <img src="{{ website_assets() }}/assets/images/footer/discover.png"
                                        alt=""></li>
                                <li> <img src="{{ website_assets() }}/assets/images/footer/american.png"
                                        alt=""></li>
                                <li> <img src="{{ website_assets() }}/assets/images/footer/master.png"
                                        alt=""></li>
                                <li> <img src="{{ website_assets() }}/assets/images/footer/giro.png" alt="">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->




    {{-- <div class="wrapper">
        <div class="title-box"> <img src="{{ website_assets() }}/assets/images/other-img/cookie.png" alt="">
            <h3>Cookies Consent</h3>
        </div>
        <div class="info">
            <p>We use cookies to improve our site and your shopping experience. By continuing to browse our site you
                accept our cookie policy.</p>
        </div>
        <div class="buttons">
            <button class="button btn btn_outline sm" id="acceptBtn">Accept</button>
            <button class="button btn btn_black sm">Decline</button>
        </div>
    </div> --}}
    <div class="offcanvas offcanvas-top search-details" id="offcanvasTop" tabindex="-1"
        aria-labelledby="offcanvasTopLabel">
        <div class="offcanvas-header">
            <button class="btn-close" type="button" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="offcanvas-body theme-scrollbar">
            <div class="container">
                <h3>What are you trying to find?</h3>
                <div class="search-box">
                    <input type="search" id="search-input" name="search" placeholder="I'm looking for…">
                    <i class="iconsax" data-icon="search-normal-2" id="search-icon" style="cursor: pointer;"></i>
                </div>
                <h4>Search By Tags</h4>
                @php
                    $tags = DB::table('tags')->where('is_deleted', 0)->orderBy('id', 'DESC')->get();
                @endphp
                <ul class="rapid-search">
                    @foreach ($tags as $tag)
                        <li>
                            <a href="javascript:void(0);" class="tag-filter" data-tag="{{ $tag->name }}">
                                <i class="iconsax" data-icon="search-normal-2"></i>#{{ $tag->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <h4>Search By Categories</h4>
                @php
                    $categories = DB::table('categories')->where('is_deleted', 0)->orderBy('id', 'DESC')->get();
                @endphp
                <ul class="rapid-search">
                    @foreach ($categories as $category)
                        <li>
                            <a href="javascript:void(0);" class="category-filter"
                                data-category="{{ $category->id }}">
                                <i class="iconsax" data-icon="search-normal-2"></i>{{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <h4>Search By Sub Categories</h4>
                @php
                    $sub_categories = DB::table('sub_categories')->where('is_deleted', 0)->orderBy('id', 'DESC')->get();
                @endphp
                <ul class="rapid-search">
                    @foreach ($sub_categories as $sub_category)
                        <li>
                            <a href="javascript:void(0);" class="sub_category-filter"
                                data-category="{{ $sub_category->id }}">
                                <i class="iconsax" data-icon="search-normal-2"></i>{{ $sub_category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <h4>Search By Brands</h4>
                @php
                    $brands = DB::table('brands')->where('is_deleted', 0)->orderBy('id', 'DESC')->get();
                @endphp
                <ul class="rapid-search">
                    @foreach ($brands as $brand)
                        <li>
                            <a href="javascript:void(0);" class="brand-filter"
                                data-brand="{{ $brand->id }}">
                                <i class="iconsax" data-icon="search-normal-2"></i>{{ $brand->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <h4>Search By Collections</h4>
                @php
                    $collections = DB::table('collections')->where('is_deleted', 0)->orderBy('id', 'DESC')->get();
                @endphp
                <ul class="rapid-search">
                    @foreach ($collections as $collectio)
                        <li>
                            <a href="javascript:void(0);" class="collection-filter"
                                data-collection="{{ $collectio->id }}">
                                <i class="iconsax" data-icon="search-normal-2"></i>{{ $collectio->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>



    <!-- Bootstrap js-->
    <script src="{{ website_assets() }}/assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- iconsax js -->
    <script src="{{ website_assets() }}/assets/js/iconsax.js"></script>
    <!-- cursor js-->
    <script src="{{ website_assets() }}/assets/js/stats.min.js"></script>



    {{-- <script src="{{ website_assets() }}/assets/js/cursor.js"></script> --}}
    <script src="{{ website_assets() }}/assets/js/grid-option.js"></script>
    <script src="{{ website_assets() }}/assets/js/filter-range-slider.js"></script>
    <script src="{{ website_assets() }}/assets/js/collection-box.js"></script>
    <script src="{{ website_assets() }}/assets/js/swiper-slider/swiper-bundle.min.js"></script>
    <script src="{{ website_assets() }}/assets/js/swiper-slider/swiper-custom.js"></script>
    <script src="{{ website_assets() }}/assets/js/countdown.js"></script>
    <script src="{{ website_assets() }}/assets/js/newsletter.js"></script>
    <script src="{{ website_assets() }}/assets/js/skeleton-loader.js"></script>
    <!-- touchspin-->
    <script src="{{ website_assets() }}/assets/js/touchspin.js"></script>
    <!-- cookie js-->
    <script src="{{ website_assets() }}/assets/js/cookie.js"></script>
    <!-- tost js -->
    <script src="{{ website_assets() }}/assets/js/toastify.js"></script>
    <script src="{{ website_assets() }}/assets/js/theme-setting.js"></script>
    <script src="{{ website_assets() }}/assets/js/cart.js"></script>
    <!-- Theme js-->
    <script src="{{ website_assets() }}/assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.footer-details').forEach(function(element) {
            element.addEventListener('click', function() {
                const targetId = element.getAttribute('data-bs-target');
                const targetElement = document.querySelector(targetId);

                if (window.innerWidth < 992) {
                    if (targetElement.classList.contains('')) {
                        targetElement.classList.remove('');
                    } else {
                        document.querySelectorAll('.footer-details').forEach(function(
                            openElement) {
                            openElement.classList.remove('');
                        });
                        targetElement.classList.add('');
                    }
                }
            });
        });
    });
</script>
    @yield('website.js')

    <script>
        $(document).ready(function() {
            $(document).ajaxStart(function() {
                $('#spinner').show();
            });
            $(document).ajaxStop(function() {
                $('#spinner').hide();
            });


        });
    </script>


    <script>
        // Global function to update the cart count
        function updateCartCount(cartCount) {
            $('.shoping-prize').html(`<i class="fas fa-shopping-basket pe-2"></i>${cartCount} items`);
        }

        function updateSubtotal(subtotal) {
            $('.price-box p').text('₹' + subtotal);
        }

        $(document).ready(function() {
            let selectedSizeId = null;
            let selectedColorId = null;
            $(document).on('click', '.size-option', function(e) {
                e.preventDefault();
                $('.size-item').removeClass('active');
                $(this).closest('.size-item').addClass('active');
                selectedSizeId = $(this).data('size-id');
            });

            // Handle color selection
            $(document).on('click', '.color-option', function() {
                $('.color-option').removeClass('selected');
                $(this).addClass('selected');
                selectedColorId = $(this).data('color-id');
            });

            // Add to Cart functionality

        });

        $(document).ready(function() {
            // Set initial selection
            selectedSizeId = $('.size-item.active .size-option').data('size-id') || null;
            selectedColorId = $('.color-option.active').data('color-id') || null;

            // Update size selection
            $(document).on('click', '.size-option', function(e) {
                e.preventDefault();
                $('.size-item').removeClass('active');
                $(this).closest('.size-item').addClass('active');
                selectedSizeId = $(this).data('size-id');

                // Update color list on size selection
                let productId = $(this).data('product-id');
                $.ajax({
                    url: '{{ route('product.getColorsBySize') }}',
                    type: 'GET',
                    data: {
                        product_id: productId,
                        size_id: selectedSizeId,
                    },
                    success: function(response) {
                        let colorHtml = '';
                        response.colors.forEach(color => {
                            colorHtml += `<li style="background-color: ${color.bg_color}"
                        data-color-id="${color.id}" class="color-option"></li>`;
                        });
                        $('.color-variant').html(colorHtml);
                        $('.color-option:first').addClass('active');
                        selectedColorId = $('.color-option.active').data('color-id');
                    },
                    error: function() {
                        toastr.error('Failed to fetch colors. Please try again.');
                    }
                });
            });

            // Update color selection
            $(document).on('click', '.color-option', function() {
                $('.color-option').removeClass('active');
                $(this).addClass('active');
                selectedColorId = $(this).data('color-id');
            });

            // Handle Add to Cart
            $('.add-to-cart-btn').on('click', function(e) {
                e.preventDefault();
                let productId = $(this).data('product-id');
                let quantity = $(this).closest('.quantity-box').find('.quantity-input').val();



                $.ajax({
                    url: '{{ route('add-to-cart') }}',
                    method: 'POST',
                    data: {
                        product_id: productId,
                        size_id: selectedSizeId,
                        color_id: selectedColorId,
                        quantity: quantity,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
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
        });





        // Remove from Cart functionality
        $(document).on('click', '.delete-icon', function() {
            let itemId = $(this).data('id');
            let cartItem = $(this).closest('li');

            $.ajax({
                url: '{{ route('remove-from-cart') }}',
                method: 'POST',
                data: {
                    id: itemId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);

                        // Animate and remove the item
                        cartItem.fadeOut(300, function() {
                            $(this).remove();
                        });

                        // Update cart count and subtotal
                        updateCartCount(response.cartCount); // Ensure this works after item removal
                        updateSubtotal(response.subtotal);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('Failed to remove the item from the cart.');
                }
            });
        });
    </script>

    <script>
        $(document).on('click', '.add-to-wishlist-btn', function(e) {
            e.preventDefault();

            let productId = $(this).data('product-id');
            let quantity = $('.quantity-input').val() || 1; // Default to 1 if no quantity is provided
            let sizeId = $('.size-item.active .size-option').data('size-id') ?? null;
            let colorId = $('.color-option.active').data('color-id') ?? null;


            $.ajax({
                url: '{{ route('add-to-wishlist') }}',
                type: 'POST',
                data: {
                    product_id: productId,
                    quantity: quantity,
                    size_id: sizeId,
                    color_id: colorId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        window.location.href = '{{ route('wishlist') }}';
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('Failed to add product to wishlist.');
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const searchIcon = document.getElementById('search-icon');

            // Function to handle search action
            function performSearch() {
                const query = searchInput.value.trim();
                if (query) {
                    const url = `{{ route('search-product') }}?search=${encodeURIComponent(query)}`;
                    window.location.href = url;
                } else {
                    alert('Please enter a search term.');
                }
            }

            // Trigger search on 'Enter' key press
            searchInput.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault(); // Prevent default form submission
                    performSearch();
                }
            });

            // Trigger search on magnifying glass icon click
            searchIcon.addEventListener('click', function() {
                performSearch();
            });

            // Add click event listeners for category filters
            document.querySelectorAll('.category-filter').forEach(function(element) {
                element.addEventListener('click', function() {
                    const categoryId = this.dataset.category;
                    if (categoryId) {
                        const url =
                            `{{ route('search-product') }}?category=${encodeURIComponent(categoryId)}`;
                        window.location.href = url;
                    }
                });
            });

            // Add click event listeners for subcategory filters
            document.querySelectorAll('.sub_category-filter').forEach(function(element) {
                element.addEventListener('click', function() {
                    const subCategoryId = this.dataset.category;
                    if (subCategoryId) {
                        const url =
                            `{{ route('search-product') }}?sub_category=${encodeURIComponent(subCategoryId)}`;
                        window.location.href = url;
                    }
                });
            });
            document.querySelectorAll('.brand-filter').forEach(function(element) {
                element.addEventListener('click', function() {
                    const brandId = this.dataset.brand;
                    if (brandId) {
                        const url =
                            `{{ route('search-product') }}?brandId=${encodeURIComponent(brandId)}`;
                        window.location.href = url;
                    }
                });
            });
            document.querySelectorAll('.collection-filter').forEach(function(element) {
                element.addEventListener('click', function() {
                    const collectionID = this.dataset.collection;
                    if (collectionID) {
                        const url =
                            `{{ route('search-product') }}?collectionID=${encodeURIComponent(collectionID)}`;
                        window.location.href = url;
                    }
                });
            });

            // Add click event listeners for tag filters
            document.querySelectorAll('.tag-filter').forEach(function(element) {
                element.addEventListener('click', function() {
                    const tagName = this.dataset.tag; // Tag name
                    if (tagName) {
                        const url =
                            `{{ route('search-product') }}?tag=${encodeURIComponent(tagName)}`;
                        window.location.href = url;
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all nav items with submenus
            const navItems = document.querySelectorAll('#main-nav .nav-menu > li');

            navItems.forEach(item => {
                item.addEventListener('click', function(e) {


                    // Toggle the clicked item's submenu
                    const submenu = this.querySelector('.nav-submenu');
                    if (submenu) {
                        if (submenu.style.display === 'block') {
                            submenu.style.display = 'none';
                        } else {
                            // Hide all other submenus
                            document.querySelectorAll('.nav-submenu').forEach(sub => {
                                sub.style.display = 'none';
                            });
                            submenu.style.display = 'block';
                        }
                    }
                });
            });

            // Close submenu when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('#main-nav')) {
                    document.querySelectorAll('.nav-submenu').forEach(submenu => {
                        submenu.style.display = 'none';
                    });
                }
            });
        });
    </script>



    <script>
        // script.js
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.images;
            const totalImages = images.length;
            let imagesLoaded = 0;

            function imageLoaded() {
                imagesLoaded++;
                if (imagesLoaded === totalImages) {
                    document.getElementById('loading-overlay').style.display = 'none';
                    document.getElementById('main-content').style.opacity = '1';
                    document.getElementById('main-content').style.pointerEvents = 'auto'; // Enable interactions
                }
            }

            for (let i = 0; i < totalImages; i++) {
                if (images[i].complete) {
                    imageLoaded();
                } else {
                    images[i].addEventListener('load', imageLoaded);
                    images[i].addEventListener('error', imageLoaded);
                }
            }
        });
    </script>

<script>
    let deferredPrompt;

    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent the default mini-infobar from appearing on mobile
        e.preventDefault();
        // Save the event so it can be triggered later
        deferredPrompt = e;
    });

    // Get all elements with the 'installPWA' class
    const installPWAButtons = document.getElementsByClassName('installPWA');

    // Loop through all elements with the class 'installPWA'
    Array.from(installPWAButtons).forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault(); // Prevent the default action of the link
            if (deferredPrompt) {
                // Show the install prompt
                deferredPrompt.prompt();
                // Wait for the user to respond to the prompt
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted the install prompt');
                    } else {
                        console.log('User dismissed the install prompt');
                    }
                    deferredPrompt = null;
                });
            } else {
                console.log('No deferred prompt available');
            }
        });
    });
</script>


<script>

if ('serviceWorker' in navigator) {
window.addEventListener('load', () => {
    navigator.serviceWorker
        .register('{{ path() }}/service-worker.js')
        .then((registration) => {
            console.log('Service Worker registered with scope:', registration.scope);
        })
        .catch((error) => {
            console.log('Service Worker registration failed:', error);
        });
});
}
</script>

</body>

</html>
