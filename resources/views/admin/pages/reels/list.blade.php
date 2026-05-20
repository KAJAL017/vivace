@extends('admin.main.app')
@section('admin-title', 'Reels')
@section('topbar-text', 'Reels Management')

@section('admin-css')
<style>
    .reel-container { padding: 2rem 0; }
    .card-header-custom {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 12px 12px 0 0;
    }
    .card-header-custom h4 { color: white; margin: 0; font-weight: 700; font-size: 1.125rem; }
    .btn-add { background: #27ae60; color: white; padding: 0.625rem 1.25rem; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.875rem; transition: all 0.3s; }
    .btn-add:hover { background: #229954; color: white; }
    .reel-card { background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); overflow: hidden; }
    .table-wrap { padding: 1.5rem; overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th { background: #f8f9fa; color: #2c3e50; font-weight: 700; font-size: 0.8rem; text-transform: uppercase; padding: 0.875rem 1rem; border-bottom: 2px solid #e9ecef; }
    tbody td { padding: 0.875rem 1rem; border-bottom: 1px solid #f1f3f5; vertical-align: middle; font-size: 0.9rem; color: #495057; }
    tbody tr:hover { background: #f8f9fa; }
    .platform-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;
    }
    .platform-instagram { background: linear-gradient(135deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888); color: white; }
    .platform-facebook  { background: #1877f2; color: white; }
    .platform-youtube   { background: #ff0000; color: white; }
    .platform-other     { background: #6c757d; color: white; }
    .btn-action { padding: 0.4rem 0.875rem; border-radius: 6px; font-size: 0.8rem; font-weight: 600; border: none; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 4px; text-decoration: none; }
    .btn-edit   { background: #3498db; color: white; }
    .btn-edit:hover { background: #2980b9; color: white; }
    .btn-delete { background: #e74c3c; color: white; }
    .btn-delete:hover { background: #c0392b; color: white; }
    .reel-url { max-width: 220px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: block; color: #3498db; font-size: 0.8rem; }
    .form-switch .form-check-input { width: 2.2em; height: 1.2em; cursor: pointer; }
    .form-switch .form-check-input:checked { background-color: #27ae60; border-color: #27ae60; }
    .empty-state { text-align: center; padding: 3rem; color: #7f8c8d; }
</style>
@endsection

@section('admin-content')
<div class="container-xxl reel-container">
    <div class="reel-card">
        <div class="card-header-custom">
            <h4>
                <iconify-icon icon="solar:video-frame-play-bold-duotone" class="me-2"></iconify-icon>
                All Reels ({{ count($reels) }})
            </h4>
            <a href="{{ route('reels.create') }}" class="btn-add">+ Add Reel</a>
        </div>

        <div class="table-wrap">
            @if($reels->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Platform</th>
                        <th>Reel URL</th>
                        <th>Views</th>
                        <th>Product</th>
                        <th>Active</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reels as $key => $reel)
                    <tr data-id="{{ $reel->id }}">
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <span class="platform-badge platform-{{ $reel->platform }}">
                                @if($reel->platform === 'instagram')
                                    <iconify-icon icon="mdi:instagram"></iconify-icon> Instagram
                                @elseif($reel->platform === 'facebook')
                                    <iconify-icon icon="mdi:facebook"></iconify-icon> Facebook
                                @elseif($reel->platform === 'youtube')
                                    <iconify-icon icon="mdi:youtube"></iconify-icon> YouTube
                                @else
                                    <iconify-icon icon="mdi:link"></iconify-icon> Other
                                @endif
                            </span>
                        </td>
                        <td>
                            <a href="{{ $reel->reel_url }}" target="_blank" class="reel-url" title="{{ $reel->reel_url }}">
                                {{ $reel->reel_url }}
                            </a>
                        </td>
                        <td>
                            <span style="font-weight:600;">{{ number_format($reel->views ?? 0) }}</span>
                        </td>
                        <td>
                            @if($reel->product_name)
                                <span style="font-size:0.82rem;">{{ $reel->product_name }}</span>
                            @else
                                <span style="color:#aaa; font-size:0.82rem;">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input toggle-active"
                                       type="checkbox"
                                       {{ $reel->is_active ? 'checked' : '' }}>
                            </div>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('reels.edit', $reel->id) }}" class="btn-action btn-edit">
                                <iconify-icon icon="solar:pen-bold"></iconify-icon> Edit
                            </a>
                            <button class="btn-action btn-delete delete-btn ms-1">
                                <iconify-icon icon="solar:trash-bin-trash-bold"></iconify-icon> Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <iconify-icon icon="solar:video-frame-play-bold-duotone" style="font-size:3rem; opacity:0.3; display:block; margin-bottom:1rem;"></iconify-icon>
                <h5>No Reels Added Yet</h5>
                <p>Add your first Instagram / Facebook / YouTube reel</p>
                <a href="{{ route('reels.create') }}" class="btn-add">+ Add Reel</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('admin-js')
<script>
$(document).ready(function(){
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    var deleteUrl  = "{{ route('reels.destroy', ['reel' => ':id']) }}";
    var toggleUrl  = "{{ route('reels.toggle.active') }}";

    // Toggle active
    $(document).on('change', '.toggle-active', function(){
        var row = $(this).closest('tr');
        var id  = row.data('id');
        var cb  = $(this);
        $.post(toggleUrl, { id: id }, function(res){
            if(!res.success) cb.prop('checked', !cb.prop('checked'));
        });
    });

    // Delete
    $(document).on('click', '.delete-btn', function(){
        var row = $(this).closest('tr');
        var id  = row.data('id');
        var url = deleteUrl.replace(':id', id);
        Swal.fire({
            title: 'Delete Reel?',
            text: 'This cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Delete'
        }).then(result => {
            if(result.isConfirmed){
                $.ajax({ url: url, method: 'DELETE', success: function(res){
                    if(res.success){
                        row.fadeOut(300, function(){ $(this).remove(); });
                        Swal.fire({ icon:'success', title:'Deleted!', timer:1500, showConfirmButton:false });
                    }
                }});
            }
        });
    });
});
</script>
@endsection
