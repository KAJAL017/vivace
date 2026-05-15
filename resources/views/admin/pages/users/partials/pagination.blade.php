<div class="pagination-container">
    <div class="pagination-info">
        Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} results
    </div>
    
    @if ($users->hasPages())
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($users->onFirstPage())
                <li class="disabled">
                    <span>← Previous</span>
                </li>
            @else
                <li>
                    <a href="{{ $users->previousPageUrl() }}" class="pagination-link">← Previous</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @php
                $start = max($users->currentPage() - 2, 1);
                $end = min($start + 4, $users->lastPage());
                $start = max($end - 4, 1);
            @endphp

            @if($start > 1)
                <li>
                    <a href="{{ $users->url(1) }}" class="pagination-link">1</a>
                </li>
                @if($start > 2)
                    <li class="disabled"><span class="dots">...</span></li>
                @endif
            @endif

            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $users->currentPage())
                    <li class="active"><span>{{ $i }}</span></li>
                @else
                    <li>
                        <a href="{{ $users->url($i) }}" class="pagination-link">{{ $i }}</a>
                    </li>
                @endif
            @endfor

            @if($end < $users->lastPage())
                @if($end < $users->lastPage() - 1)
                    <li class="disabled"><span class="dots">...</span></li>
                @endif
                <li>
                    <a href="{{ $users->url($users->lastPage()) }}" class="pagination-link">{{ $users->lastPage() }}</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($users->hasMorePages())
                <li>
                    <a href="{{ $users->nextPageUrl() }}" class="pagination-link">Next →</a>
                </li>
            @else
                <li class="disabled">
                    <span>Next →</span>
                </li>
            @endif
        </ul>
    @endif
</div>
