@extends('website.main.app')
@section('title','Page Not Found')
@section('website.content')
<section class="section-b-space pt-0">
    <div class="heading-banner">
      <div class="custom-container container">
        <div class="row align-items-center">
          <div class="col-sm-6">
            <h4>404</h4>
          </div>
          <div class="col-sm-6">
            <ul class="breadcrumb float-end">
              <li class="breadcrumb-item"> <a href="{{ route('website.home') }}">Home /</a></li>
              <li class=" active"> <a href="#">404</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="section-b-space pt-0">
    <div class="custom-container container error-img">
      <div class="row g-4">
        <div class="col-12 px-0"> <a href="#"><img class="img-fluid" src="{{ website_assets() }}/assets/images/other-img/404.png" alt=""></a></div>
        <div class="col-12">
          <h2>Page Not Found </h2>
          <p>The page you are looking for doesn't exist or an other error occurred. Go back, or head over to choose a new direction. </p>
          <a class="btn btn_black rounded" href="{{ route('website.home') }}">
            Back Home Page
            <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 8h12M10 4l4 4-4 4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>

        </div>
      </div>
    </div>
  </section>
@endsection
