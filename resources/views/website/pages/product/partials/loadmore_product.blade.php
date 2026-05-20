@php
    $lp  = isset($loadmore_product) ? $loadmore_product : $product;
    $lp1 = product_responsive_image($lp->id);
    $lp2 = product_second_image($lp->id);
@endphp

<div class="col-xxl-3 col-md-4 col-6">
    <div class="product-box-3 mb-3">
        <div class="img-wrapper">
            <div class="product-image" style="position:relative; overflow:hidden; aspect-ratio: 3/4; background:#f5f5f5;">

                <a class="pro-first" href="{{ route('view.product', [$lp->slug]) }}"
                   style="display:block; width:100%; height:100%; position:absolute; top:0; left:0; transition:opacity 0.3s;">
                    @if($lp1['has_ik'])
                        <picture>
                            <source media="(max-width: 575px)"  srcset="{{ $lp1['mobile'] }}"  type="image/webp">
                            <source media="(max-width: 991px)"  srcset="{{ $lp1['tablet'] }}"  type="image/webp">
                            <source                              srcset="{{ $lp1['desktop'] }}" type="image/webp">
                            <img loading="lazy" src="{{ $lp1['desktop'] }}" alt="{{ $lp->name }}"
                                 style="width:100%; height:100%; object-fit:cover; object-position:top center; display:block;">
                        </picture>
                    @else
                        <img loading="lazy" src="{{ $lp1['src'] }}" alt="{{ $lp->name }}"
                             style="width:100%; height:100%; object-fit:cover; object-position:top center; display:block;">
                    @endif
                </a>

                <a class="pro-sec" href="{{ route('view.product', [$lp->slug]) }}"
                   style="display:block; width:100%; height:100%; position:absolute; top:0; left:0; opacity:0; transition:opacity 0.3s;">
                    @if($lp2['has_ik'])
                        <picture>
                            <source media="(max-width: 575px)"  srcset="{{ $lp2['mobile'] }}"  type="image/webp">
                            <source media="(max-width: 991px)"  srcset="{{ $lp2['tablet'] }}"  type="image/webp">
                            <source                              srcset="{{ $lp2['desktop'] }}" type="image/webp">
                            <img loading="lazy" src="{{ $lp2['desktop'] }}" alt="{{ $lp->name }}"
                                 style="width:100%; height:100%; object-fit:cover; object-position:top center; display:block;">
                        </picture>
                    @else
                        <img loading="lazy" src="{{ $lp2['src'] }}" alt="{{ $lp->name }}"
                             style="width:100%; height:100%; object-fit:cover; object-position:top center; display:block;">
                    @endif
                </a>
            </div>
        </div>

        <div class="product-detail" style="padding: 8px 4px 4px;">
            <a href="{{ route('view.product', [$lp->slug]) }}">
                <h6 style="font-size:0.85rem; font-weight:600; color:#1a1a1a; margin-bottom:4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                    {{ $lp->name }}
                </h6>
            </a>
            <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap; margin-top:4px;">
                <span style="font-size:0.9rem; font-weight:700; color:#1a1a1a;">₹{{ number_format($lp->price) }}</span>
                @if($lp->mrp > $lp->price)
                    <span style="font-size:0.78rem; color:#aaa; text-decoration:line-through;">₹{{ number_format($lp->mrp) }}</span>
                    @php $discount = round((($lp->mrp - $lp->price) / $lp->mrp) * 100); @endphp
                    <span style="font-size:0.72rem; color:#e74c3c; font-weight:600;">-{{ $discount }}%</span>
                @endif
            </div>
        </div>
    </div>
</div>
