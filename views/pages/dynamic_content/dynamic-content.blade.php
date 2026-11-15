{{--
    Indeks konten dinamis / katalog (/f/catalog).
    Variabel: $contents (paginator), $categories, $selectedCategory, $search, $pageSettings, $layoutVariant.
--}}
@extends('themes.starter.layouts.public')

@php
    $catalogTitle = data_get($selectedCategory ?? null, 'name') ?? ($pageSettings['title'] ?? 'Katalog Informasi');
@endphp

@section('content')
    @include('themes.starter.components.page-header', [
        'title' => $catalogTitle,
        'subtitle' => data_get($selectedCategory ?? null, 'description') ?? ($pageSettings['subtitle'] ?? null),
        'breadcrumbs' => [['label' => $catalogTitle]],
    ])

    <div class="container-page py-10">
        <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('public.dynamic-content.index') }}" class="btn btn-sm {{ empty($selectedCategory) ? 'btn-primary' : 'btn-ghost' }}">Semua</a>
                @foreach(($categories ?? []) as $catalogCategory)
                    <a href="{{ route('public.dynamic-category.show', data_get($catalogCategory, 'slug')) }}"
                       class="btn btn-sm {{ data_get($selectedCategory ?? null, 'id') == data_get($catalogCategory, 'id') ? 'btn-primary' : 'btn-ghost' }}">{{ data_get($catalogCategory, 'name') }}</a>
                @endforeach
            </div>
            <form method="GET">
                <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Cari..." class="form-input md:w-64" aria-label="Cari">
            </form>
        </div>

        @if(count($contents ?? []) === 0)
            @include('themes.starter.components.empty-state', ['emptyMessage' => 'Belum ada data.', 'emptyIcon' => 'layers'])
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($contents as $catalogItem)
                    @include('themes.starter.components.dynamic-card', ['dynamicItem' => $catalogItem])
                @endforeach
            </div>
            @if(method_exists($contents, 'links'))
                {{ $contents->links('themes.starter.components.pagination') }}
            @endif
        @endif
    </div>
@endsection
