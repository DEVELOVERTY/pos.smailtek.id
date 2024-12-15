@if ($paginator->hasPages())
<div class="float start mt-3" style="position: absolute">
    <p> Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} entries {{ $paginator->total() }}</p>
    {{-- Showing 1 to 2 of 2 entries --}}
</div>
    <nav class="mt-3 float-end">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">{{ __('first') }}</a>
                </li>
            @else
                <li class="page-item">
                    <a  class="page-link" id="{{ $paginator->previousPageUrl() }}" onclick="movePage(this.id)" href="javascript:void(0)" rel="prev"
                        aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <a href="javascript:void(0)" class="page-link"> {{ $page }} <span class="sr-only">(current)</span></a>    
                            </li>
                        @else
                            <li class="page-item"><a class="page-link" onclick="movePage(this.id)" id="{{ $url }}" href="javascript:void(0)">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" id="{{ $paginator->nextPageUrl() }}" onclick="movePage(this.id)" href="javascript:void(0)" rel="next"
                        aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <a class="page-link" href="#" tabindex="-1">{{ __('last') }}</a>
                </li>
            @endif
        </ul>
    </nav>
@endif
