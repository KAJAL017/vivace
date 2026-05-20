@php
    $p1 = product_responsive_image($product->id);
    $p2 = product_second_image($product->id);
@endphp

<div class="col-xxl-3 col-lg-3 col-md-4 col-6">
<div class="product-box-3 mb-3">
    <div class="img-wrapper">
        <div class="product-image" style="position:relative; overflow:hidden; aspect-ratio: 3/4; background:#f5f5f5;">

            {{-- First image --}}
            <a class="pro-first" href="{{ route('view.product', [$product->slug]) }}"
               style="display:block; width:100%; height:100%; position:absolute; top:0; left:0;">
                @if($p1['has_ik'])
                    <picture>
                        <source media="(max-width: 575px)"  srcset="{{ $p1['mobile'] }}"  type="image/webp">
                        <source media="(max-width: 991px)"  srcset="{{ $p1['tablet'] }}"  type="image/webp">
                        <source                              srcset="{{ $p1['desktop'] }}" type="image/webp">
                        <img loading="lazy"
                             src="{{ $p1['desktop'] }}"
                             alt="{{ $product->name }}"
                             style="width:100%; height:100%; object-fit:cover; object-position:top center; display:block; transition:opacity 0.3s;">
                    </picture>
                @else
                    <img loading="lazy"
                         src="{{ $p1['src'] }}"
                         alt="{{ $product->name }}"
                         style="width:100%; height:100%; object-fit:cover; object-position:top center; display:block; transition:opacity 0.3s;">
                @endif
            </a>

            {{-- Second image (hover) --}}
            <a class="pro-sec" href="{{ route('view.product', [$product->slug]) }}"
               style="display:block; width:100%; height:100%; position:absolute; top:0; left:0; opacity:0; transition:opacity 0.3s;">
                @if($p2['has_ik'])
                    <picture>
                        <source media="(max-width: 575px)"  srcset="{{ $p2['mobile'] }}"  type="image/webp">
                        <source media="(max-width: 991px)"  srcset="{{ $p2['tablet'] }}"  type="image/webp">
                        <source                              srcset="{{ $p2['desktop'] }}" type="image/webp">
                        <img loading="lazy"
                             src="{{ $p2['desktop'] }}"
                             alt="{{ $product->name }}"
                             style="width:100%; height:100%; object-fit:cover; object-position:top center; display:block;">
                    </picture>
                @else
                    <img loading="lazy"
                         src="{{ $p2['src'] }}"
                         alt="{{ $product->name }}"
                         style="width:100%; height:100%; object-fit:cover; object-position:top center; display:block;">
                @endif
            </a>
        </div>
    </div>

    <div class="product-detail" style="padding: 8px 4px 4px;">
        <a href="{{ route('view.product', [$product->slug]) }}">
            <h6 style="font-size:0.85rem; font-weight:600; color:#1a1a1a; margin-bottom:4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                {{ $product->name }}
            </h6>
        </a>
        <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap; margin-top:4px;">
            <span style="font-size:0.9rem; font-weight:700; color:#1a1a1a;">₹{{ number_format($product->price) }}</span>
            @if($product->mrp > $product->price)
                <span style="font-size:0.78rem; color:#aaa; text-decoration:line-through;">₹{{ number_format($product->mrp) }}</span>
                @php $discount = round((($product->mrp - $product->price) / $product->mrp) * 100); @endphp
                <span style="font-size:0.72rem; color:#e74c3c; font-weight:600;">-{{ $discount }}%</span>
            @endif
        </div>
    </div>
</div>
</div>{{-- col --}}

<style>
    .product-image .pro-sec { opacity: 0; }
    .product-image:hover .pro-sec { opacity: 1; }
    .product-image:hover .pro-first { opacity: 0; }
    .product-image .pro-first { transition: opacity 0.3s; }
    .product-image .pro-sec   { transition: opacity 0.3s; }
</style>
