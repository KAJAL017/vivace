@if($categories->hasPages())
<div class="pagination-container">
    <div class="pagination-wrapper">
        <ul class="pagination-list">
            {{-- Previous Button --}}
            @if ($categories->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">
                        <iconify-icon icon="solar:alt-arrow-left-bold"></iconify-icon>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" data-page="{{ $categories->currentPage() - 1 }}">
                        <iconify-icon icon="solar:alt-arrow-left-bold"></iconify-icon>
                    </a>
                </li>
            @endif

            {{-- Page Numbers --}}
            @php
                $currentPage = $categories->currentPage();
                $lastPage = $categories->lastPage();
                $start = max(1, $currentPage - 2);
                $end = min($lastPage, $currentPage + 2);
            @endphp

            @if($start > 1)
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" data-page="1">1</a>
                </li>
                @if($start > 2)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif
            @endif

            @for ($i = $start; $i <= $end; $i++)
                <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                    <a class="page-link" href="javascript:void(0)" data-page="{{ $i }}">{{ $i }}</a>
                </li>
            @endfor

            @if($end < $lastPage)
                @if($end < $lastPage - 1)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" data-page="{{ $lastPage }}">{{ $lastPage }}</a>
                </li>
            @endif

            {{-- Next Button --}}
            @if ($categories->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" data-page="{{ $categories->currentPage() + 1 }}">
                        <iconify-icon icon="solar:alt-arrow-right-bold"></iconify-icon>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">
                        <iconify-icon icon="solar:alt-arrow-right-bold"></iconify-icon>
                    </span>
                </li>
            @endif
        </ul>
        
        <div class="pagination-info">
            Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} categories
        </div>
    </div>
</div>
@endif
