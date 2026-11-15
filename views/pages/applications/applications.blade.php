{{-- Daftar aplikasi terdaftar (/f/aplikasi). Variabel: $applications, $search, $totalCount, $pageSettings. --}}
@extends('themes.starter.layouts.public')

@php
    $appsTitle = $pageSettings['title'] ?? 'Aplikasi & Layanan Digital';
@endphp

@section('content')
    @include('themes.starter.components.page-header', ['title' => $appsTitle, 'subtitle' => $pageSettings['subtitle'] ?? null, 'breadcrumbs' => [['label' => $appsTitle]]])

    <div class="container-page py-10">
        <form method="GET" class="mb-8 flex max-w-md gap-2">
            <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Cari aplikasi..." class="form-input" aria-label="Cari aplikasi">
            <button class="btn btn-primary">Cari</button>
        </form>
        @if(count($applications ?? []) === 0)
            @include('themes.starter.components.empty-state', ['emptyMessage' => 'Aplikasi tidak ditemukan.', 'emptyIcon' => 'apps'])
        @else
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($applications as $applicationItem)
                    @include('themes.starter.components.app-card', ['appItem' => $applicationItem])
                @endforeach
            </div>
            @if(method_exists($applications, 'links'))
                {{ $applications->links('themes.starter.components.pagination') }}
            @endif
        @endif
    </div>
@endsection
