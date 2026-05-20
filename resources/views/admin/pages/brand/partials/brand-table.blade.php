@if($brands->count() > 0)
    <table class="corporate-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Logo</th>
                <th>Brand Name</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($brands as $key => $brand)
                <tr data-id="{{ $brand->id }}">
                    <td>{{ ($brands->currentPage() - 1) * $brands->perPage() + $key + 1 }}</td>
                    <td>
                        <img src="{{ url('uploads/'.$brand->image) }}" alt="{{ $brand->name }}" class="brand-logo">
                    </td>
                    <td>
                        <span class="brand-name">{{ $brand->name }}</span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('brand.edit', $brand->id) }}" class="btn-action btn-edit">
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
        <iconify-icon icon="solar:star-bold-duotone"></iconify-icon>
        <h3>No Brands Found</h3>
        <p>Try adjusting your filters or create a new brand</p>
    </div>
@endif
