@if ($paginator->hasPages())
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 custom-pagination-wrap gap-3">
        <div class="pagination-info text-muted" style="font-size: 0.9rem; font-weight: 500;">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>

        <nav>
            <ul class="pagination mb-0" style="gap: 5px; flex-wrap: wrap; justify-content: center;">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span class="page-link" aria-hidden="true">&lsaquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <button type="button" class="page-link" wire:click="previousPage" wire:loading.attr="disabled"
                            rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</button>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><button type="button" class="page-link" wire:click="gotoPage({{ $page }})"
                                        wire:loading.attr="disabled">{{ $page }}</button></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <button type="button" class="page-link" wire:click="nextPage" wire:loading.attr="disabled" rel="next"
                            aria-label="@lang('pagination.next')">&rsaquo;</button>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <span class="page-link" aria-hidden="true">&rsaquo;</span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>

    {{-- Styling untuk Pagination Custom --}}
    <style>
        .custom-pagination-wrap .page-item .page-link {
            border: 1px solid #e2e8f0;
            color: #64748b;
            border-radius: 8px;
            padding: 7px 14px;
            font-size: 0.9rem;
            font-weight: 600;
            background: #fff;
            transition: all 0.2s;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .custom-pagination-wrap .page-item:not(.disabled):not(.active) .page-link:hover {
            background: #f8fafc;
            color: var(--text, #1e293b);
            border-color: #cbd5e1;
        }

        .custom-pagination-wrap .page-item.active .page-link {
            background: #B10000;
            border-color: #B10000;
            color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .custom-pagination-wrap .page-item.disabled .page-link {
            background: #f8fafc;
            color: #cbd5e1;
            border-color: #f1f5f9;
            cursor: not-allowed;
            box-shadow: none;
        }
    </style>
@endif