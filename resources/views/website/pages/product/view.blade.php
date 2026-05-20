@extends('website.main.app')
@section('title', $productData['name'])
{{-- @section('seo')
<title>{{ $product->meta_title ?? '' }}</title>
<meta name="keywords" content="{{ $product->meta_keywords ?? '' }}">
<meta name="description" content="{{ $product->meta_description ?? '' }}">
<meta name="content" content="{{ $product->meta_content ?? '' }}">
@endsection --}}
@section('website.content')
    <section class="section-b-space pt-0">
        <div class="heading-banner">
            <div class="custom-container container">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4>Product Thumbnail</h4>
                    </div>
                    <div class="col-sm-6">
                        <ul class="breadcrumb float-end">
                            <li class="breadcrumb-item"> <a href="#">Product /</a></li>
                            <li class=" active"> <a href="#">{{ $productData['name'] }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-b-space pt-0 product-thumbnail-page">
        <div class="custom-container container">
            @php
                $product_images = DB::table('product_images')
                    ->where(['product_id' => $productData['id']])
                    ->get();
            @endphp
            <div class="row gy-4">
                <div class="col-lg-6">
                    <div class="row gy-3 sticky">
                        <div class="col-12">
                            <div class="swiper product-slider-thumb-1 product-thumbnail">
                                <style>
                                    .img-slide {

                                        background-size: contain !important;
                                        background-position: center center;
                                        background-repeat: no-repeat;
                                        display: block;
                                        width: 808px;
                                        margin-right: 15px;
                                    }
                                </style>
                                <div class="swiper-wrapper ratio3_5">
                                    @foreach ($product_images as $image)
                                        @php
                                            $hasIK = !empty($image->imagekit_url);
                                            $imgDesktop = $image->imagekit_url_desktop ?? null;
                                            $imgTablet  = $image->imagekit_url_tablet  ?? null;
                                            $imgMobile  = $image->imagekit_url_mobile  ?? null;
                                            $imgSrc = $hasIK
                                                ? ($imgDesktop ?? $image->imagekit_url)
                                                : upload_url($image->file_path);
                                        @endphp
                                        <div class="swiper-slide img-slide">
                                            @if($hasIK && $imgMobile && $imgTablet && $imgDesktop)
                                                <picture>
                                                    <source media="(max-width: 575px)"  srcset="{{ $imgMobile }}"  type="image/webp">
                                                    <source media="(max-width: 991px)"  srcset="{{ $imgTablet }}"  type="image/webp">
                                                    <source                              srcset="{{ $imgDesktop }}" type="image/webp">
                                                    <img loading="lazy" class="bg-img product-zoom-trigger"
                                                        src="{{ $imgDesktop }}"
                                                        style="background-size: contain !important; cursor: zoom-in;"
                                                        alt=""
                                                        data-image="{{ $imgDesktop }}">
                                                </picture>
                                            @else
                                                <img loading="lazy" class="bg-img product-zoom-trigger"
                                                    src="{{ $imgSrc }}"
                                                    style="background-size: contain !important; cursor: zoom-in;"
                                                    alt=""
                                                    data-image="{{ $imgSrc }}">
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="swiper product-slider-1">
                                <div class="swiper-wrapper">
                                    @foreach ($product_images as $image)
                                        @php
                                            $hasIK2  = !empty($image->imagekit_url);
                                            $imgSrc2 = $hasIK2
                                                ? ($image->imagekit_url_mobile ?? $image->imagekit_url)
                                                : upload_url($image->file_path);
                                        @endphp
                                        <div class="swiper-slide"> <img loading="lazy" class="img-fluid"
                                                src="{{ $imgSrc2 }}" alt="">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product-detail-box">
                        <div class="product-option">
                            <div class="move-fast-box d-flex align-items-center gap-1"><img
                                    src="{{ website_assets() }}/assets/images/gif/fire.gif" alt="">
                                <p>Get fast!</p>
                            </div>
                            <h3>{{ $productData['name'] }}</h3>
                            @php
                                $price = $productData['variations'][0]['price'] ?? 0;
                                $mrp = $productData['variations'][0]['mrp'] ?? 0;
                                $discountPercentage = $mrp > 0 ? round((($mrp - $price) / $mrp) * 100) : 0;
                            @endphp

                            <p>
                                ₹{{ number_format($price, 2) }}
                                <del>₹{{ number_format($mrp, 2) }}</del>
                                <span class="offer-btn">{{ $discountPercentage }}% off</span>
                            </p>
                            <span class="badge bg-secondary text-white mb-3" style="font-size: 0.85rem;">Excluding GST</span>

                            <div class="rating">
                                <ul>
                                </ul>
                                {!! $productData['short_description'] !!}
                            </div>
                            <div class="d-flex">
                                <div>
                                    <h5>Size:</h5>
                                    <div class="size-box">
                                        <ul class="size-list">
                                            @foreach (collect($productData['variations'])->unique('size.id') as $index => $variation)
                                                <li class="size-item {{ $index === 0 ? 'active' : '' }}">
                                                    <a href="#" class="size-option"
                                                        data-size-id="{{ $variation['size']['id'] }}"
                                                        data-product-id="{{ $productData['id'] }}">
                                                        {{ $variation['size']['name'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>

                                    </div>


                                </div>
                            </div>
                            <div>
                                <h5>Color:</h5>
                                <div class="color-box">
                                    <ul class="color-variant">
                                        @foreach (collect($productData['variations'])->unique('color.id') as $index => $variation)
                                            <li style="background-color: {{ $variation['color']['bg_color'] }}"
                                                data-color-id="{{ $variation['color']['id'] }}"
                                                class="color-option {{ $index === 0 ? 'active' : '' }}">
                                            </li>
                                        @endforeach
                                    </ul>

                                </div>
                            </div>
                            <div class="quantity-box d-flex align-items-center gap-3">
                                <div class="quantity">
                                    <button class="minus" type="button"><i class="fa-solid fa-minus"></i></button>
                                    <input type="number" class="quantity-input" value="1" min="1"
                                        max="20">
                                    <button class="plus" type="button"><i class="fa-solid fa-plus"></i></button>
                                </div>
                                <div class="d-flex align-items-center gap-3 w-100">
                                    <a class="btn btn_black sm add-to-cart-btn" href="#" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"
                                        data-product-id="{{ $productData['id'] }}">Add To Cart</a>
                                </div>
                            </div>
                            {{-- <div class="d-flex align-items-center gap-3 w-100">
                            <a class="btn btn-success sm d-flex align-items-center gap-2 whatsapp-btn" href="#">
                                <i class="fab fa-whatsapp"></i> Buy On WhatsApp
                            </a>
                        </div>   --}}
                            <div class="buy-box">
                                <ul>
                                    <li><a href="#" class="btn btn_black sm add-to-wishlist-btn"
                                            data-product-id="{{ $productData['id'] }}">Add To Wishlist</a>

                                    <li>
                                        <a href="javascript:void(0);" id="shareButton" title="Quick View" tabindex="0">
                                            <i class="fa-solid fa-share-nodes me-2"></i>Share
                                        </a>
                                    </li>

                                </ul>
                            </div>

                            {{-- <div class="dz-info">
                                <ul>
                                    <li>
                                        <div class="d-flex align-items-center gap-2">
                                            <h6>Sku:</h6>
                                            <p> </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center gap-2">
                                            <h6>Available: </h6>
                                            <p>Pre-Order</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center gap-2">
                                            <h6>Tags: </h6>
                                            <p>Color Pink Clay , Athletic, Accessories, Vendor Kalles</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center gap-2">
                                            <h6>Vendor: </h6>
                                            <p> Balenciaga</p>
                                        </div>
                                    </li>
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                    {{-- <script>
document.querySelector('.whatsapp-btn').addEventListener('click', function(e) {
    e.preventDefault();

    let productName = `{{ $productData['name'] }}`;
    let productPrice = `₹{{ number_format($price, 2) }}`;
    let productMRP = `₹{{ number_format($mrp, 2) }}`;
    let discount = `{{ $discountPercentage }}% off`;

    let selectedSize = document.querySelector('.size-item.active .size-option')?.innerText || 'N/A';
    let selectedColor = document.querySelector('.color-option.active')?.getAttribute('data-color-id') || 'N/A';

    // Collect product images
    let imageLinks = `{{ !empty($product_images->first()->imagekit_url) ? $product_images->first()->imagekit_url : upload_url($product_images->first()->file_path) }}`;
    let allImages = @json($product_images->map(fn($img) => !empty($img->imagekit_url) ? $img->imagekit_url : upload_url($img->file_path)));

    let imageText = allImages.map((img, index) => `Image ${index + 1}: ${img}`).join('\n');

    let message = `*New Order Details* \n\n` +
                   `*Product:* ${productName}\n` +
                   `*Price:* ${productPrice} (MRP: ${productMRP})\n` +
                   `*Discount:* ${discount}\n` +
                   `*Size:* ${selectedSize}\n` +
                   `*Color:* ${selectedColor}\n\n` +
                   `*Images:*\n${imageText}`;

    let encodedMessage = encodeURIComponent(message);
    let whatsappUrl = `https://api.whatsapp.com/send/?phone=917889538626&text=${encodedMessage}`;


    window.open(whatsappUrl, '_blank');
});

</script> --}}


                </div>
            </div>
        </div>
        <div class="product-section-box x-small-section pt-0">
            <div class="custom-container container">
                <div class="row">
                    <div class="col-12">
                        <ul class="product-tab nav nav-tabs nav-underline theme-scrollbar" id="Product" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="Description-tab" data-bs-toggle="tab"
                                    data-bs-target="#Description-tab-pane" role="tab"
                                    aria-controls="Description-tab-pane" aria-selected="true">Description</button>
                            </li>
                            {{-- <li class="nav-item" role="presentation">
                                <button class="nav-link" id="specification-tab" data-bs-toggle="tab"
                                    data-bs-target="#specification-tab-pane" role="tab"
                                    aria-controls="specification-tab-pane" aria-selected="false">Specification</button>
                            </li> --}}
                            {{-- <li class="nav-item" role="presentation">
                                <button class="nav-link" id="question-tab" data-bs-toggle="tab"
                                    data-bs-target="#question-tab-pane" role="tab" aria-controls="question-tab-pane"
                                    aria-selected="false">Q & A</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="Reviews-tab" data-bs-toggle="tab"
                                    data-bs-target="#Reviews-tab-pane" role="tab" aria-controls="Reviews-tab-pane"
                                    aria-selected="false">Reviews</button>
                            </li> --}}
                        </ul>
                        <div class="tab-content product-content" id="ProductContent">
                            <div class="tab-pane fade show active" id="Description-tab-pane" role="tabpanel"
                                aria-labelledby="Description-tab" tabindex="0">
                                <div class="row gy-4">
                                    <div class="col-12">
                                        {!! $productData['description'] !!}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="specification-tab-pane" role="tabpanel"
                                aria-labelledby="specification-tab" tabindex="0">
                                <div class="table-responsive theme-scrollbar">
                                    {!! $productData['additional_description'] !!}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="question-tab-pane" role="tabpanel"
                                aria-labelledby="question-tab" tabindex="0">
                                <div class="question-main-box">
                                    <h5>Have Doubts Regarding This Product ?</h5>
                                    <h6 data-bs-toggle="modal" data-bs-target="#question-modal" title="Quick View"
                                        tabindex="0">Post Your
                                        Question</h6>
                                </div>
                                <div class="question-answer">
                                    <ul>
                                        <li>
                                            <div class="question-box">
                                                <p>Q1 </p>
                                                <h6>Which designer created the little black dress?</h6>
                                                <ul class="link-dislike-box">
                                                    <li> <a href="#"><i class="iconsax" data-icon="like"> </i>0</a>
                                                    </li>
                                                    <li> <a href="#"><i class="iconsax" data-icon="dislike">
                                                            </i>0</a></li>
                                                </ul>
                                            </div>
                                            <div class="answer-box"><b>Ans.</b><span>The little black dress (LBD) is often
                                                    attributed to the
                                                    iconic fashion designer Coco Chanel. She popularized the concept of the
                                                    LBD in the 1920s,
                                                    offering a simple, versatile, and elegant garment that became a staple
                                                    in women's
                                                    fashion.</span></div>
                                        </li>
                                        <li>
                                            <div class="question-box">
                                                <p>Q2 </p>
                                                <h6>Which First Lady influenced women's fashion in the 1960s?</h6>
                                                <ul class="link-dislike-box">
                                                    <li> <a href="#"><i class="iconsax" data-icon="like"> </i>0</a>
                                                    </li>
                                                    <li> <a href="#"><i class="iconsax" data-icon="dislike">
                                                            </i>0</a></li>
                                                </ul>
                                            </div>
                                            <div class="answer-box"><b>Ans.</b><span>The First Lady who significantly
                                                    influenced women's
                                                    fashion in the 1960s was Jacqueline Kennedy, the wife of President John
                                                    F. Kennedy. She was
                                                    renowned for her elegant and sophisticated style, often wearing simple
                                                    yet chic outfits that
                                                    set trends during her time in the White House. </span></div>
                                        </li>
                                        <li>
                                            <div class="question-box">
                                                <p>Q3 </p>
                                                <h6>What was the first name of the fashion designer Chanel?</h6>
                                                <ul class="link-dislike-box">
                                                    <li> <a href="#"><i class="iconsax" data-icon="like"> </i>0</a>
                                                    </li>
                                                    <li> <a href="#"><i class="iconsax" data-icon="dislike">
                                                            </i>0</a></li>
                                                </ul>
                                            </div>
                                            <div class="answer-box"><b>Ans.</b><span>The first name of the fashion designer
                                                    Chanel was
                                                    Gabrielle. Gabrielle "Coco" Chanel was a pioneering French fashion
                                                    designer known for her
                                                    timeless designs, including the iconic Chanel suit and the little black
                                                    dress.</span></div>
                                        </li>
                                        <li>
                                            <div class="question-box">
                                                <p>Q4 </p>
                                                <h6>Carnaby Street, famous in the 60s as a fashion center, is in which
                                                    capital?</h6>
                                                <ul class="link-dislike-box">
                                                    <li> <a href="#"><i class="iconsax" data-icon="like"> </i>0</a>
                                                    </li>
                                                    <li> <a href="#"><i class="iconsax" data-icon="dislike">
                                                            </i>0</a></li>
                                                </ul>
                                            </div>
                                            <div class="answer-box"><b>Ans.</b><span>Carnaby Street, famous for its
                                                    association with fashion
                                                    and youth culture in the 1960s, is located in London, the capital of the
                                                    United
                                                    Kingdom.🎉</span></div>
                                        </li>
                                        <li>
                                            <div class="question-box">
                                                <p>Q5 </p>
                                                <h6>Threadless is a company selling unique what?</h6>
                                                <ul class="link-dislike-box">
                                                    <li> <a href="#"><i class="iconsax" data-icon="like"> </i>0</a>
                                                    </li>
                                                    <li> <a href="#"><i class="iconsax" data-icon="dislike">
                                                            </i>0</a></li>
                                                </ul>
                                            </div>
                                            <div class="answer-box"><b>Ans.</b><span>Threadless is a company selling unique
                                                    T-shirts.</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            {{-- <div class="tab-pane fade" id="Reviews-tab-pane" role="tabpanel"
                                aria-labelledby="Reviews-tab" tabindex="0">
                                <div class="row gy-4">
                                    <div class="col-lg-4">
                                        <div class="review-right">
                                            <div class="customer-rating">
                                                <div class="global-rating">
                                                    <div>
                                                        <h5>4.5</h5>
                                                    </div>
                                                    <div>
                                                        <h6>Average Ratings</h6>
                                                        <ul class="rating p-0 mb">
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-solid fa-star"></i></li>
                                                            <li><i class="fa-regular fa-star"></i></li>
                                                            <li><span>(14)</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <ul class="rating-progess">
                                                    <li>
                                                        <p>5 Star</p>
                                                        <div class="progress" role="progressbar"
                                                            aria-label="Animated striped example" aria-valuenow="75"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                                style="width: 80%">
                                                            </div>
                                                        </div>
                                                        <p>80%</p>
                                                    </li>
                                                    <li>
                                                        <p>4 Star</p>
                                                        <div class="progress" role="progressbar"
                                                            aria-label="Animated striped example" aria-valuenow="75"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                                style="width: 70%">
                                                            </div>
                                                        </div>
                                                        <p>70%</p>
                                                    </li>
                                                    <li>
                                                        <p>3 Star</p>
                                                        <div class="progress" role="progressbar"
                                                            aria-label="Animated striped example" aria-valuenow="75"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                                style="width: 55%">
                                                            </div>
                                                        </div>
                                                        <p>55%</p>
                                                    </li>
                                                    <li>
                                                        <p>2 Star</p>
                                                        <div class="progress" role="progressbar"
                                                            aria-label="Animated striped example" aria-valuenow="75"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                                style="width: 40%">
                                                            </div>
                                                        </div>
                                                        <p>40%</p>
                                                    </li>
                                                    <li>
                                                        <p>1 Star</p>
                                                        <div class="progress" role="progressbar"
                                                            aria-label="Animated striped example" aria-valuenow="75"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                                style="width: 25%">
                                                            </div>
                                                        </div>
                                                        <p>25%</p>
                                                    </li>
                                                </ul>
                                                <button class="btn reviews-modal" data-bs-toggle="modal"
                                                    data-bs-target="#Reviews-modal" title="Quick View"
                                                    tabindex="0">Write a review</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="comments-box">
                                            <h5>Comments </h5>
                                            <ul class="theme-scrollbar">
                                                <li>
                                                    <div class="comment-items">
                                                        <div class="user-img"> <img
                                                                src="{{ website_assets() }}/assets/images/user/1.jpg"
                                                                alt=""></div>
                                                        <div class="user-content">
                                                            <div class="user-info">
                                                                <div class="d-flex justify-content-between gap-3">
                                                                    <h6> <i class="iconsax" data-icon="user-1"></i>Michel
                                                                        Poe</h6><span> <i class="iconsax"
                                                                            data-icon="clock"></i>Mar 29, 2022</span>
                                                                </div>
                                                                <ul class="rating p-0 mb">
                                                                    <li><i class="fa-solid fa-star"></i></li>
                                                                    <li><i class="fa-solid fa-star"></i></li>
                                                                    <li><i class="fa-solid fa-star"></i></li>
                                                                    <li><i class="fa-solid fa-star"></i></li>
                                                                    <li><i class="fa-regular fa-star"></i></li>
                                                                </ul>
                                                            </div>
                                                            <p>Khaki cotton blend military jacket flattering fit mock horn
                                                                buttons and patch pockets
                                                                showerproof black lightgrey. Printed lining patch pockets
                                                                jersey blazer built in pocket
                                                                square wool casual quilted jacket without hood azure.</p><a
                                                                href="#"> <span> <i class="iconsax"
                                                                        data-icon="undo"></i> Replay</span></a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="reply">
                                                    <div class="comment-items">
                                                        <div class="user-img"> <img
                                                                src="{{ website_assets() }}/assets/images/user/2.jpg"
                                                                alt=""></div>
                                                        <div class="user-content">
                                                            <div class="user-info">
                                                                <div class="d-flex justify-content-between gap-3">
                                                                    <h6> <i class="iconsax" data-icon="user-1"></i>Michel
                                                                        Poe</h6><span> <i class="iconsax"
                                                                            data-icon="clock"></i>Mar 29, 2022</span>
                                                                </div>
                                                                <ul class="rating p-0 mb">
                                                                    <li><i class="fa-solid fa-star"></i></li>
                                                                    <li><i class="fa-solid fa-star"></i></li>
                                                                    <li><i class="fa-solid fa-star"></i></li>
                                                                    <li><i class="fa-solid fa-star"></i></li>
                                                                    <li><i class="fa-regular fa-star"></i></li>
                                                                </ul>
                                                            </div>
                                                            <p>Khaki cotton blend military jacket flattering fit mock horn
                                                                buttons and patch pockets
                                                                showerproof black lightgrey. Printed lining patch pockets
                                                                jersey blazer built in pocket
                                                                square wool casual quilted jacket without hood azure.</p><a
                                                                href="#"> <span> <i class="iconsax"
                                                                        data-icon="undo"></i> Replay</span></a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="comment-items">
                                                        <div class="user-img"> <img
                                                                src="{{ website_assets() }}/assets/images/user/3.jpg"
                                                                alt=""></div>
                                                        <div class="user-content">
                                                            <div class="user-info">
                                                                <div class="d-flex justify-content-between gap-3">
                                                                    <h6> <i class="iconsax" data-icon="user-1"></i>Michel
                                                                        Poe</h6><span> <i class="iconsax"
                                                                            data-icon="clock"></i>Mar 29, 2022</span>
                                                                </div>
                                                                <ul class="rating p-0 mb">
                                                                    <li><i class="fa-solid fa-star"></i></li>
                                                                    <li><i class="fa-solid fa-star"></i></li>
                                                                    <li><i class="fa-solid fa-star"></i></li>
                                                                    <li><i class="fa-solid fa-star"></i></li>
                                                                    <li><i class="fa-regular fa-star"></i></li>
                                                                </ul>
                                                            </div>
                                                            <p>Khaki cotton blend military jacket flattering fit mock horn
                                                                buttons and patch pockets
                                                                showerproof black lightgrey. Printed lining patch pockets
                                                                jersey blazer built in pocket
                                                                square wool casual quilted jacket without hood azure.</p><a
                                                                href="#"> <span> <i class="iconsax"
                                                                        data-icon="undo"></i> Replay</span></a>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-b-space pt-0">
        <div class="custom-container container product-contain">
            <div class="title text-start">
                <h3>Related Products</h3>
                @php

                    $related_products = DB::table('products')
                        ->join(
                            DB::raw(
                                '(SELECT MIN(id) as id, product_id FROM product_attributes GROUP BY product_id) as first_attribute',
                            ),
                            'products.id',
                            '=',
                            'first_attribute.product_id',
                        )
                        ->join('product_attributes', 'product_attributes.id', '=', 'first_attribute.id')
                        ->where('products.is_deleted', 0)
                        ->where('products.category_id', $productData['category_id'])
                        ->select(
                            'products.id',
                            'products.name',
                            'products.title',
                            'products.description',
                            'products.featured',
                            'products.featured',
                            'products.discounted',
                            'products.slug',
                            'products.newarrival',
                            'products.bestseller',
                            'product_attributes.id as attr_id',
                            'product_attributes.size_id',
                            'product_attributes.color_id',
                            'product_attributes.mrp',
                            'product_attributes.qty',
                            'product_attributes.price',
                        )
                        ->limit(10)
                        ->get();

                @endphp
            </div>
            <div class="swiper special-offer-slide-2">
                <div class="swiper-wrapper ratio1_3">
                    @foreach ($related_products as $product)
                        @php
                            $rp1 = product_responsive_image($product->id);
                            $rp2 = product_second_image($product->id);
                        @endphp
                        <div class="swiper-slide">
                            <div class="product-box-3">
                                <div class="img-wrapper">
                                    <div class="product-image" style="position:relative; overflow:hidden; aspect-ratio:3/4; background:#f5f5f5;">
                                        <a class="pro-first" href="{{ route('view.product', [$product->slug]) }}"
                                           style="display:block; width:100%; height:100%; position:absolute; top:0; left:0; transition:opacity 0.3s;">
                                            @if($rp1['has_ik'])
                                                <picture>
                                                    <source media="(max-width: 575px)"  srcset="{{ $rp1['mobile'] }}"  type="image/webp">
                                                    <source media="(max-width: 991px)"  srcset="{{ $rp1['tablet'] }}"  type="image/webp">
                                                    <source                              srcset="{{ $rp1['desktop'] }}" type="image/webp">
                                                    <img loading="lazy" class="bg-img" src="{{ $rp1['desktop'] }}" alt="{{ $product->name }}"
                                                         style="width:100%; height:100%; object-fit:cover; object-position:top center; display:block;">
                                                </picture>
                                            @else
                                                <img loading="lazy" class="bg-img" src="{{ $rp1['src'] }}" alt="{{ $product->name }}"
                                                     style="width:100%; height:100%; object-fit:cover; object-position:top center; display:block;">
                                            @endif
                                        </a>
                                        <a class="pro-sec" href="{{ route('view.product', [$product->slug]) }}"
                                           style="display:block; width:100%; height:100%; position:absolute; top:0; left:0; opacity:0; transition:opacity 0.3s;">
                                            @if($rp2['has_ik'])
                                                <picture>
                                                    <source media="(max-width: 575px)"  srcset="{{ $rp2['mobile'] }}"  type="image/webp">
                                                    <source media="(max-width: 991px)"  srcset="{{ $rp2['tablet'] }}"  type="image/webp">
                                                    <source                              srcset="{{ $rp2['desktop'] }}" type="image/webp">
                                                    <img loading="lazy" class="bg-img" src="{{ $rp2['desktop'] }}" alt="{{ $product->name }}"
                                                         style="width:100%; height:100%; object-fit:cover; object-position:top center; display:block;">
                                                </picture>
                                            @else
                                                <img loading="lazy" class="bg-img" src="{{ $rp2['src'] }}" alt="{{ $product->name }}"
                                                     style="width:100%; height:100%; object-fit:cover; object-position:top center; display:block;">
                                            @endif
                                        </a>
                                    </div>
                                </div>
                                <div class="product-detail" style="padding:8px 4px 4px;">
                                    <a href="{{ route('view.product', [$product->slug]) }}">
                                        <h6 style="font-size:0.85rem; font-weight:600; color:#1a1a1a; margin-bottom:4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                            {{ $product->name }}
                                        </h6>
                                    </a>
                                    @php
                                        $price = $product->price ?? 0;
                                        $mrp   = $product->mrp   ?? 0;
                                        $disc  = $mrp > 0 ? round((($mrp - $price) / $mrp) * 100) : 0;
                                    @endphp
                                    <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                                        <span style="font-size:0.9rem; font-weight:700; color:#1a1a1a;">₹{{ number_format($price) }}</span>
                                        @if($mrp > $price)
                                            <span style="font-size:0.78rem; color:#aaa; text-decoration:line-through;">₹{{ number_format($mrp) }}</span>
                                            <span style="font-size:0.72rem; color:#e74c3c; font-weight:600;">-{{ $disc }}%</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>

    <!-- Image Zoom Modal -->
    <div class="modal fade" id="imageZoomModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content" style="background: #000;">
                <div class="modal-header" style="border: none; padding: 10px 20px;">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 0; position: relative; overflow: hidden; min-height: 70vh; display: flex; align-items: center; justify-content: center;">
                    <img id="zoomImage" src="" alt="Product Image" style="max-width: 100%; max-height: 80vh; object-fit: contain; cursor: zoom-in; transition: transform 0.3s ease;">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('website.js')


    <script>
        document.getElementById('shareButton').addEventListener('click', function() {
            // Get the current URL
            const currentUrl = window.location.href;

            // Copy the URL to the clipboard
            navigator.clipboard.writeText(currentUrl)
                .then(() => {
                    // Show a success message (optional)
                    alert('Link copied to clipboard!');
                })
                .catch(err => {
                    console.error('Failed to copy link: ', err);
                });
        });

        // Image Zoom Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const zoomTriggers = document.querySelectorAll('.product-zoom-trigger');
            const zoomModal = new bootstrap.Modal(document.getElementById('imageZoomModal'));
            const zoomImage = document.getElementById('zoomImage');
            let isZoomed = false;

            // Open modal on image click
            zoomTriggers.forEach(trigger => {
                trigger.addEventListener('click', function() {
                    const imageSrc = this.getAttribute('data-image');
                    zoomImage.src = imageSrc;
                    zoomImage.style.transform = 'scale(1)';
                    isZoomed = false;
                    zoomModal.show();
                });
            });

            // Zoom in/out on modal image click
            zoomImage.addEventListener('click', function() {
                if (!isZoomed) {
                    this.style.transform = 'scale(2)';
                    this.style.cursor = 'zoom-out';
                    isZoomed = true;
                } else {
                    this.style.transform = 'scale(1)';
                    this.style.cursor = 'zoom-in';
                    isZoomed = false;
                }
            });

            // Reset zoom when modal closes
            document.getElementById('imageZoomModal').addEventListener('hidden.bs.modal', function() {
                zoomImage.style.transform = 'scale(1)';
                isZoomed = false;
            });

            // Pan zoomed image with mouse move
            zoomImage.addEventListener('mousemove', function(e) {
                if (isZoomed) {
                    const rect = this.getBoundingClientRect();
                    const x = ((e.clientX - rect.left) / rect.width) * 100;
                    const y = ((e.clientY - rect.top) / rect.height) * 100;
                    this.style.transformOrigin = `${x}% ${y}%`;
                }
            });
        });
    </script>

@endsection
