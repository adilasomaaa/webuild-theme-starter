{{-- Daftar pranala/tautan (/f/pranala, /f/links). Variabel: $links, $search, $pageSettings, $subtitle. --}}
@extends('themes.starter.layouts.public')

@php
    $pranalaPageTitle = $pageSettings['title'] ?? 'Tautan Terkait';
@endphp

@section('content')
    @include('themes.starter.components.page-header', ['title' => $pranalaPageTitle, 'subtitle' => $subtitle ?? ($pageSettings['subtitle'] ?? null), 'breadcrumbs' => [['label' => $pranalaPageTitle]]])

    <div class="container-page py-10">
        <form method="GET" class="mb-8 flex max-w-md gap-2">
            <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Cari tautan..." class="form-input" aria-label="Cari tautan">
            <button class="btn btn-primary">Cari</button>
        </form>
        @if(count($links ?? []) === 0)
            @include('themes.starter.components.empty-state', ['emptyMessage' => 'Tautan tidak ditemukan.', 'emptyIcon' => 'link'])
        @else
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($links as $linkItem)
                    @include('themes.starter.components.link-card', ['linkItem' => $linkItem])
                @endforeach
            </div>
            @if(method_exists($links, 'links'))
                {{ $links->links('themes.starter.components.pagination') }}
            @endif
        @endif
    </div>
@endsection
