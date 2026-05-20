@if(count($collections) > 0)
    <table class="corporate-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Collection Name</th>
                <th>Subcategory</th>
                <th>Status</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($collections as $key => $collection)
                <tr data-id="{{ $collection->id }}">
                    <td>{{ ($collections->currentPage() - 1) * $collections->perPage() + $key + 1 }}</td>
                    <td>
                        @php
                            $colImg = !empty($collection->imagekit_url_desktop)
                                ? $collection->imagekit_url_desktop
                                : (!empty($collection->imagekit_url)
                                    ? $collection->imagekit_url
                                    : ($collection->image_path ? upload_url($collection->image_path) : null));
                        @endphp
                        @if($colImg)
                            <div style="position:relative; display:inline-block;">
                                <img src="{{ $colImg }}"
                                     alt="{{ $collection->name }}"
                                     style="width:60px; height:60px; object-fit:cover; border-radius:8px; border:2px solid #e9ecef;"
                                     onerror="this.src='{{ url('public/5.png') }}'">
                                @if(!empty($collection->uploaded_to_imagekit))
                                    <span style="position:absolute;top:-4px;right:-4px;background:#27ae60;color:#fff;font-size:9px;font-weight:700;padding:1px 4px;border-radius:3px;line-height:1.4;">IK</span>
                                @endif
                            </div>
                        @else
                            <span style="color:#aaa; font-size:12px;">No image</span>
                        @endif
                    </td>
                    <td>
                        <span class="collection-name">{{ $collection->name }}</span>
                    </td>
                    <td>
                        <span class="category-badge">{{ $collection->categoryname ?? 'N/A' }}</span>
                    </td>
                    <td>
                        <label class="toggle-switch">
                            <input type="checkbox" class="status-toggle" data-id="{{ $collection->id }}" data-type="collection" 
                                   {{ $collection->is_active == 1 ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('collections.edit', $collection->id) }}" class="btn-action btn-edit">
                            <iconify-icon icon="solar:pen-bold"></iconify-icon>
                            Edit
                        </a>
                        <button class="btn-action btn-delete delete-btn ms-2">
                            <iconify-icon icon="solar:trash-bin-trash-bold"></iconify-icon>
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="empty-state">
        <iconify-icon icon="solar:gallery-bold-duotone"></iconify-icon>
        <h3>No Collections Found</h3>
        <p>Try adjusting your filters or create a new collection</p>
    </div>
@endif
