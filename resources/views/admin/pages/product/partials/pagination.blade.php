@if($products->hasPages())
<div class="pagination-container">
    <div class="pagination-info">
        Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
    </div>
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($products->onFirstPage())
                <li class="disabled">
                    <span>←</span>
                </li>
            @else
                <li>
                    <a href="{{ $products->previousPageUrl() }}" class="pagination-link" rel="prev">←</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @php
                $current = $products->currentPage();
                $last = $products->lastPage();
                $delta = 2;
                $left = $current - $delta;
                $right = $current + $delta + 1;
                $range = [];
                $rangeWithDots = [];
                $l = null;
            @endphp

            @for ($i = 1; $i <= $last; $i++)
                @if ($i == 1 || $i == $last || ($i >= $left && $i < $right))
                    @php
                        $range[] = $i;
                    @endphp
                @endif
            @endfor

            @foreach ($range as $i)
                @if ($l)
                    @if ($i - $l === 2)
                        <li>
                            <a href="{{ $products->url($l + 1) }}" class="pagination-link">{{ $l + 1 }}</a>
                        </li>
                    @elseif ($i - $l !== 1)
                        <li class="dots">
                            <span>...</span>
                        </li>
                    @endif
                @endif

                @if ($i == $current)
                    <li class="active">
                        <span>{{ $i }}</span>
                    </li>
                @else
                    <li>
                        <a href="{{ $products->url($i) }}" class="pagination-link">{{ $i }}</a>
                    </li>
                @endif

                @php
                    $l = $i;
                @endphp
            @endforeach

            {{-- Next Page Link --}}
            @if ($products->hasMorePages())
                <li>
                    <a href="{{ $products->nextPageUrl() }}" class="pagination-link" rel="next">→</a>
                </li>
            @else
                <li class="disabled">
                    <span>→</span>
                </li>
            @endif
        </ul>
    </nav>
</div>
@endif
