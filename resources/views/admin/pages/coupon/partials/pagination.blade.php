<div class="pagination-container">
    <div class="pagination-info">
        Showing {{ $coupons->firstItem() ?? 0 }} to {{ $coupons->lastItem() ?? 0 }} of {{ $coupons->total() }} results
    </div>
    
    @if ($coupons->hasPages())
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($coupons->onFirstPage())
                <li class="disabled">
                    <span>← Previous</span>
                </li>
            @else
                <li>
                    <a href="{{ $coupons->previousPageUrl() }}" class="pagination-link">← Previous</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @php
                $start = max($coupons->currentPage() - 2, 1);
                $end = min($start + 4, $coupons->lastPage());
                $start = max($end - 4, 1);
            @endphp

            @if($start > 1)
                <li>
                    <a href="{{ $coupons->url(1) }}" class="pagination-link">1</a>
                </li>
                @if($start > 2)
                    <li class="disabled"><span class="dots">...</span></li>
                @endif
            @endif

            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $coupons->currentPage())
                    <li class="active"><span>{{ $i }}</span></li>
                @else
                    <li>
                        <a href="{{ $coupons->url($i) }}" class="pagination-link">{{ $i }}</a>
                    </li>
                @endif
            @endfor

            @if($end < $coupons->lastPage())
                @if($end < $coupons->lastPage() - 1)
                    <li class="disabled"><span class="dots">...</span></li>
                @endif
                <li>
                    <a href="{{ $coupons->url($coupons->lastPage()) }}" class="pagination-link">{{ $coupons->lastPage() }}</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($coupons->hasMorePages())
                <li>
                    <a href="{{ $coupons->nextPageUrl() }}" class="pagination-link">Next →</a>
                </li>
            @else
                <li class="disabled">
                    <span>Next →</span>
                </li>
            @endif
        </ul>
    @endif
</div>
