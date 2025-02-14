@extends('website.main.app')
@section('title', 'Collections')
@section('website.content')
    <section class="section-b-space pt-0">
        <div class="heading-banner">
            <div class="custom-container container">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4>Collections</h4>
                    </div>
                    <div class="col-sm-6">
                        <ul class="breadcrumb float-end">
                            <li class="breadcrumb-item"> <a href="index.html">Home /</a></li>
                            <li class=" active"> <a href="#">Collections</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-0">
        <div class="custom-container container">
            <div class="row align-items-center">
                <input type="text" id="collection-search" class="form-control" placeholder="Enter Collection Name" style="width: 100%; max-width: 600px; padding: 10px 20px; border: 1px solid #ccc; border-radius: 25px; font-size: 16px; transition: box-shadow 0.3s ease; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            </div>
        </div>
    </section>

    <style>
        .form-control:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.25);
            outline: none;
        }
    </style>



<section class="section-t-space">
    <div class="custom-container container">
        <div class="row align-items-center">
            <div class="col-xl-12 col-lg-12 col-12">
                <div class="row gy-4 ratio_square" id="collection-list">
                    @foreach ($collections as $collection)
                        <div class="col-md-4 col-sm-6 col-12 collection-item">
                            <a class="banner mb-0 p-left bg-size" href="{{ route('collction.filter', [$collection->id]) }}" style="background-image: url('{{ url('public/uploads') }}/{{ $collection->image_path }}'); background-size: cover; background-position: center; background-repeat: no-repeat; display: block;">
                                <img class="bg-img" src="{{ url('public/uploads') }}/{{ $collection->image_path }}" alt="banner-img" style="display: none;">
                                <div class="banner-contain w-auto">
                                    <h4>{{ $collection->name }}</h4>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="pagination-wrap mt-0 my-5 mt-3">
                    {{ $collections->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
@section('website.js')
    <script src="{{ website_assets() }}/assets/js/filter-range-slider.js"></script>

    <script>
        document.getElementById('collection-search').addEventListener('input', function() {
            var searchQuery = this.value.toLowerCase();
            fetch(`{{ route('search-collections') }}?query=${searchQuery}`)
                .then(response => response.json())
                .then(data => {
                    var collectionList = document.getElementById('collection-list');
                    collectionList.innerHTML = '';
                    data.collections.forEach(function(collection) {
                        var collectionItem = `<div class="col-md-4 col-sm-6 col-12 collection-item">
                                                <a class="banner mb-0 p-left bg-size" href="${collection.url}" style="background-image: url('${collection.image_path}'); background-size: cover; background-position: center; background-repeat: no-repeat; display: block;">
                                                    <img class="bg-img" src="${collection.image_path}" alt="banner-img" style="display: none;">
                                                    <div class="banner-contain w-auto">
                                                        <h4>${collection.name}</h4>
                                                    </div>
                                                </a>
                                            </div>`;
                        collectionList.insertAdjacentHTML('beforeend', collectionItem);
                    });
                });
        });
    </script>
@endsection
