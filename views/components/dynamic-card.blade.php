{{-- Kartu konten dinamis/katalog. Parameter: $dynamicItem (title, slug, thumbnail_url, category, published_at) --}}
@php
    $dynamicCategorySlug = data_get($dynamicItem, 'category.slug');
    $dynamicUrl = $dynamicCategorySlug && data_get($dynamicItem, 'slug')
        ? route('public.dynamic-content.show', [$dynamicCategorySlug, data_get($dynamicItem, 'slug')])
        : '#';
@endphp
<a href="{{ $dynamicUrl }}" class="card card-hover group block overflow-hidden">
    <div class="aspect-video bg-slate-100">
        @if(data_get($dynamicItem, 'thumbnail_url'))
            <img src="{{ data_get($dynamicItem, 'thumbnail_url') }}" alt="" class="size-full object-cover" loading="lazy">
        @else
            <span class="flex size-full items-center justify-center text-slate-300">@include('themes.starter.components.icon', ['name' => 'layers', 'class' => 'size-10'])</span>
        @endif
    </div>
    <div class="p-5">
        @if(data_get($dynamicItem, 'category.name'))
            <span class="badge mb-2">{{ data_get($dynamicItem, 'category.name') }}</span>
        @endif
        <h3 class="font-semibold text-slate-900 group-hover:text-primary">{{ data_get($dynamicItem, 'title') }}</h3>
    </div>
</a>
