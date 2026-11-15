{{-- Kartu tautan eksternal. Parameter: $linkItem (title, url, logo_url, description) --}}
<a href="{{ data_get($linkItem, 'url') }}" target="_blank" rel="noopener" class="card card-hover group flex items-start gap-4 p-5">
    @if(data_get($linkItem, 'logo_url'))
        <img src="{{ data_get($linkItem, 'logo_url') }}" alt="" class="size-12 shrink-0 rounded-lg object-contain" loading="lazy">
    @else
        <span class="flex size-12 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary">
            @include('themes.starter.components.icon', ['name' => 'link', 'class' => 'size-5'])
        </span>
    @endif
    <div class="min-w-0 flex-1">
        <h3 class="flex items-center gap-1.5 font-semibold text-slate-900 group-hover:text-primary">
            <span class="truncate">{{ data_get($linkItem, 'title') }}</span>
            @include('themes.starter.components.icon', ['name' => 'external-link', 'class' => 'size-3.5 text-slate-400'])
        </h3>
        @if(data_get($linkItem, 'description'))
            <p class="mt-1 line-clamp-2 text-sm text-slate-600">{{ data_get($linkItem, 'description') }}</p>
        @endif
    </div>
</a>
