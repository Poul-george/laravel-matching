@if ($paginator->hasPages())
<style>
    /* .pagination{
        display: flex;
        justify-content: center;
    }
    .pagination li{
        padding: 5px;
    }
    .page-item{
        list-style: none;
    }
    .page-item a{
        text-decoration: none;
    } */
</style>
<ul class="pagination">
    <li class="page-item {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
        <a class="page-link" href="{{ $paginator->url(1) }}">First</a>
     </li>
    <li class="page-item {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
        <a class="page-link" href="{{ $paginator->url(1) }}">
            <span aria-hidden="true">«</span>
            {{-- Previous --}}
        </a>
    </li>
    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
        <li class="page-item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
            <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
        </li>
        @if ($i>=5)
            @break
        @endif
    @endfor
    <li class="page-item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
        <a class="page-link" href="{{ $paginator->url($paginator->currentPage()+1) }}" >
            <span aria-hidden="true">»</span>
            {{-- Next --}}
        </a>
    </li>
    <li class="page-item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
        <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">Last</a>
    </li>
</ul>
@endif
