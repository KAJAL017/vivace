{{-- Bulk Actions Bar --}}
<div id="bulkActionsBar" style="display:none; background:#1e1b4b; padding:10px 20px; align-items:center; justify-content:space-between; border-bottom:1px solid #312e81;">
    <div style="display:flex; align-items:center; gap:12px;">
        <span style="color:#c7d2fe; font-size:0.82rem; font-weight:600;">
            <span id="selectedCount">0</span> selected
        </span>
        <button id="deselectAllBtn" style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2); color:#e0e7ff; padding:4px 12px; border-radius:6px; font-size:0.78rem; font-weight:600; cursor:pointer;">
            Clear
        </button>
    </div>
    <div style="display:flex; gap:8px;">
        <button id="bulkOutOfStockBtn" style="background:#f59e0b; color:#fff; border:none; padding:6px 14px; border-radius:7px; font-size:0.78rem; font-weight:700; cursor:pointer;">
            ⚠ Out of Stock
        </button>
        <button id="bulkDeleteBtn" style="background:#ef4444; color:#fff; border:none; padding:6px 14px; border-radius:7px; font-size:0.78rem; font-weight:700; cursor:pointer;">
            🗑 Delete Selected
        </button>
    </div>
</div>

<table style="width:100%; border-collapse:collapse;">
    <thead>
        <tr style="background:#f8fafc; border-bottom:2px solid #e8ecf0;">
            <th style="padding:10px 14px; width:36px;">
                <input type="checkbox" id="selectAll" style="width:16px; height:16px; cursor:pointer; accent-color:#6366f1;">
            </th>
            <th style="padding:10px 8px; font-size:0.68rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px; width:40px;">#</th>
            <th style="padding:10px 14px; font-size:0.68rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px; text-align:left;">Product</th>
            <th style="padding:10px 14px; font-size:0.68rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px; text-align:left;">Category</th>
            <th style="padding:10px 14px; font-size:0.68rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px; text-align:left;">Brand</th>
            <th style="padding:10px 14px; font-size:0.68rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px; text-align:center;">Stock</th>
            <th style="padding:10px 14px; font-size:0.68rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px; text-align:center;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($products as $key => $product)
        @php
            $attributes = DB::table('product_attributes')
                ->leftJoin('sizes',  'product_attributes.size_id',  '=', 'sizes.id')
                ->leftJoin('colors', 'product_attributes.color_id', '=', 'colors.id')
                ->where('product_attributes.product_id', $product->id)
                ->select('product_attributes.*', 'sizes.name as size_name', 'colors.name as color_name')
                ->get();
            $totalStock = $attributes->sum('qty');

            $firstImg = DB::table('product_images')->where('product_id', $product->id)->orderBy('id','asc')->first();
            $thumbSrc = $firstImg
                ? (!empty($firstImg->imagekit_url) ? $firstImg->imagekit_url : upload_url($firstImg->file_path))
                : url('public/5.png');
        @endphp
        <tr data-id="{{ $product->id }}" style="border-bottom:1px solid #f1f5f9; transition:background 0.15s;" onmouseover="this.style.background='#fafbfc'" onmouseout="this.style.background=''">

            {{-- Checkbox --}}
            <td style="padding:12px 14px;">
                <input type="checkbox" class="product-checkbox" value="{{ $product->id }}" style="width:16px; height:16px; cursor:pointer; accent-color:#6366f1;">
            </td>

            {{-- # --}}
            <td style="padding:12px 8px; font-size:0.78rem; color:#94a3b8; font-weight:600; text-align:center;">
                {{ $products->firstItem() + $key }}
            </td>

            {{-- Product --}}
            <td style="padding:12px 14px;">
                <div style="display:flex; align-items:center; gap:12px;">
                    <img src="{{ $thumbSrc }}" alt="{{ $product->name }}"
                         style="width:48px; height:48px; border-radius:10px; object-fit:cover; border:1.5px solid #e2e8f0; flex-shrink:0;">
                    <div style="min-width:0;">
                        <div style="font-weight:700; color:#1e293b; font-size:0.85rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:200px;">
                            {{ $product->name }}
                        </div>
                        <div style="font-size:0.72rem; color:#94a3b8; margin-top:2px;">
                            {{ $product->subcategoryname ?? '' }}
                            @if($product->collectionName)
                                · <span style="color:#818cf8;">{{ $product->collectionName }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </td>

            {{-- Category --}}
            <td style="padding:12px 14px;">
                <span style="display:inline-block; padding:3px 9px; background:#ede9fe; color:#6d28d9; border-radius:5px; font-size:0.72rem; font-weight:700;">
                    {{ $product->categoryname ?? 'N/A' }}
                </span>
            </td>

            {{-- Brand --}}
            <td style="padding:12px 14px;">
                <span style="display:inline-block; padding:3px 9px; background:#fef3c7; color:#b45309; border-radius:5px; font-size:0.72rem; font-weight:700;">
                    {{ $product->brandname ?? 'N/A' }}
                </span>
            </td>

            {{-- Stock --}}
            <td style="padding:12px 14px; text-align:center;">
                @if($totalStock <= 0)
                    <span style="display:inline-block; padding:3px 10px; background:#fee2e2; color:#dc2626; border-radius:20px; font-size:0.72rem; font-weight:700;">Out of Stock</span>
                @elseif($totalStock <= 10)
                    <span style="display:inline-block; padding:3px 10px; background:#fef3c7; color:#d97706; border-radius:20px; font-size:0.72rem; font-weight:700;">Low · {{ $totalStock }}</span>
                @else
                    <span style="display:inline-block; padding:3px 10px; background:#d1fae5; color:#059669; border-radius:20px; font-size:0.72rem; font-weight:700;">{{ $totalStock }} units</span>
                @endif
                @if($attributes->count() > 0)
                <div style="margin-top:5px;">
                    <button onclick="showStockModal({{ $product->id }}, '{{ addslashes($product->name) }}', {{ json_encode($attributes) }})"
                            style="background:#eef2ff; color:#6366f1; border:none; padding:3px 10px; border-radius:5px; font-size:0.7rem; font-weight:700; cursor:pointer; transition:background 0.2s;"
                            onmouseover="this.style.background='#6366f1';this.style.color='#fff'"
                            onmouseout="this.style.background='#eef2ff';this.style.color='#6366f1'">
                        ↑ Update
                    </button>
                </div>
                @endif
            </td>

            {{-- Actions --}}
            <td style="padding:12px 14px; text-align:center;">
                <div style="display:flex; align-items:center; justify-content:center; gap:6px;">
                    <a href="{{ route('product.edit', [$product->id]) }}"
                       style="display:inline-flex; align-items:center; gap:4px; padding:5px 12px; background:#dbeafe; color:#1d4ed8; border-radius:7px; font-size:0.76rem; font-weight:700; text-decoration:none; transition:all 0.2s;"
                       onmouseover="this.style.background='#1d4ed8';this.style.color='#fff'"
                       onmouseout="this.style.background='#dbeafe';this.style.color='#1d4ed8'">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit
                    </a>
                    <a href="{{ route('product.image.upload', [$product->id]) }}"
                       style="display:inline-flex; align-items:center; gap:4px; padding:5px 12px; background:#d1fae5; color:#059669; border-radius:7px; font-size:0.76rem; font-weight:700; text-decoration:none; transition:all 0.2s;"
                       onmouseover="this.style.background='#059669';this.style.color='#fff'"
                       onmouseout="this.style.background='#d1fae5';this.style.color='#059669'">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        Images
                    </a>
                    <button class="btn-action btn-delete delete-btn"
                            style="display:inline-flex; align-items:center; gap:4px; padding:5px 12px; background:#fee2e2; color:#dc2626; border:none; border-radius:7px; font-size:0.76rem; font-weight:700; cursor:pointer; transition:all 0.2s;"
                            onmouseover="this.style.background='#dc2626';this.style.color='#fff'"
                            onmouseout="this.style.background='#fee2e2';this.style.color='#dc2626'">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                        Delete
                    </button>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="padding:48px; text-align:center;">
                <div style="color:#94a3b8; font-size:0.9rem;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" style="display:block;margin:0 auto 12px;"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                    No products found
                </div>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
