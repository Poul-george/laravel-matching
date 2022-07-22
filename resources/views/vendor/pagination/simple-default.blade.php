@if ($paginator->hasPages())
    <div class="pagination_div">
        <div class="pagination_ul_div">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="disabled pagination_li" aria-disabled="true">前のページ</li>
                @else
                    <li class="pagination_li not_disabled"><a rel="prev" href="{{ $paginator->previousPageUrl() }}" class="btn prev_next_btn">前のページ</a></li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="pagination_li not_disabled"><a rel="next" href="{{ $paginator->nextPageUrl() }}" class="btn prev_next_btn">次のページ</a></li>
                @else
                    <li class="disabled pagination_li" aria-disabled="true">次のページ</li>
                @endif
            </ul>
        </div>
    </div>
@endif