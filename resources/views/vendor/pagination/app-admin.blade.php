<div class="row align-items-center">
    <div class="col-md-3">    
        <div class="dataTables_info" id="dom-jqry_info" role="status" aria-live="polite">
        Showing 
        {{ $paginator->total()>0?($paginator->currentPage()-1)*($paginator->perPage())+1:0 }} 
        to 
        {{ ($paginator->count()<$paginator->perPage())?(($paginator->currentPage()-1)*$paginator->perPage()+$paginator->count()):$paginator->currentPage()*$paginator->perPage() }} 
        of 
        {{ $paginator->total() }} 
        entries
        </div>        
    </div>
    <div class="col-md-9">
        <nav>
            <ul class="pagination f-right">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">{{ __('admin.previous_txt') }}</span>
                </li>
                @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">{{ __('admin.previous_txt') }}</a>
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
                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
                @endforeach
                @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">{{ __('admin.next_txt') }}</a>
                </li>
                @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">{{ __('admin.next_txt') }}</span>
                </li>
                @endif
            </ul>
        </nav>
    </div>
</div>