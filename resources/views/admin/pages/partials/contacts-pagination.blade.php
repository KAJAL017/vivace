<div class="pagination-container">
    <div class="pagination-info">
        Showing {{ $contacts->firstItem() ?? 0 }} to {{ $contacts->lastItem() ?? 0 }} of {{ $contacts->total() }} results
    </div>
    
    @if ($contacts->hasPages())
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($contacts->onFirstPage())
                <li class="disabled">
                    <span>← Previous</span>
                </li>
            @else
                <li>
                    <a href="{{ $contacts->previousPageUrl() }}" class="pagination-link">← Previous</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @php
                $start = max($contacts->currentPage() - 2, 1);
                $end = min($start + 4, $contacts->lastPage());
                $start = max($end - 4, 1);
            @endphp

            @if($start > 1)
                <li>
                    <a href="{{ $contacts->url(1) }}" class="pagination-link">1</a>
                </li>
                @if($start > 2)
                    <li class="disabled"><span class="dots">...</span></li>
                @endif
            @endif

            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $contacts->currentPage())
                    <li class="active"><span>{{ $i }}</span></li>
                @else
                    <li>
                        <a href="{{ $contacts->url($i) }}" class="pagination-link">{{ $i }}</a>
                    </li>
                @endif
            @endfor

            @if($end < $contacts->lastPage())
                @if($end < $contacts->lastPage() - 1)
                    <li class="disabled"><span class="dots">...</span></li>
                @endif
                <li>
                    <a href="{{ $contacts->url($contacts->lastPage()) }}" class="pagination-link">{{ $contacts->lastPage() }}</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($contacts->hasMorePages())
                <li>
                    <a href="{{ $contacts->nextPageUrl() }}" class="pagination-link">Next →</a>
                </li>
            @else
                <li class="disabled">
                    <span>Next →</span>
                </li>
            @endif
        </ul>
    @endif
</div>
