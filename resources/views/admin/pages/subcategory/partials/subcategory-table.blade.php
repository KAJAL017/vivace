@if($sub_categories->count() > 0)
    <table class="corporate-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Subcategory Name</th>
                <th>Parent Category</th>
                <th>Status</th>
                <th>Top Bar</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sub_categories as $key => $sub_category)
                <tr data-id="{{ $sub_category->id }}">
                    <td>{{ ($sub_categories->currentPage() - 1) * $sub_categories->perPage() + $key + 1 }}</td>
                    <td>
                        <span class="subcategory-name">{{ $sub_category->name }}</span>
                    </td>
                    <td>
                        <span class="category-badge">{{ $sub_category->categoryname }}</span>
                    </td>
                    <td>
                        <label class="toggle-switch">
                            <input type="checkbox" class="status-toggle" data-id="{{ $sub_category->id }}" data-type="subcategory" 
                                   {{ $sub_category->is_active == 1 ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </td>
                    <td>
                        @if($sub_category->show_in_top_bar == 1)
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
                        <a href="{{ route('subcategories.edit', $sub_category->id) }}" class="btn-action btn-edit">
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
        <h3>No Subcategories Found</h3>
        <p>Try adjusting your filters or create a new subcategory</p>
    </div>
@endif
