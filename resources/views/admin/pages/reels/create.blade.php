@php
    $isUpdate  = isset($reel);
    $reelId    = $reel->id         ?? '';
    $views     = $reel->views      ?? 0;
    $productId = $reel->product_id ?? '';
    $videoUrl  = $reel->video_url  ?? '';
    $sortOrder = $reel->sort_order ?? 0;
@endphp

@extends('admin.main.app')
@section('admin-title', $isUpdate ? 'Edit Reel' : 'Add Reel')
@section('topbar-text', $isUpdate ? 'Edit Reel' : 'Add New Reel')

@section('admin-css')
<style>
    .reel-form-wrap { padding: 2rem 0; }
    .form-card { background:white; border-radius:16px; box-shadow:0 4px 20px rgba(0,0,0,0.08); overflow:hidden; }
    .form-card-header {
        background: linear-gradient(135deg,#2c3e50,#34495e);
        padding: 1.5rem 2rem;
        display: flex; justify-content: space-between; align-items: center;
    }
    .form-card-header h4 { color:white; margin:0; font-weight:700; font-size:1.2rem; }
    .form-card-body { padding: 2rem; }
    .form-label { font-weight:600; color:#2c3e50; font-size:0.875rem; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px; display:block; }
    .form-control, .form-select { border:2px solid #e9ecef; border-radius:10px; padding:0.75rem 1rem; font-size:0.9375rem; transition:all 0.3s; width:100%; }
    .form-control:focus, .form-select:focus { border-color:#e74c3c; box-shadow:0 0 0 0.2rem rgba(231,76,60,0.15); outline:none; }

    /* Video upload area */
    .video-upload-area {
        border: 2px dashed #e9ecef;
        border-radius: 12px;
        padding: 2.5rem;
        text-align: center;
        cursor: pointer;
        background: #f8f9fa;
        transition: all 0.3s;
    }
    .video-upload-area:hover { border-color:#e74c3c; background:#fff5f5; }
    .video-upload-area.has-video { border-style:solid; border-color:#27ae60; background:#f0fff4; }
    .video-upload-area iconify-icon { font-size:3rem; color:#95a5a6; display:block; margin-bottom:0.75rem; }
    .video-upload-area.has-video iconify-icon { color:#27ae60; }

    /* Video preview */
    .video-preview { margin-top:1rem; border-radius:12px; overflow:hidden; background:#000; }
    .video-preview video { width:100%; max-height:300px; display:block; }

    .btn-save { background:linear-gradient(135deg,#27ae60,#229954); border:none; color:white; padding:0.75rem 2.5rem; border-radius:10px; font-weight:700; font-size:1rem; cursor:pointer; transition:all 0.3s; }
    .btn-save:hover { transform:translateY(-2px); box-shadow:0 4px 15px rgba(39,174,96,0.35); }
    .btn-back-link { background:transparent; border:2px solid #6c757d; color:#6c757d; padding:0.75rem 2rem; border-radius:10px; font-weight:600; text-decoration:none; transition:all 0.3s; }
    .btn-back-link:hover { background:#6c757d; color:white; }

    .upload-progress { display:none; margin-top:1rem; }
    .progress { height:8px; border-radius:4px; background:#e9ecef; overflow:hidden; }
    .progress-bar { height:100%; background:linear-gradient(135deg,#27ae60,#229954); transition:width 0.3s; border-radius:4px; }
</style>
@endsection

@section('admin-content')
<div class="container-xxl reel-form-wrap">
    <div class="form-card">
        <div class="form-card-header">
            <h4>
                <iconify-icon icon="solar:video-frame-play-bold-duotone" class="me-2"></iconify-icon>
                {{ $isUpdate ? 'Edit Reel' : 'Add New Reel' }}
            </h4>
            <a href="{{ route('reels.index') }}" class="btn btn-light btn-sm">← Back</a>
        </div>

        <div class="form-card-body">
            <form id="reelForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $reelId }}">
                <input type="hidden" name="sort_order" value="{{ $sortOrder }}">

                <div class="row g-4">

                    {{-- Video Upload --}}
                    <div class="col-12">
                        <label class="form-label">
                            Video File
                            @if(!$isUpdate) <span style="color:#e74c3c">*</span> @endif
                        </label>

                        <div class="video-upload-area {{ $videoUrl ? 'has-video' : '' }}"
                             id="uploadArea"
                             onclick="document.getElementById('videoInput').click()">
                            <iconify-icon icon="solar:video-frame-play-bold-duotone"></iconify-icon>
                            <div style="font-weight:600; color:#495057; margin-bottom:4px;">
                                {{ $videoUrl ? 'Click to replace video' : 'Click to upload video' }}
                            </div>
                            <div style="font-size:0.8rem; color:#7f8c8d;">
                                MP4, WebM, MOV — max 100MB · Will be stored on ImageKit CDN
                            </div>
                        </div>
                        <input type="file" name="video_file" id="videoInput"
                               class="d-none" accept="video/mp4,video/webm,video/quicktime,video/avi">

                        {{-- Upload progress --}}
                        <div class="upload-progress" id="uploadProgress">
                            <div class="d-flex justify-content-between mb-1">
                                <small style="font-weight:600; color:#27ae60;">Uploading to ImageKit...</small>
                                <small id="progressPct">0%</small>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" id="progressBar" style="width:0%"></div>
                            </div>
                        </div>

                        {{-- New file preview --}}
                        <div class="video-preview d-none" id="newVideoPreview">
                            <video id="newVideoEl" controls muted style="width:100%; max-height:280px;"></video>
                        </div>

                        {{-- Current video (edit mode) --}}
                        @if($isUpdate && $videoUrl)
                        <div class="mt-3" id="currentVideoWrap">
                            <label class="form-label">Current Video:</label>
                            <div class="video-preview">
                                <video src="{{ $videoUrl }}" controls muted style="width:100%; max-height:280px;"></video>
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- Views --}}
                    <div class="col-md-4">
                        <label class="form-label">Views Count</label>
                        <input type="number" name="views" class="form-control"
                               placeholder="e.g. 12500" value="{{ $views }}" min="0">
                        <small class="text-muted" style="font-size:0.78rem;">Display view count on home page</small>
                    </div>

                    {{-- Product --}}
                    <div class="col-md-8">
                        <label class="form-label">Linked Product</label>
                        <select name="product_id" id="productSelect" class="form-select">
                            <option value="">— No product linked —</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}"
                                    {{ $productId == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted" style="font-size:0.78rem;">Click on video → goes to this product page</small>
                    </div>

                </div>

                <div class="d-flex gap-3 mt-4 pt-3" style="border-top:2px solid #f1f3f5;">
                    <a href="{{ route('reels.index') }}" class="btn-back-link">Cancel</a>
                    <button type="submit" class="btn-save" id="submitBtn">
                        {{ $isUpdate ? 'Update Reel' : 'Save Reel' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('admin-js')
<script>
$(document).ready(function(){

    // Video file select — show preview
    $('#videoInput').on('change', function(){
        var file = this.files[0];
        if (!file) return;

        // Show filename in upload area
        $('#uploadArea').addClass('has-video');
        $('#uploadArea div:first-of-type').text('Selected: ' + file.name);

        // Local preview
        var url = URL.createObjectURL(file);
        $('#newVideoEl').attr('src', url);
        $('#newVideoPreview').removeClass('d-none');
        $('#currentVideoWrap').hide();
    });

    // Select2
    $('#productSelect').select2({ placeholder:'— No product linked —', allowClear:true });

    // Form submit
    $('#reelForm').on('submit', function(e){
        e.preventDefault();

        var fd = new FormData(this);
        var hasFile = $('#videoInput')[0].files.length > 0;

        @if(!$isUpdate)
        if (!hasFile) {
            Swal.fire({ icon:'warning', title:'No video selected', text:'Please select a video file to upload.', confirmButtonColor:'#e74c3c' });
            return;
        }
        @endif

        // Show progress UI
        $('#submitBtn').prop('disabled', true).text('Uploading...');
        if (hasFile) {
            $('#uploadProgress').show();
        } else {
            Swal.fire({ title:'Saving...', allowOutsideClick:false, didOpen:()=>Swal.showLoading() });
        }

        $.ajax({
            url: "{{ route('reels.store') }}",
            method: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            xhr: function(){
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(e){
                    if (e.lengthComputable) {
                        var pct = Math.round((e.loaded / e.total) * 100);
                        $('#progressBar').css('width', pct + '%');
                        $('#progressPct').text(pct + '%');
                    }
                }, false);
                return xhr;
            },
            success: function(res){
                Swal.close();
                if (res.status === 'success') {
                    Swal.fire({ icon:'success', title:'Done!', text:res.message, confirmButtonColor:'#27ae60' })
                    .then(()=> window.location.href = "{{ route('reels.index') }}");
                } else {
                    $('#submitBtn').prop('disabled', false).text('{{ $isUpdate ? "Update Reel" : "Save Reel" }}');
                    Swal.fire({ icon:'error', title:'Error', text:res.message, confirmButtonColor:'#e74c3c' });
                }
            },
            error: function(xhr){
                Swal.close();
                $('#submitBtn').prop('disabled', false).text('{{ $isUpdate ? "Update Reel" : "Save Reel" }}');
                var msg = 'Something went wrong.';
                if (xhr.status === 422) {
                    msg = Object.values(xhr.responseJSON.errors).map(e=>e[0]).join('\n');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire({ icon:'error', title:'Error', text:msg, confirmButtonColor:'#e74c3c' });
            }
        });
    });
});
</script>
@endsection
