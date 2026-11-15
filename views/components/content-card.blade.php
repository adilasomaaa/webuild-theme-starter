{{--
    Kartu berita/artikel/halaman.
    Parameter: $item, opsional $cardVariant ('grid'|'list'|'compact'), $cardType ('news'|'article'|'page') bila item tidak membawa type.
--}}
@php
    $itemType = data_get($item, 'type');
    $itemType = is_object($itemType) ? ($itemType->value ?? null) : $itemType;
    $itemType = $itemType ?: ($cardType ?? 'article');
    $itemSlug = data_get($item, 'slug');
    $itemUrl = data_get($item, 'url') ?: ($itemSlug ? match ($itemType) {
        'news' => route('public.news.show', $itemSlug),
        'page' => route('public.pages.show', $itemSlug),
        default => route('public.articles.show', $itemSlug),
    } : '#');
    $itemImage = data_get($item, 'featured_image_url') ?? data_get($item, 'thumbnail_url') ?? data_get($item, 'thumbnail') ?? data_get($item, 'image_url');
    $itemDateRaw = data_get($item, 'published_at') ?? data_get($item, 'created_at');
    $itemDate = $itemDateRaw ? \Illuminate\Support\Carbon::parse($itemDateRaw)->locale('id') : null;
    $itemCategory = data_get($item, 'category.name') ?? data_get(collect(data_get($item, 'categories') ?? [])->first(), 'name');
    $itemExcerpt = data_get($item, 'excerpt') ?? data_get($item, 'summary') ?? \Illuminate\Support\Str::limit(strip_tags((string) data_get($item, 'content')), 140);
    $layout = $cardVariant ?? 'grid';
@endphp

@if($layout === 'compact')
    <a href="{{ $itemUrl }}" class="group flex gap-3">
        @if($itemImage)
            <img src="{{ $itemImage }}" alt="" loading="lazy" class="size-16 shrink-0 rounded-lg object-cover">
        @endif
        <div class="min-w-0">
            <h3 class="line-clamp-2 text-sm font-semibold text-slate-900 group-hover:text-primary">{{ data_get($item, 'title') }}</h3>
            @if($itemDate)
                <p class="mt-1 text-xs text-slate-500">{{ $itemDate->translatedFormat('d M Y') }}</p>
            @endif
        </div>
    </a>
@else
    <article class="card card-hover group overflow-hidden {{ $layout === 'list' ? 'flex flex-col sm:flex-row' : 'flex flex-col' }}">
        <a href="{{ $itemUrl }}" class="block shrink-0 overflow-hidden bg-slate-100 {{ $layout === 'list' ? 'aspect-video sm:aspect-auto sm:w-64' : 'aspect-video' }}">
            @if($itemImage)
                <img src="{{ $itemImage }}" alt="{{ data_get($item, 'title') }}" loading="lazy" class="size-full object-cover transition duration-300 group-hover:scale-105">
            @else
                <span class="flex size-full items-center justify-center text-slate-300">
                    @include('themes.starter.components.icon', ['name' => 'image', 'class' => 'size-10'])
                </span>
            @endif
        </a>
        <div class="flex flex-1 flex-col p-5">
            <div class="mb-3 flex flex-wrap items-center gap-2 text-xs text-slate-500">
                @if($itemCategory)
                    <span class="badge">{{ $itemCategory }}</span>
                @endif
                @if($itemDate)
                    <span class="inline-flex items-center gap-1">
                        @include('themes.starter.components.icon', ['name' => 'calendar', 'class' => 'size-3.5'])
                        {{ $itemDate->translatedFormat('d M Y') }}
                    </span>
                @endif
            </div>
            <h3 class="text-lg font-semibold leading-snug text-slate-900 group-hover:text-primary">
                <a href="{{ $itemUrl }}">{{ data_get($item, 'title') }}</a>
            </h3>
            @if($itemExcerpt)
                <p class="mt-2 line-clamp-3 text-sm text-slate-600">{{ $itemExcerpt }}</p>
            @endif
            <a href="{{ $itemUrl }}" class="link mt-auto inline-flex items-center gap-1 pt-4 text-sm">
                Baca selengkapnya
                @include('themes.starter.components.icon', ['name' => 'arrow-right', 'class' => 'size-4'])
            </a>
        </div>
    </article>
@endif
