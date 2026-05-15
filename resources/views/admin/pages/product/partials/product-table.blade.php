<div class="table-container">
    <table class="product-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 25%;">Product</th>
                <th style="width: 10%;">Category</th>
                <th style="width: 10%;">Subcategory</th>
                <th style="width: 10%;">Brand</th>
                <th style="width: 10%;">Collection</th>
                <th style="width: 10%;">Stock/Qty</th>
                <th style="width: 20%;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $key => $product)
            @php
                // Get all product attributes with stock
                $attributes = DB::table('product_attributes')
                    ->leftJoin('sizes', 'product_attributes.size_id', '=', 'sizes.id')
                    ->leftJoin('colors', 'product_attributes.color_id', '=', 'colors.id')
                    ->where('product_attributes.product_id', $product->id)
                    ->select('product_attributes.*', 'sizes.name as size_name', 'colors.name as color_name')
                    ->get();
                    
                $totalStock = $attributes->sum('qty');
            @endphp
            <tr data-id="{{ $product->id }}">
                <td>{{ $products->firstItem() + $key }}</td>
                <td>
                    <div class="product-image-cell">
                        <img src="{{ url('public/') }}/{{ Product_first_image($product->id) }}" 
                             alt="{{ $product->name }}" class="product-thumb">
                        <span class="product-name">{{ $product->name }}</span>
                    </div>
                </td>
                <td>
                    <span class="badge-custom badge-category">{{ $product->categoryname ?? 'N/A' }}</span>
                </td>
                <td>
                    <span class="badge-custom badge-subcategory">{{ $product->subcategoryname ?? 'N/A' }}</span>
                </td>
                <td>
                    <span class="badge-custom badge-brand">{{ $product->brandname ?? 'N/A' }}</span>
                </td>
                <td>
                    <span class="badge-custom badge-collection">{{ $product->collectionName ?? 'N/A' }}</span>
                </td>
                <td>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        @if($totalStock <= 0)
                            <span class="badge-custom" style="background: #fee; color: #c00; font-weight: 700;">
                                <iconify-icon icon="solar:close-circle-bold" style="font-size: 1rem;"></iconify-icon>
                                Out of Stock
                            </span>
                        @elseif($totalStock <= 10)
                            <span class="badge-custom" style="background: #fff3cd; color: #856404; font-weight: 700;">
                                <iconify-icon icon="solar:danger-bold" style="font-size: 1rem;"></iconify-icon>
                                Low Stock
                            </span>
                        @else
                            <span class="badge-custom" style="background: #d1e7dd; color: #0f5132; font-weight: 700;">
                                <iconify-icon icon="solar:check-circle-bold" style="font-size: 1rem;"></iconify-icon>
                                In Stock
                            </span>
                        @endif
                        
                        @if($attributes->count() > 0)
                            <button class="btn-action" style="background: #3498db; color: white; font-size: 0.75rem; padding: 0.375rem 0.75rem;" 
                                    onclick="showStockModal({{ $product->id }}, '{{ $product->name }}', {{ json_encode($attributes) }})">
                                <iconify-icon icon="solar:box-bold"></iconify-icon>
                                Update Stock ({{ $totalStock }})
                            </button>
                        @else
                            <span style="font-size: 0.75rem; color: #7f8c8d;">No variants</span>
                        @endif
                    </div>
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('product.edit', [$product->id]) }}" class="btn-action btn-edit">Edit</a>
                        <a href="javascript:void(0)" class="btn-action btn-delete delete-btn">Delete</a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center" style="padding: 3rem;">
                    <p style="color: #7f8c8d; font-size: 1.125rem;">No products found</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
