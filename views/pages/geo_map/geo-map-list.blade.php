{{-- Daftar peta tematik (/f/map). Variabel: $maps, $search, $totalCount, $pageSettings. --}}
@extends('themes.starter.layouts.public')

@php
    $mapsTitle = $pageSettings['title'] ?? 'Peta Tematik';
@endphp

@section('content')
    @include('themes.starter.components.page-header', ['title' => $mapsTitle, 'subtitle' => $pageSettings['subtitle'] ?? null, 'breadcrumbs' => [['label' => $mapsTitle]]])

    <div class="container-page py-10">
        <form method="GET" class="mb-8 flex max-w-md gap-2">
            <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Cari peta..." class="form-input" aria-label="Cari peta">
            <button class="btn btn-primary">Cari</button>
        </form>
        <div class="section-col">
            @include('themes.starter.sections.main.geo_map.geo_map', ['config' => ['title' => null, 'subtitle' => null, 'show_view_all' => false, 'limit' => 100], 'geoMaps' => $maps ?? collect()])
        </div>
        @if(isset($maps) && method_exists($maps, 'links'))
            {{ $maps->links('themes.starter.components.pagination') }}
        @endif
    </div>
@endsection
