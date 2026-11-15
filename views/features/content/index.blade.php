{{--
    Indeks berita/artikel (/news, /article, /f/{feature}).
    Variabel: $feature, $contents (paginator), $featuredContents, $availableCategories, $pageSettings, $layoutVariant (grid|list).
--}}
@extends('themes.starter.layouts.public')

@php
    $indexTitle = $pageSettings['title'] ?? data_get($feature ?? null, 'name', 'Berita');
    $indexVariant = request('layout', $layoutVariant ?? ($pageSettings['default_variant'] ?? 'grid'));
@endphp

@section('content')
    @include('themes.starter.components.page-header', [
        'title' => $indexTitle,
        'subtitle' => $pageSettings['subtitle'] ?? data_get($feature ?? null, 'description'),
        'breadcrumbs' => [['label' => $indexTitle]],
    ])

    <div class="container-page py-10">
        <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex flex-wrap gap-2">
                <a href="{{ url()->current() }}" class="btn btn-sm {{ request('category') ? 'btn-ghost' : 'btn-primary' }}">Semua</a>
                @foreach(($availableCategories ?? []) as $indexCategory)
                    <a href="{{ request()->fullUrlWithQuery(['category' => data_get($indexCategory, 'slug'), 'page' => null]) }}"
                       class="btn btn-sm {{ request('category') === data_get($indexCategory, 'slug') ? 'btn-primary' : 'btn-ghost' }}">{{ data_get($indexCategory, 'name') }}</a>
                @endforeach
            </div>
            <div class="flex gap-2">
                <form method="GET" class="flex-1">
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari {{ mb_strtolower($indexTitle) }}..." class="form-input md:w-64" aria-label="Cari">
                </form>
                <a href="{{ request()->fullUrlWithQuery(['layout' => 'grid']) }}" class="btn btn-sm {{ $indexVariant === 'grid' ? 'btn-primary' : 'btn-ghost' }}" aria-label="Tampilan grid">@include('themes.starter.components.icon', ['name' => 'grid', 'class' => 'size-4'])</a>
                <a href="{{ request()->fullUrlWithQuery(['layout' => 'list']) }}" class="btn btn-sm {{ $indexVariant === 'list' ? 'btn-primary' : 'btn-ghost' }}" aria-label="Tampilan daftar">@include('themes.starter.components.icon', ['name' => 'list', 'class' => 'size-4'])</a>
            </div>
        </div>

        @if(count($contents ?? []) === 0)
            @include('themes.starter.components.empty-state', ['emptyMessage' => 'Belum ada konten yang sesuai.', 'emptyIcon' => 'megaphone'])
        @else
            <div class="{{ $indexVariant === 'list' ? 'space-y-4' : 'grid gap-6 sm:grid-cols-2 lg:grid-cols-3' }}">
                @foreach($contents as $indexItem)
                    @include('themes.starter.components.content-card', ['item' => $indexItem, 'cardVariant' => $indexVariant === 'list' ? 'list' : 'grid', 'cardType' => request()->routeIs('public.news.*') ? 'news' : 'article'])
                @endforeach
            </div>
            @if(method_exists($contents, 'links'))
                {{ $contents->links('themes.starter.components.pagination') }}
            @endif
        @endif
    </div>
@endsection
