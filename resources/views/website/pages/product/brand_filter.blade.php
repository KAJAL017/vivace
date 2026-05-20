@extends('website.main.app')
@section('title','Brand Products')

<style>
.breadcrumb {
    --bs-breadcrumb-divider: "/";
}
.breadcrumb-item + .breadcrumb-item::before {
    content: "/";
}
</style>

@section('website.content')
    <section class="section-b-space pt-0">
        <div class="heading-banner">
            <div class="custom-container container">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4>Brand Products</h4>
                    </div>
                    <div class="col-sm-6">
                        <ul class="breadcrumb float-end">
                            <li class="breadcrumb-item"> <a href="{{ route('website.home') }}">Home / </a></li>
                            <li class="breadcrumb-item"> <a href="{{ route('filter.product.brand', request()->route('id')) }}">Brand / </a></li>
                            <li class=" active"> <a href="#">Products</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-b-space pt-0">
        <div class="custom-container container">
            <div class="row">
                <div class="col-12">
                    <div class="sticky">
                        <div class="top-filter-menu">
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
                        <div class="row row-cols-lg-4 row-cols-md-3 row-cols-2 grid-section view-option g-3 g-xl-4" id="product-results">
                            @forelse($products as $product)
                                <div class="col-lg-3 col-md-4 col-6">
                                    <div class="product-box-3">
                                        <div class="img-wrapper">
                                            <a class="label-2 wishlist-icon" href="javascript:void(0)" tabindex="0">
                                                <i class="iconsax" data-icon="heart" aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i>
                                            </a>
                                            <div class="product-image">
                                                <a class="pro-first" href="{{ route('view.product', $product->slug) }}">
                                                    @php $bf1 = product_responsive_image($product->id); @endphp
                                                    @if($bf1['has_ik'])
                                                        <picture>
                                                            <source media="(max-width: 575px)"  srcset="{{ $bf1['mobile'] }}"  type="image/webp">
                                                            <source media="(max-width: 991px)"  srcset="{{ $bf1['tablet'] }}"  type="image/webp">
                                                            <source                              srcset="{{ $bf1['desktop'] }}" type="image/webp">
                                                            <img class="bg-img" src="{{ $bf1['desktop'] }}" alt="{{ $product->name }}">
                                                        </picture>
                                                    @else
                                                        <img class="bg-img" src="{{ $bf1['src'] }}" alt="{{ $product->name }}">
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="cart-info-icon">
                                                <a href="javascript:void(0)" onclick="addToCart({{ $product->id }})" data-bs-toggle="tooltip" data-bs-title="Add to cart">
                                                    <i class="iconsax" data-icon="basket-2"></i>
                                                </a>
                                                <a href="{{ route('view.product', $product->slug) }}" data-bs-toggle="tooltip" data-bs-title="Quick View">
                                                    <i class="iconsax" data-icon="eye"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-detail">
                                            <a href="{{ route('view.product', $product->slug) }}">
                                                <h6>{{ $product->name }}</h6>
                                            </a>
                                            @php
                                                $minPrice = $product->price ?? 0;
                                                $minMrp = $product->mrp ?? 0;
                                                $discount = 0;
                                                if($minMrp > 0 && $minPrice > 0) {
                                                    $discount = round((($minMrp - $minPrice) / $minMrp) * 100);
                                                }
                                            @endphp
                                            <p>₹{{ number_format($minPrice, 2) }}
                                                @if($minMrp > $minPrice)
                                                <del>₹{{ number_format($minMrp, 2) }}</del>
                                                @if($discount > 0)
                                                <span>-{{ $discount }}%</span>
                                                @endif
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center py-5">
                                    <p>No products found for this brand.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection