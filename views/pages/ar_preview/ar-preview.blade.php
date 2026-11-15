{{-- Pratinjau model 3D/AR. Variabel: $arPreview (title, description, file_url). --}}
@extends('themes.starter.layouts.public')

@push('head')
    @vite('resources/js/vendor/model-viewer.ts')
@endpush

@section('content')
    @include('themes.starter.components.page-header', [
        'title' => data_get($arPreview ?? null, 'title', 'Pratinjau 3D & AR'),
        'subtitle' => data_get($arPreview ?? null, 'description'),
        'breadcrumbs' => [['label' => 'Pratinjau 3D']],
    ])

    <div class="container-page py-10">
        @if(data_get($arPreview ?? null, 'file_url'))
            <model-viewer src="{{ data_get($arPreview, 'file_url') }}" alt="{{ data_get($arPreview, 'title') }}" ar camera-controls auto-rotate shadow-intensity="1"
                class="block h-[70vh] w-full rounded-2xl bg-slate-100"></model-viewer>
            <p class="mt-3 text-center text-sm text-slate-500">Seret untuk memutar · cubit untuk memperbesar · ketuk ikon AR di perangkat seluler</p>
        @else
            @include('themes.starter.components.empty-state', ['emptyMessage' => 'Model 3D tidak tersedia.', 'emptyIcon' => 'layers'])
        @endif
    </div>
@endsection
