@if($tags->count() > 0)
    <table class="corporate-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Tag Name</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tags as $key => $tag)
                <tr data-id="{{ $tag->id }}">
                    <td>{{ ($tags->currentPage() - 1) * $tags->perPage() + $key + 1 }}</td>
                    <td>
                        <span class="tag-badge">
                            <iconify-icon icon="solar:tag-bold"></iconify-icon>
                            {{ $tag->name }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('tag.edit', $tag->id) }}" class="btn-action btn-edit">
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
        <iconify-icon icon="solar:tag-bold-duotone"></iconify-icon>
        <h3>No Tags Found</h3>
        <p>Try adjusting your filters or create a new tag</p>
    </div>
@endif
