{{--
    Indeks dokumen (/document).
    Variabel: $feature, $contents (paginator dokumen), $availableCategories, $availableYears, $pageSettings, $layoutVariant.
    Pengaturan halaman (grup "dokumen"): title, subtitle, default_variant (foldering|grid|list),
    show_variant_switcher, show_category_filter, show_year_filter.
--}}
@extends('themes.starter.layouts.public')

@php
    $docIndexTitle = $pageSettings['title'] ?? data_get($feature ?? null, 'name', 'Dokumen Publik');
    $docLayout = $layoutVariant ?? ($pageSettings['default_variant'] ?? 'foldering');
    $docShowCategory = $pageSettings['show_category_filter'] ?? true;
    $docShowYear = $pageSettings['show_year_filter'] ?? true;
    $docLayoutQuery = request()->except('page');
    $docLayouts = ['foldering' => ['Folder', 'folder'], 'grid' => ['Grid', 'grid'], 'list' => ['List', 'list']];
@endphp

@section('content')
    @include('themes.starter.components.page-header', [
        'title' => $docIndexTitle,
        'subtitle' => $pageSettings['subtitle'] ?? data_get($feature ?? null, 'description'),
        'breadcrumbs' => [['label' => $docIndexTitle]],
    ])

    <div class="container-page py-10">
        <form method="GET" class="card mb-6 grid gap-3 p-4 sm:grid-cols-4">
            @if(request('layout'))
                <input type="hidden" name="layout" value="{{ request('layout') }}">
            @endif
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari judul dokumen..." class="form-input sm:col-span-2" aria-label="Cari dokumen">
            @if($docShowCategory)
                <select name="category_id" class="form-input" aria-label="Kategori">
                    <option value="">Semua kategori</option>
                    @foreach(($availableCategories ?? []) as $docCategory)
                        <option value="{{ data_get($docCategory, 'id') }}" @selected((string) request('category_id') === (string) data_get($docCategory, 'id'))>{{ data_get($docCategory, 'name') }}</option>
                    @endforeach
                </select>
            @endif
            <div class="flex gap-2">
                @if($docShowYear)
                    <select name="year" class="form-input" aria-label="Tahun">
                        <option value="">Semua tahun</option>
                        @foreach(($availableYears ?? []) as $docYear)
                            <option value="{{ $docYear }}" @selected((string) request('year') === (string) $docYear)>{{ $docYear }}</option>
                        @endforeach
                    </select>
                @endif
                <button type="submit" class="btn btn-primary">@include('themes.starter.components.icon', ['name' => 'search', 'class' => 'size-4'])<span class="sr-only">Terapkan</span></button>
            </div>
        </form>

        @if($pageSettings['show_variant_switcher'] ?? true)
            <div class="mb-6 flex justify-end">
                <div class="inline-flex gap-1 rounded-xl border border-slate-200 bg-white p-1" role="group" aria-label="Tampilan dokumen">
                    @foreach($docLayouts as $docLayoutKey => [$docLayoutLabel, $docLayoutIcon])
                        <a href="{{ url()->current() . '?' . http_build_query(array_merge($docLayoutQuery, ['layout' => $docLayoutKey])) }}"
                           class="btn btn-sm {{ $docLayout === $docLayoutKey ? 'btn-primary' : 'btn-ghost' }}"
                           aria-current="{{ $docLayout === $docLayoutKey ? 'page' : 'false' }}">
                            @include('themes.starter.components.icon', ['name' => $docLayoutIcon, 'class' => 'size-4'])
                            {{ $docLayoutLabel }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @if(count($contents ?? []) === 0)
            @include('themes.starter.components.empty-state', ['emptyMessage' => 'Dokumen tidak ditemukan.', 'emptyIcon' => 'file'])
        @else
            @if($docLayout === 'foldering')
                {{-- Folder: dokumen dikelompokkan per kategori --}}
                <div class="space-y-3">
                    @foreach(collect($contents->items())->groupBy(fn ($doc) => data_get($doc, 'category.name') ?? 'Tanpa Kategori') as $docFolder => $docFolderItems)
                        <details class="card group" @if($loop->first) open @endif>
                            <summary class="flex cursor-pointer items-center gap-3 p-4 font-semibold text-slate-900">
                                @include('themes.starter.components.icon', ['name' => 'folder', 'class' => 'size-5 text-primary'])
                                <span class="flex-1">{{ $docFolder }}</span>
                                <span class="badge badge-muted">{{ $docFolderItems->count() }}</span>
                                @include('themes.starter.components.icon', ['name' => 'chevron-down', 'class' => 'size-4 transition group-open:rotate-180'])
                            </summary>
                            <div class="grid gap-3 border-t border-slate-100 p-4">
                                @foreach($docFolderItems as $docItem)
                                    @include('themes.starter.components.document-item', ['document' => $docItem, 'docVariant' => 'list'])
                                @endforeach
                            </div>
                        </details>
                    @endforeach
                </div>
            @else
                <div class="grid gap-4 {{ $docLayout === 'grid' ? 'sm:grid-cols-2 lg:grid-cols-3' : '' }}">
                    @foreach($contents as $docItem)
                        @include('themes.starter.components.document-item', ['document' => $docItem, 'docVariant' => $docLayout])
                    @endforeach
                </div>
            @endif
            @if(method_exists($contents, 'links'))
                {{ $contents->links('themes.starter.components.pagination') }}
            @endif
        @endif
    </div>
@endsection
