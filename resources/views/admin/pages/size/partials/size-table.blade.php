@if($sizes->count() > 0)
    <table class="corporate-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Size Name</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sizes as $key => $size)
                <tr data-id="{{ $size->id }}">
                    <td>{{ ($sizes->currentPage() - 1) * $sizes->perPage() + $key + 1 }}</td>
                    <td>
                        <span class="size-name">{{ $size->name }}</span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('size.edit', $size->id) }}" class="btn-action btn-edit">
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
        <iconify-icon icon="solar:ruler-bold-duotone"></iconify-icon>
        <h3>No Sizes Found</h3>
        <p>Try adjusting your filters or create a new size</p>
    </div>
@endif
