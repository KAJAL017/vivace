<div class="pagination-container">
    <div class="pagination-info">
        Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} results
    </div>
    
    @if ($orders->hasPages())
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($orders->onFirstPage())
                <li class="disabled">
                    <span>← Previous</span>
                </li>
            @else
                <li>
                    <a href="{{ $orders->previousPageUrl() }}" class="pagination-link">← Previous</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @php
                $start = max($orders->currentPage() - 2, 1);
                $end = min($start + 4, $orders->lastPage());
                $start = max($end - 4, 1);
            @endphp

            @if($start > 1)
                <li>
                    <a href="{{ $orders->url(1) }}" class="pagination-link">1</a>
                </li>
                @if($start > 2)
                    <li class="disabled"><span class="dots">...</span></li>
                @endif
            @endif

            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $orders->currentPage())
                    <li class="active"><span>{{ $i }}</span></li>
                @else
                    <li>
                        <a href="{{ $orders->url($i) }}" class="pagination-link">{{ $i }}</a>
                    </li>
                @endif
            @endfor

            @if($end < $orders->lastPage())
                @if($end < $orders->lastPage() - 1)
                    <li class="disabled"><span class="dots">...</span></li>
                @endif
                <li>
                    <a href="{{ $orders->url($orders->lastPage()) }}" class="pagination-link">{{ $orders->lastPage() }}</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($orders->hasMorePages())
                <li>
                    <a href="{{ $orders->nextPageUrl() }}" class="pagination-link">Next →</a>
                </li>
            @else
                <li class="disabled">
                    <span>Next →</span>
                </li>
            @endif
        </ul>
    @endif
</div>
