@if($colors->count() > 0)
    <table class="corporate-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Color Name</th>
                <th>Hex Code</th>
                <th>Preview</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($colors as $key => $color)
                <tr data-id="{{ $color->id }}">
                    <td>{{ ($colors->currentPage() - 1) * $colors->perPage() + $key + 1 }}</td>
                    <td>
                        <span class="color-name">{{ $color->name }}</span>
                    </td>
                    <td>
                        <span class="hex-code">{{ $color->hex_code }}</span>
                    </td>
                    <td>
                        <div class="color-preview" style="background-color: {{ $color->hex_code }}"></div>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('color.edit', $color->id) }}" class="btn-action btn-edit">
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
        <iconify-icon icon="solar:palette-bold-duotone"></iconify-icon>
        <h3>No Colors Found</h3>
        <p>Try adjusting your filters or create a new color</p>
    </div>
@endif
