@extends('website.main.app')
@section('title', 'Search' . (isset($search_term) && $search_term ? ' - ' . $search_term : ''))

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
            <h4>Search</h4>
          </div>
          <div class="col-sm-6">
            <ul class="breadcrumb float-end">
              <li class="breadcrumb-item"> <a href="{{ route('website.home') }}">Home / </a></li>
              <li class=" active"> <a href="#">Search{{ isset($search_term) && $search_term ? ' / ' . $search_term : '' }}</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section-b-space pt-0">
    <div class="custom-container container">
      <div class="row gy-4">
        <div class="col-12 m-auto">
          <div class="title-1">
            <p class="justify-content-center">Search Results<span></span></p>
            <h3 class="text-center">Search For Products</h3>
          </div>
        </div>
        <div class="col-lg-5 col-sm-8 m-auto">
          <form action="{{ route('search-product') }}" method="GET" id="search-form">
            <div class="main-search-box">
              <div>
                <input type="search" name="search" id="search-input-page" placeholder="Search Here..." value="{{ request('search', '') }}"><i class="iconsax search-icon-btn" data-icon="search-normal-2"></i>
              </div>
              <button class="btn btn_black sm" type="submit">Search</button>
            </div>
          </form>
        </div>

        {{-- Search Results --}}
        <div class="col-12">
            @if(isset($error))
                <div class="alert alert-danger">Error: {{ $error }}</div>
            @endif

            @if(isset($search_term) && $search_term && $products->isEmpty())
                <div class="text-center py-4">
                    <h5>No results found for "{{ $search_term }}"</h5>
                    <p>Try different keywords or browse our products below</p>
                </div>
            @endif

            <div class="row gy-4" id="search-results">
                @forelse($products as $product)
                    @include('website.pages.product.partials.product', ['product' => $product])
                @empty
                    @if(!isset($search_term) || !$search_term)
                    <div class="col-12 text-center py-5">
                        <p style="font-size: 1.2rem; color: #7f8c8d;">No products available</p>
                    </div>
                    @endif
                @endforelse

                {{-- Pagination --}}
                @if(is_object($products) && method_exists($products, 'hasPages') && $products->hasPages())
                <div class="col-12">
                    <div class="pagination-wrap mt-0 my-5 mt-3">
                        {{ $products->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Search by Brands --}}
        @if(isset($brands) && $brands->count() > 0)
        <div class="col-12 mt-4">
            <h5>Related Brands</h5>
            <div class="row gy-3">
                @foreach($brands as $brand)
                <div class="col-lg-2 col-md-3 col-4">
                    <a href="{{ route('filter.product.brand', $brand->id) }}" class="brand-box text-center p-3 border rounded">
                        <img src="{{ $brand->image ? upload_url($brand->image) : asset('website/assets/images/brand/no-image.png') }}" alt="{{ $brand->name }}" class="img-fluid" style="max-height: 50px;">
                        <p class="mt-2 mb-0">{{ $brand->name }}</p>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Search by Categories --}}
        @if(isset($categories) && $categories->count() > 0)
        <div class="col-12 mt-4">
            <h5>Related Categories</h5>
            <div class="row gy-3">
                @foreach($categories as $category)
                <div class="col-lg-2 col-md-3 col-4">
                    <a href="{{ route('filter.product.category', $category->id) }}" class="category-box text-center p-3 border rounded">
                        <img src="{{ $category->image ? url($category->image) : asset('website/assets/images/category/no-image.png') }}" alt="{{ $category->name }}" class="img-fluid" style="max-height: 50px;">
                        <p class="mt-2 mb-0">{{ $category->name }}</p>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
      </div>
    </div>
  </section>
@endsection

@section('website.js')
<script>
    // Handle search form submission
    document.getElementById('search-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const searchTerm = document.getElementById('search-input-page').value.trim();
        if (searchTerm) {
            window.location.href = '{{ route("search-product") }}?search=' + encodeURIComponent(searchTerm);
        }
    });

    // Handle search icon click
    document.querySelector('.search-icon-btn').addEventListener('click', function() {
        const searchTerm = document.getElementById('search-input-page').value.trim();
        if (searchTerm) {
            window.location.href = '{{ route("search-product") }}?search=' + encodeURIComponent(searchTerm);
        }
    });

    // Handle Enter key in search input
    document.getElementById('search-input-page').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const searchTerm = this.value.trim();
            if (searchTerm) {
                window.location.href = '{{ route("search-product") }}?search=' + encodeURIComponent(searchTerm);
            }
        }
    });
</script>
@endsection