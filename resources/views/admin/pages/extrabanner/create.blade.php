@php
if (isset($banners)) {
$id = $banners->id;
$banner = $banners->banner;
$update = true;
} else {
$id = '';
$banner_text = '';
$banner = '';
$update = false;
}
@endphp
@extends('admin.main.app')
@section('admin-title', 'Create Banner')
@section('admin-content')
<div class="container-fluid">
   <div class="card">
      <div class="card-body">
         <h4> {{ $update == true ? 'Edit' : 'Add' }} Banner</h4>
      </div>
   </div>
   <div class="row">
      <div class="col-xl-12">
         <div class="card">
            <div class="card-body">
               <div class="mb-3">
                  <div class="row" style="; padding: 20px;">
                     <div class="col-lg-6"
                        style="padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px; background-color: #f9f9f9;">
                        <form id="categoryForm1" class="needs-validation" novalidate
                           enctype="multipart/form-data"
                           style="display: flex; flex-direction: column; gap: 15px;">
                           @csrf
                           @php
                           $banner_table_1 = DB::table('banner_table_1')->first();
                           @endphp
                           <div>
                              <label for="banner1" class="form-label" style="font-weight: bold;">Banner
                              1 (650px X 297px)</label>
                              <input type="file" name="banner" class="form-control" id="banner1"
                                 required>
                              <input type="text" name="link" class="form-control my-2"
                                 placeholder="Enter Your Url" value="{{ $banner_table_1->link ?? '' }}">
                           </div>
                           <div>
                              @if ($banner_table_1 && $banner_table_1->banner)
                              <img src="{{ url('public/uploads') }}/{{ $banner_table_1->banner }}"
                                 alt="Banner 1"
                                 style="width: 100%; max-height: 200px; object-fit: contain; border: 1px solid #ddd; border-radius: 5px;">
                              @else
                              <p>No Banner Image Found</p>
                              @endif
                           </div>
                           @if ($banner_table_1)
                           <input value="{{ $banner_table_1->id }}" type="hidden" name="id">
                           @endif
                           <div>
                              <button class="btn btn-primary w-100" type="submit"
                                 style="padding: 10px 0; font-size: 16px;">Submit</button>
                           </div>
                        </form>
                     </div>
                     <div class="col-lg-6"
                        style="padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px; background-color: #f9f9f9;">
                        <form id="categoryForm2" class="needs-validation" novalidate
                           enctype="multipart/form-data"
                           style="display: flex; flex-direction: column; gap: 15px;">
                           @csrf
                           @php
                           $banner_table_2 = DB::table('banner_table_2')->first();
                           @endphp
                           <div>
                              <label for="banner2" class="form-label" style="font-weight: bold;">Banner
                              2 </label>
                              <input type="file" name="banner" class="form-control" id="banner2"
                                 required>
                              <input type="text" name="link" class="form-control my-2"
                                 placeholder="Enter Your Url" value="{{ $banner_table_2->link ?? '' }}">
                           </div>
                           <div>
                              @if ($banner_table_2 && $banner_table_2->banner)
                              <img src="{{ url('public/uploads') }}/{{ $banner_table_2->banner }}"
                                 alt="Banner 1"
                                 style="width: 100%; max-height: 200px; object-fit: contain; border: 1px solid #ddd; border-radius: 5px;">
                              @else
                              <p>No Banner Image Found</p>
                              @endif
                           </div>
                           @if ($banner_table_2)
                           <input value="{{ $banner_table_2->id }}" type="hidden" name="id">
                           @endif
                           <div>
                              <button class="btn btn-primary w-100" type="submit"
                                 style="padding: 10px 0; font-size: 16px;">Submit</button>
                           </div>
                        </form>
                     </div>
                     <div class="col-lg-6"
                        style="padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px; background-color: #f9f9f9;">
                        <form id="categoryForm3" class="needs-validation" novalidate
                           enctype="multipart/form-data"
                           style="display: flex; flex-direction: column; gap: 15px;">
                           @csrf
                           @php
                           $banner_table_3 = DB::table('banner_table_3')->first();
                           @endphp
                           <div>
                              <label for="banner3" class="form-label" style="font-weight: bold;">Banner
                              3</label>
                              <input type="file" name="banner" class="form-control" id="banner3"
                                 required>
                                 <input type="text" name="link" class="form-control my-2"
                                 placeholder="Enter Your Url" value="{{ $banner_table_3->link ?? '' }}">
                           </div>

                           <div>
                              @if ($banner_table_3 && $banner_table_3->banner)
                              <img src="{{ url('public/uploads') }}/{{ $banner_table_3->banner }}"
                                 alt="Banner 1"
                                 style="width: 100%; max-height: 200px; object-fit: contain; border: 1px solid #ddd; border-radius: 5px;">
                              @else
                              <p>No Banner Image Found</p>
                              @endif
                           </div>
                           @if ($banner_table_3)
                           <input value="{{ $banner_table_3->id }}" type="hidden" name="id">
                           @endif
                           <div>
                              <button class="btn btn-primary w-100" type="submit"
                                 style="padding: 10px 0; font-size: 16px;">Submit</button>
                           </div>
                        </form>
                     </div>
                     <div class="col-lg-6"
                        style="padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px; background-color: #f9f9f9;">
                        <form id="categoryForm4" class="needs-validation" novalidate
                           enctype="multipart/form-data"
                           style="display: flex; flex-direction: column; gap: 15px;">
                           @csrf
                           @php
                           $banner_table_4 = DB::table('banner_table_4')->first();
                           @endphp
                           <div>
                              <label for="banner4" class="form-label" style="font-weight: bold;">Banner
                              4</label>
                              <input type="file" name="banner" class="form-control" id="banner4"
                                 required>
                                 <input type="text" name="link" class="form-control my-2"
                                 placeholder="Enter Your Url" value="{{ $banner_table_4->link ?? '' }}">
                           </div>

                           <div>
                              @if ($banner_table_4 && $banner_table_4->banner)
                              <img src="{{ url('public/uploads') }}/{{ $banner_table_4->banner }}"
                                 alt="Banner 1"
                                 style="width: 100%; max-height: 200px; object-fit: contain; border: 1px solid #ddd; border-radius: 5px;">
                              @else
                              <p>No Banner Image Found</p>
                              @endif
                           </div>
                           @if ($banner_table_4)
                           <input value="{{ $banner_table_4->id }}" type="hidden" name="id">
                           @endif
                           <div>
                              <button class="btn btn-primary w-100" type="submit"
                                 style="padding: 10px 0; font-size: 16px;">Submit</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end col -->
   </div>
   <!-- end row -->
</div>
@endsection
@section('admin-js')
<script>
   $(document).ready(function() {
       $('#categoryForm1').on('submit', function(e) {
           e.preventDefault();
           submitForm(this, "{{ route('extra-banner.store1') }}",
               "{{ route('extra-banner.create') }}");
       });

       // Handle form 2 submission
       $('#categoryForm2').on('submit', function(e) {
           e.preventDefault();
           submitForm(this, "{{ route('extra-banner.store2') }}",
               "{{ route('extra-banner.create') }}");
       });

       // Handle form 3 submission
       $('#categoryForm3').on('submit', function(e) {
           e.preventDefault();
           submitForm(this, "{{ route('extra-banner.store3') }}",
               "{{ route('extra-banner.create') }}");
       });

       // Handle form 4 submission
       $('#categoryForm4').on('submit', function(e) {
           e.preventDefault();
           submitForm(this, "{{ route('extra-banner.store4') }}",
               "{{ route('extra-banner.create') }}");
       });

       // Common function for form submission
       function submitForm(form, postUrl, redirectUrl) {
           var formData = new FormData(form);

           $.ajax({
               url: postUrl,
               method: "POST",
               data: formData,
               contentType: false,
               processData: false,
               success: function(response) {
                   if (response.status === 'success') {
                       Swal.fire({
                           icon: 'success',
                           title: 'Success',
                           text: response.message,
                           confirmButtonText: 'OK'
                       }).then(function() {
                           window.location.href = redirectUrl;
                       });
                   }
               },
               error: function(xhr) {
                   if (xhr.status === 422) {
                       // Handle validation errors
                       let errors = xhr.responseJSON.errors;
                       let errorMessages = '';
                       $.each(errors, function(key, value) {
                           errorMessages += value + '\n';
                       });
                       Swal.fire({
                           icon: 'error',
                           title: 'Validation Error',
                           text: errorMessages,
                       });
                   } else {
                       Swal.fire({
                           icon: 'error',
                           title: 'Error',
                           text: 'An unexpected error occurred.',
                       });
                   }
               }
           });
       }
   });
</script>
@endsection
