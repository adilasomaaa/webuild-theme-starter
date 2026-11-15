{{--
    Paginasi tema. Pemakaian: {{ $items->links('themes.starter.components.pagination') }}
--}}
@if($paginator->hasPages())
    <nav role="navigation" aria-label="Paginasi" class="mt-10 flex items-center justify-between gap-4">
        <p class="hidden text-sm text-slate-500 sm:block">
            Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }}
        </p>
        <div class="flex flex-1 items-center justify-center gap-1 sm:flex-none">
            @if($paginator->onFirstPage())
                <span class="btn btn-sm btn-ghost pointer-events-none opacity-40">@include('themes.starter.components.icon', ['name' => 'chevron-left', 'class' => 'size-4'])</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="btn btn-sm btn-ghost" aria-label="Sebelumnya">@include('themes.starter.components.icon', ['name' => 'chevron-left', 'class' => 'size-4'])</a>
            @endif

            @foreach($elements as $element)
                @if(is_string($element))
                    <span class="px-2 text-sm text-slate-400">{{ $element }}</span>
                @endif
                @if(is_array($element))
                    @foreach($element as $pageNumber => $url)
                        @if($pageNumber == $paginator->currentPage())
                            <span aria-current="page" class="btn btn-sm btn-primary min-w-9">{{ $pageNumber }}</span>
                        @else
                            <a href="{{ $url }}" class="btn btn-sm btn-ghost min-w-9">{{ $pageNumber }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="btn btn-sm btn-ghost" aria-label="Berikutnya">@include('themes.starter.components.icon', ['name' => 'chevron-right', 'class' => 'size-4'])</a>
            @else
                <span class="btn btn-sm btn-ghost pointer-events-none opacity-40">@include('themes.starter.components.icon', ['name' => 'chevron-right', 'class' => 'size-4'])</span>
            @endif
        </div>
    </nav>
@endif
