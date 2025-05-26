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
                                        <div class="swiper-slide img-slide"> <img loading="lazy" class="bg-img "
                                                src="{{ url('public/' . $image->file_path) }}"
                                                style="background-size: contain !important" alt="">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="swiper product-slider-1">
                                <div class="swiper-wrapper">
                                    @foreach ($product_images as $image)
                                        <div class="swiper-slide"> <img loading="lazy" class="img-fluid"
                                                src="{{ url('public/' . $image->file_path) }}" alt="">
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

                            <div class="rating">
                                <ul>
                                    <li> <i class="fa-solid fa-star"> </i><i class="fa-solid fa-star"> </i><i
                                            class="fa-solid fa-star">
                                        </i><i class="fa-solid fa-star-half-stroke"></i><i class="fa-regular fa-star"></i>
                                    </li>
                                    <li>(4.7) Rating</li>
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
    let imageLinks = `{{ url('public/' . $product_images->first()->file_path) }}`; // Display first image
    let allImages = @json($product_images->pluck('file_path')->map(fn($path) => url('public/' . $path)));

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
                        <div class="swiper-slide">
                            <div class="product-box-3">
                                <div class="img-wrapper">
                                    {{-- <div class="label-block"><span class="lable-1">NEW</span><a
                                            class="label-2 wishlist-icon" href="javascript:void(0)" tabindex="0"><i
                                                class="iconsax" data-icon="heart" aria-hidden="true"
                                                data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i></a></div> --}}
                                    <div class="product-image"><a class="pro-first"
                                            href="{{ route('view.product', [$product->slug]) }}"> <img loading="lazy"
                                                class="bg-img"
                                                src="{{ path() }}/{{ Product_first_image($product->id) }}"
                                                alt="product"></a><a class="pro-sec"
                                            href="{{ route('view.product', [$product->slug]) }}"> <img loading="lazy"
                                                class="bg-img"
                                                src="{{ path() }}/{{ get_second_image($product->id) }}"
                                                alt="product"></a></div>
                                    {{-- <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#addtocart" tabindex="0"><i class="iconsax"
                                                data-icon="basket-2" aria-hidden="true" data-bs-toggle="tooltip"
                                                data-bs-title="Add to cart"> </i></a><a href="compare.html"
                                            tabindex="0"><i class="iconsax" data-icon="arrow-up-down"
                                                aria-hidden="true" data-bs-toggle="tooltip"
                                                data-bs-title="Compare"></i></a><a href="#" data-bs-toggle="modal"
                                            data-bs-target="#quick-view" tabindex="0"><i class="iconsax"
                                                data-icon="eye" aria-hidden="true" data-bs-toggle="tooltip"
                                                data-bs-title="Quick View"></i></a></div> --}}
                                </div>
                                <div class="product-detail">
                                    {{-- <ul class="rating">
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li>4.3</li>
                                    </ul> --}}
                                    <a href="{{ route('view.product', [$product->slug]) }}">
                                        <h6>{{ $product->name }}</h6>
                                    </a>
                                    @php
                                        $price = $product->price ?? 0;
                                        $mrp = $product->mrp ?? 0;
                                        $discountPercentage = $mrp > 0 ? round((($mrp - $price) / $mrp) * 100) : 0;
                                    @endphp

                                    <p>
                                        ₹{{ number_format($price, 2) }}
                                        <del>₹{{ number_format($mrp, 2) }}</del>
                                        <span>-{{ $discountPercentage }}%</span>
                                    </p>

                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>
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
    </script>

@endsection
