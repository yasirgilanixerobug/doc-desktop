<nav aria-label="...">
    @if ($paginator->hasPages())
    <ul class="pagination" style="float: right; padding-right: 10px">
        @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a>
                </li>
        @endif

            @foreach ($elements as $element)

                @if (is_string($element))
                    <li class="disabled"><span>{{ $element }}</span></li>
                @endif


                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                                <li class="page-item active">
                                    <a class="page-link" href="#">{{ $page }}<span class="sr-only">{{ $page }}</span></a>
                                </li>
                        @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach


{{--            <li class="page-item"><a class="page-link" href="#">1</a></li>--}}

            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" >Next</a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link" href="#">Next</a>
                </li>
            @endif
    </ul>
        @endif
</nav>
