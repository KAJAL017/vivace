<div class="table-container">
    <!-- Bulk Actions Bar -->
    <div id="bulkActionsBar" style="display: none; background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); padding: 1rem 1.5rem; border-bottom: 2px solid #e9ecef; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <span style="color: white; font-weight: 600; font-size: 0.9375rem;">
                <span id="selectedCount">0</span> product(s) selected
            </span>
            <button type="button" class="btn" id="deselectAllBtn" style="background: transparent; border: 2px solid white; color: white; padding: 0.375rem 1rem; border-radius: 6px; font-size: 0.875rem; font-weight: 600;">
                Clear Selection
            </button>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <button type="button" class="btn" id="bulkOutOfStockBtn" style="background: #f39c12; color: white; padding: 0.5rem 1.25rem; border-radius: 6px; font-weight: 600; font-size: 0.875rem;">
                <iconify-icon icon="solar:box-minimalistic-bold" style="font-size: 1.125rem;"></iconify-icon>
                Move to Out of Stock
            </button>
            <button type="button" class="btn" id="bulkDeleteBtn" style="background: #e74c3c; color: white; padding: 0.5rem 1.25rem; border-radius: 6px; font-weight: 600; font-size: 0.875rem;">
                <iconify-icon icon="solar:trash-bin-trash-bold" style="font-size: 1.125rem;"></iconify-icon>
                Delete Selected
            </button>
        </div>
    </div>
    
    <table class="product-table">
        <thead>
            <tr>
                <th style="width: 3%;">
                    <input type="checkbox" id="selectAll" style="width: 18px; height: 18px; cursor: pointer;">
                </th>
                <th style="width: 5%;">#</th>
                <th style="width: 22%;">Product</th>
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
                <td>
                    <input type="checkbox" class="product-checkbox" value="{{ $product->id }}" style="width: 18px; height: 18px; cursor: pointer;">
                </td>
                <td>{{ $products->firstItem() + $key }}</td>
                <td>
                    <div class="product-image-cell">
                        @php
                            $firstImg = DB::table('product_images')
                                ->where('product_id', $product->id)
                                ->orderBy('id','asc')
                                ->first();
                            $thumbSrc = $firstImg
                                ? (!empty($firstImg->imagekit_url)
                                    ? $firstImg->imagekit_url
                                    : upload_url($firstImg->file_path))
                                : url('public/5.png');
                        @endphp
                        <img src="{{ $thumbSrc }}"
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
                <td colspan="9" class="text-center" style="padding: 3rem;">
                    <p style="color: #7f8c8d; font-size: 1.125rem;">No products found</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
