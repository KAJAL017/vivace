
    <div class="product-box-3 mb-3">
        <div class="img-wrapper">

            <div class="product-image">
                <a class="pro-first bg-size" href="{{ route('view.product', [$product->slug]) }}" style="
                    background-image: url('{{ path() }}/{{ Product_first_image($product->id) }}');
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                    display: block;">
                    <img loading="lazy" onload="imageLoaded(this)"  class="bg-img" src="{{ path() }}/{{ Product_first_image($product->id) }}" alt="product" style="display: none;">
                </a>
                <a class="pro-sec bg-size" href="{{ route('view.product', [$product->slug]) }}" style="
                    background-image: url('{{ path() }}/{{ get_second_image($product->id) }}');
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                    display: block;">
                    <img loading="lazy" onload="imageLoaded(this)"  class="bg-img" src="{{ path() }}/{{ get_second_image($product->id) }}" alt="product" style="display: none;">
                </a>
            </div>
        </div>
        <div class="product-detail">
           <a href="{{ route('view.product',[$product->slug]) }}">
              <h6>{{ $product->name }}</h6></a>
              <p>
                ₹{{ $product->price }}
                <del>₹{{ $product->mrp }}</del>
                <span>
                  @php
                    $discount = (($product->mrp - $product->price) / $product->mrp) * 100;
                    $discount = round($discount);
                  @endphp
                  -{{ $discount }}%
                </span>
              </p>
          </div>
        {{-- <div class="product-detail">

            <div class="color-box">
                <ul class="color-variant">
                    <li class="bg-color-purple"></li>
                    <li class="bg-color-blue"></li>
                    <li class="bg-color-red"></li>
                    <li class="bg-color-yellow"></li>
                </ul><span>4.5 <i
                        class="fa-solid fa-star"></i></span>
            </div><a
                href="{{ route('view.product', [$product->id]) }}">
                <h6>{{ $product->name }}</h6>
            </a>
            <p>₹{{ $product->price }}
                <del>₹{{ $product->mrp }}</del>
            </p>
        </div> --}}
    </div>


