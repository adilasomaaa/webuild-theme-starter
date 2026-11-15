{{--
    Detail berita/artikel.
    Variabel: $content (title, content, excerpt, featured_image_url, published_at, author_display_name, categories, tags, views_count),
    $relatedContents, $popularContents, $comments.
--}}
@extends('themes.starter.layouts.public')

@php
    $detailType = data_get($content, 'type');
    $detailType = is_object($detailType) ? ($detailType->value ?? null) : $detailType;
    $detailIndexUrl = $detailType === 'news' ? route('public.news.index') : route('public.articles.index');
    $detailIndexLabel = $detailType === 'news' ? 'Berita' : 'Artikel';
    $detailDate = data_get($content, 'published_at') ? \Illuminate\Support\Carbon::parse(data_get($content, 'published_at'))->locale('id') : null;
    $detailImage = data_get($content, 'featured_image_url') ?? data_get($content, 'image_url');
    $detailCategories = collect(data_get($content, 'categories') ?? []);
@endphp

@section('content')
    <article class="container-page py-10">
        <nav aria-label="Breadcrumb" class="mb-6 flex flex-wrap items-center gap-1.5 text-sm text-slate-500">
            <a href="{{ route('home') }}" class="hover:text-primary">Beranda</a>
            @include('themes.starter.components.icon', ['name' => 'chevron-right', 'class' => 'size-3.5 text-slate-400'])
            <a href="{{ $detailIndexUrl }}" class="hover:text-primary">{{ $detailIndexLabel }}</a>
        </nav>

        <div class="grid gap-10 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <div class="mb-4 flex flex-wrap gap-2">
                    @foreach($detailCategories as $detailCategory)
                        <a href="{{ data_get($detailCategory, 'slug') ? route('public.categories.show', data_get($detailCategory, 'slug')) : '#' }}" class="badge">{{ data_get($detailCategory, 'name') }}</a>
                    @endforeach
                </div>
                <h1 class="text-3xl font-bold leading-tight tracking-tight text-slate-900 sm:text-4xl">{{ data_get($content, 'title') }}</h1>
                <div class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-slate-500">
                    @if(data_get($content, 'author_display_name'))
                        <span class="flex items-center gap-1.5">@include('themes.starter.components.icon', ['name' => 'user', 'class' => 'size-4']) {{ data_get($content, 'author_display_name') }}</span>
                    @endif
                    @if($detailDate)
                        <span class="flex items-center gap-1.5">@include('themes.starter.components.icon', ['name' => 'calendar', 'class' => 'size-4']) {{ $detailDate->translatedFormat('l, d F Y') }}</span>
                    @endif
                    @if(! is_null(data_get($content, 'views_count')))
                        <span class="flex items-center gap-1.5">@include('themes.starter.components.icon', ['name' => 'eye', 'class' => 'size-4']) {{ number_format((int) data_get($content, 'views_count'), 0, ',', '.') }} kali dibaca</span>
                    @endif
                </div>

                @if($detailImage && data_get($content, 'show_thumbnail_on_detail', true))
                    <img src="{{ $detailImage }}" alt="{{ data_get($content, 'title') }}" class="mt-8 aspect-video w-full rounded-2xl object-cover">
                @endif

                <div class="prose-content mt-8 text-lg">{!! data_get($content, 'content') !!}</div>

                @if(collect(data_get($content, 'tags') ?? [])->isNotEmpty())
                    <div class="mt-8 flex flex-wrap gap-2">
                        @foreach(data_get($content, 'tags') as $detailTag)
                            <span class="badge badge-muted">#{{ data_get($detailTag, 'name') }}</span>
                        @endforeach
                    </div>
                @endif

                <div class="mt-8 flex items-center gap-3 border-t border-slate-200 pt-6 text-sm">
                    <span class="font-medium text-slate-700">Bagikan:</span>
                    <a href="https://wa.me/?text={{ urlencode(data_get($content, 'title') . ' ' . url()->current()) }}" target="_blank" rel="noopener" class="btn btn-sm btn-ghost">WhatsApp</a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="btn btn-sm btn-ghost">Facebook</a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="btn btn-sm btn-ghost">X</a>
                </div>

                @include('themes.starter.components.comments', ['config' => [], 'commentable' => $content, 'commentableType' => 'content'])
            </div>

            <aside class="space-y-6">
                @foreach(['Terpopuler' => $popularContents ?? collect(), 'Terkait' => $relatedContents ?? collect()] as $asideTitle => $asideItems)
                    @if(collect($asideItems)->isNotEmpty())
                        <div class="card p-5">
                            <h2 class="mb-4 font-semibold text-slate-900">{{ $asideTitle }}</h2>
                            <div class="space-y-4">
                                @foreach(collect($asideItems)->take(5) as $asideItem)
                                    @include('themes.starter.components.content-card', ['item' => $asideItem, 'cardVariant' => 'compact', 'cardType' => $detailType])
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </aside>
        </div>
    </article>
@endsection
