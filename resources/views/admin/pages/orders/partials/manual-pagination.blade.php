<div class="pagination-container">
    <div class="pagination-info">
        Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} results
    </div>
    
    @if ($orders->hasPages())
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($orders->onFirstPage())
                <li class="disabled">
                    <span>‹ Previous</span>
                </li>
            @else
                <li>
                    <a href="{{ $orders->previousPageUrl() }}" class="pagination-link">‹ Previous</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @php
                $currentPage = $orders->currentPage();
                $lastPage = $orders->lastPage();
                $start = max(1, $currentPage - 2);
                $end = min($lastPage, $currentPage + 2);
            @endphp

            {{-- First Page --}}
            @if ($start > 1)
                <li>
                    <a href="{{ $orders->url(1) }}" class="pagination-link">1</a>
                </li>
                @if ($start > 2)
                    <li class="disabled">
                        <span class="dots">...</span>
                    </li>
                @endif
            @endif

            {{-- Page Numbers --}}
            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $currentPage)
                    <li class="active">
                        <span>{{ $page }}</span>
                    </li>
                @else
                    <li>
                        <a href="{{ $orders->url($page) }}" class="pagination-link">{{ $page }}</a>
                    </li>
                @endif
            @endfor

            {{-- Last Page --}}
            @if ($end < $lastPage)
                @if ($end < $lastPage - 1)
                    <li class="disabled">
                        <span class="dots">...</span>
                    </li>
                @endif
                <li>
                    <a href="{{ $orders->url($lastPage) }}" class="pagination-link">{{ $lastPage }}</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($orders->hasMorePages())
                <li>
                    <a href="{{ $orders->nextPageUrl() }}" class="pagination-link">Next ›</a>
                </li>
            @else
                <li class="disabled">
                    <span>Next ›</span>
                </li>
            @endif
        </ul>
    @endif
</div>
