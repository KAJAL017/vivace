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
                                @include('website.pages.product.partials.product', ['product' => $product])
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