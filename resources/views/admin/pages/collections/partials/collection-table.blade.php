@if(count($collections) > 0)
    <table class="corporate-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Collection Name</th>
                <th>Subcategory</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($collections as $key => $collection)
                <tr data-id="{{ $collection->id }}">
                    <td>{{ ($collections->currentPage() - 1) * $collections->perPage() + $key + 1 }}</td>
                    <td>
                        <span class="collection-name">{{ $collection->name }}</span>
                    </td>
                    <td>
                        <span class="category-badge">{{ $collection->categoryname ?? 'N/A' }}</span>
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
