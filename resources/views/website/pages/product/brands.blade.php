@extends('website.main.app')
@section('title','Brands')
@section('website.content')
    <section class="section-b-space pt-0">
        <div class="heading-banner">
            <div class="custom-container container">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4>Brands</h4>
                    </div>
                    <div class="col-sm-6">
                        <ul class="breadcrumb float-end">
                            <li class="breadcrumb-item"> <a href="index.html">Home /</a></li>
                            <li class=" active"> <a href="#">Brands</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-t-space">
        <div class="custom-container container">
            <div class="row align-items-center">
                <div class="col-xl-12 col-lg-12 col-12">
                    <div class="row gy-4 ratio_square">
                        @foreach ($brands as $brand)
                            <div class="col-3">
                                <a href="{{ route('filter.product.brand',[$brand->id]) }}" style="text-decoration: none;">
                                    <div style="border: 1px solid #ddd; border-radius: 8px; padding: 20px; text-align: center; background-color: #fff; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transform: perspective(1000px) rotateY(0deg); transition: transform 0.5s ease, box-shadow 0.5s ease;">
                                        <h4 style="margin: 0; font-size: 18px; color: #333;">{{ $brand->name }}</h4>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="pagination-wrap mt-0 my-5 mt-3">
                        {{ $brands->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>

                <style>
                    .col-md-4 a div:hover {
                        transform: perspective(1000px) rotateY(15deg);
                        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
                    }
                </style>

            </div>
        </div>
    </section>


@endsection
@section('website.js')
    <script src="{{ website_assets() }}/assets/js/filter-range-slider.js"></script>
@endsection
