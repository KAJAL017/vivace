@extends('admin.main.app')
@section('admin-title', 'Extra Banners')
@section('topbar-text', 'Extra Banner Management')

@section('admin-css')
<style>
    /* Corporate Extra Banner Management */
    .extra-banner-container {
        padding: 2rem 0;
    }
    
    .page-header {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    
    .page-header h2 {
        color: white;
        margin: 0;
        font-weight: 700;
        font-size: 1.75rem;
    }
    
    .page-header p {
        color: rgba(255, 255, 255, 0.8);
        margin: 0.5rem 0 0 0;
        font-size: 0.95rem;
    }
    
    .banner-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
    }
    
    .banner-section {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .banner-section:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        border-color: #2c3e50;
    }
    
    .banner-header {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .banner-header iconify-icon {
        font-size: 1.75rem;
        color: white;
    }
    
    .banner-header h4 {
        color: white;
        margin: 0;
        font-weight: 700;
        font-size: 1.125rem;
    }
    
    .banner-body {
        padding: 1.5rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
    }
    
    .form-control:focus {
        border-color: #2c3e50;
        box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.15);
    }
    
    .image-preview-box {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 1rem;
        background: #f8f9fa;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .image-preview-box img {
        width: 100%;
        height: auto;
        display: block;
    }
    
    .no-image-text {
        color: #95a5a6;
        font-size: 0.9375rem;
        text-align: center;
        padding: 2rem;
    }
    
    .no-image-text iconify-icon {
        font-size: 3rem;
        display: block;
        margin-bottom: 0.5rem;
        opacity: 0.5;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        width: 100%;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
    }
    
    .size-hint {
        background: #fff3cd;
        border: 1px solid #ffc107;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        font-size: 0.8125rem;
        color: #856404;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .size-hint iconify-icon {
        font-size: 1.125rem;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .banner-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('admin-content')
<div class="container-fluid extra-banner-container">
    
    <!-- Page Header -->
    <div class="page-header">
        <h2>🎨 Extra Banners Management</h2>
        <p>Manage additional promotional banners for different sections of your website</p>
    </div>
    
    <div class="banner-grid">
        
        <!-- Banner 1 -->
        <div class="banner-section">
            <div class="banner-header">
                <iconify-icon icon="solar:gallery-bold"></iconify-icon>
                <h4>Banner 1</h4>
            </div>
            <div class="banner-body">
                <form id="categoryForm1" enctype="multipart/form-data">
                    @csrf
                    @php
                        $banner_table_1 = DB::table('banner_table_1')->first();
                    @endphp
                    
                    <div class="size-hint">
                        <iconify-icon icon="solar:info-circle-bold"></iconify-icon>
                        <span>Recommended size: 650px × 297px</span>
                    </div>
                    
                    <label class="form-label">Banner Image</label>
                    <input type="file" name="banner" class="form-control" id="banner1" accept="image/*">
                    
                    <label class="form-label">Banner Link (Optional)</label>
                    <input type="text" name="link" class="form-control" placeholder="https://example.com" value="{{ $banner_table_1->link ?? '' }}">
                    
                    <div class="image-preview-box">
                        @if ($banner_table_1 && $banner_table_1->banner)
                            <img src="{{ url('public/uploads') }}/{{ $banner_table_1->banner }}" alt="Banner 1">
                        @else
                            <div class="no-image-text">
                                <iconify-icon icon="solar:gallery-broken"></iconify-icon>
                                <p>No banner uploaded yet</p>
                            </div>
                        @endif
                    </div>
                    
                    @if ($banner_table_1)
                        <input value="{{ $banner_table_1->id }}" type="hidden" name="id">
                    @endif
                    
                    <button class="btn-submit" type="submit">
                        <iconify-icon icon="solar:upload-bold"></iconify-icon>
                        {{ $banner_table_1 ? 'Update Banner 1' : 'Upload Banner 1' }}
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Banner 2 -->
        <div class="banner-section">
            <div class="banner-header">
                <iconify-icon icon="solar:gallery-bold"></iconify-icon>
                <h4>Banner 2</h4>
            </div>
            <div class="banner-body">
                <form id="categoryForm2" enctype="multipart/form-data">
                    @csrf
                    @php
                        $banner_table_2 = DB::table('banner_table_2')->first();
                    @endphp
                    
                    <div class="size-hint">
                        <iconify-icon icon="solar:info-circle-bold"></iconify-icon>
                        <span>Recommended size: 650px × 297px</span>
                    </div>
                    
                    <label class="form-label">Banner Image</label>
                    <input type="file" name="banner" class="form-control" id="banner2" accept="image/*">
                    
                    <label class="form-label">Banner Link (Optional)</label>
                    <input type="text" name="link" class="form-control" placeholder="https://example.com" value="{{ $banner_table_2->link ?? '' }}">
                    
                    <div class="image-preview-box">
                        @if ($banner_table_2 && $banner_table_2->banner)
                            <img src="{{ url('public/uploads') }}/{{ $banner_table_2->banner }}" alt="Banner 2">
                        @else
                            <div class="no-image-text">
                                <iconify-icon icon="solar:gallery-broken"></iconify-icon>
                                <p>No banner uploaded yet</p>
                            </div>
                        @endif
                    </div>
                    
                    @if ($banner_table_2)
                        <input value="{{ $banner_table_2->id }}" type="hidden" name="id">
                    @endif
                    
                    <button class="btn-submit" type="submit">
                        <iconify-icon icon="solar:upload-bold"></iconify-icon>
                        {{ $banner_table_2 ? 'Update Banner 2' : 'Upload Banner 2' }}
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Banner 3 -->
        <div class="banner-section">
            <div class="banner-header">
                <iconify-icon icon="solar:gallery-bold"></iconify-icon>
                <h4>Banner 3</h4>
            </div>
            <div class="banner-body">
                <form id="categoryForm3" enctype="multipart/form-data">
                    @csrf
                    @php
                        $banner_table_3 = DB::table('banner_table_3')->first();
                    @endphp
                    
                    <div class="size-hint">
                        <iconify-icon icon="solar:info-circle-bold"></iconify-icon>
                        <span>Recommended size: 650px × 297px</span>
                    </div>
                    
                    <label class="form-label">Banner Image</label>
                    <input type="file" name="banner" class="form-control" id="banner3" accept="image/*">
                    
                    <label class="form-label">Banner Link (Optional)</label>
                    <input type="text" name="link" class="form-control" placeholder="https://example.com" value="{{ $banner_table_3->link ?? '' }}">
                    
                    <div class="image-preview-box">
                        @if ($banner_table_3 && $banner_table_3->banner)
                            <img src="{{ url('public/uploads') }}/{{ $banner_table_3->banner }}" alt="Banner 3">
                        @else
                            <div class="no-image-text">
                                <iconify-icon icon="solar:gallery-broken"></iconify-icon>
                                <p>No banner uploaded yet</p>
                            </div>
                        @endif
                    </div>
                    
                    @if ($banner_table_3)
                        <input value="{{ $banner_table_3->id }}" type="hidden" name="id">
                    @endif
                    
                    <button class="btn-submit" type="submit">
                        <iconify-icon icon="solar:upload-bold"></iconify-icon>
                        {{ $banner_table_3 ? 'Update Banner 3' : 'Upload Banner 3' }}
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Banner 4 -->
        <div class="banner-section">
            <div class="banner-header">
                <iconify-icon icon="solar:gallery-bold"></iconify-icon>
                <h4>Banner 4</h4>
            </div>
            <div class="banner-body">
                <form id="categoryForm4" enctype="multipart/form-data">
                    @csrf
                    @php
                        $banner_table_4 = DB::table('banner_table_4')->first();
                    @endphp
                    
                    <div class="size-hint">
                        <iconify-icon icon="solar:info-circle-bold"></iconify-icon>
                        <span>Recommended size: 650px × 297px</span>
                    </div>
                    
                    <label class="form-label">Banner Image</label>
                    <input type="file" name="banner" class="form-control" id="banner4" accept="image/*">
                    
                    <label class="form-label">Banner Link (Optional)</label>
                    <input type="text" name="link" class="form-control" placeholder="https://example.com" value="{{ $banner_table_4->link ?? '' }}">
                    
                    <div class="image-preview-box">
                        @if ($banner_table_4 && $banner_table_4->banner)
                            <img src="{{ url('public/uploads') }}/{{ $banner_table_4->banner }}" alt="Banner 4">
                        @else
                            <div class="no-image-text">
                                <iconify-icon icon="solar:gallery-broken"></iconify-icon>
                                <p>No banner uploaded yet</p>
                            </div>
                        @endif
                    </div>
                    
                    @if ($banner_table_4)
                        <input value="{{ $banner_table_4->id }}" type="hidden" name="id">
                    @endif
                    
                    <button class="btn-submit" type="submit">
                        <iconify-icon icon="solar:upload-bold"></iconify-icon>
                        {{ $banner_table_4 ? 'Update Banner 4' : 'Upload Banner 4' }}
                    </button>
                </form>
            </div>
        </div>
        
    </div>
</div>
@endsection

@section('admin-js')
<script>
    $(document).ready(function() {
        $('#categoryForm1').on('submit', function(e) {
            e.preventDefault();
            submitForm(this, "{{ route('extra-banner.store1') }}", "{{ route('extra-banner.create') }}");
        });

        $('#categoryForm2').on('submit', function(e) {
            e.preventDefault();
            submitForm(this, "{{ route('extra-banner.store2') }}", "{{ route('extra-banner.create') }}");
        });

        $('#categoryForm3').on('submit', function(e) {
            e.preventDefault();
            submitForm(this, "{{ route('extra-banner.store3') }}", "{{ route('extra-banner.create') }}");
        });

        $('#categoryForm4').on('submit', function(e) {
            e.preventDefault();
            submitForm(this, "{{ route('extra-banner.store4') }}", "{{ route('extra-banner.create') }}");
        });

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
                            title: 'Success!',
                            text: response.message,
                            confirmButtonColor: '#27ae60',
                            confirmButtonText: 'OK'
                        }).then(function() {
                            window.location.href = redirectUrl;
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = '';
                        $.each(errors, function(key, value) {
                            errorMessages += value + '<br>';
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            html: errorMessages,
                            confirmButtonColor: '#e74c3c'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An unexpected error occurred.',
                            confirmButtonColor: '#e74c3c'
                        });
                    }
                }
            });
        }
    });
</script>
@endsection
