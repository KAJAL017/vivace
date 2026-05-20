@if($categories->count() > 0)
    <table class="corporate-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Category Name</th>
                <th>Status</th>
                <th>Top Bar</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $key => $category)
                <tr data-id="{{ $category->id }}">
                    <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + $key + 1 }}</td>
                    <td>
                        @php
                            $catImgUrl = !empty($category->imagekit_url_desktop)
                                ? $category->imagekit_url_desktop
                                : (!empty($category->imagekit_url)
                                    ? $category->imagekit_url
                                    : upload_url($category->image));
                        @endphp
                        <div style="position:relative; display:inline-block;">
                            <img src="{{ $catImgUrl }}" alt="{{ $category->name }}" class="category-image">
                            @if(!empty($category->uploaded_to_imagekit))
                                <span style="position:absolute;top:-4px;right:-4px;background:#27ae60;color:#fff;font-size:9px;font-weight:700;padding:1px 4px;border-radius:3px;line-height:1.4;">IK</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <span class="category-name">{{ $category->name }}</span>
                    </td>
                    <td>
                        <label class="toggle-switch">
                            <input type="checkbox" class="status-toggle" data-id="{{ $category->id }}" data-type="category" 
                                   {{ $category->is_active == 1 ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </td>
                    <td>
                        @if($category->show_in_top_bar == 1)
                            <span class="status-badge active">
                                <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
                                Active
                            </span>
                        @else
                            <span class="status-badge inactive">
                                <iconify-icon icon="solar:close-circle-bold"></iconify-icon>
                                Inactive
                            </span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('category.edit', $category->id) }}" class="btn-action btn-edit">
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
        <iconify-icon icon="solar:folder-bold-duotone"></iconify-icon>
        <h3>No Categories Found</h3>
        <p>Try adjusting your filters or create a new category</p>
    </div>
@endif
