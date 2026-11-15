{{--
    Detail jabatan. Variabel: $structure (position_name, description, activeHolders|holders, parent, children).
--}}
@extends('themes.starter.layouts.public')

@php
    $detailHolders = collect(data_get($structure, 'activeHolders') ?? data_get($structure, 'holders') ?? []);
@endphp

@section('content')
    @include('themes.starter.components.page-header', [
        'title' => data_get($structure, 'position_name'),
        'subtitle' => data_get($structure, 'parent.position_name') ? 'Di bawah ' . data_get($structure, 'parent.position_name') : null,
        'breadcrumbs' => [['label' => 'Struktur Organisasi', 'url' => route('public.organization-structures.index')], ['label' => data_get($structure, 'position_name')]],
    ])

    <div class="container-page grid gap-10 py-10 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            @foreach($detailHolders as $detailHolder)
                <div class="card flex flex-col gap-5 p-6 sm:flex-row">
                    @if(data_get($detailHolder, 'photo_url'))
                        <img src="{{ data_get($detailHolder, 'photo_url') }}" alt="Foto {{ data_get($detailHolder, 'name') }}" class="h-48 w-40 shrink-0 rounded-xl object-cover object-top">
                    @endif
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">{{ data_get($detailHolder, 'name') }}</h2>
                        <p class="text-slate-600">{{ data_get($detailHolder, 'title') ?? data_get($structure, 'position_name') }}</p>
                        @if(data_get($detailHolder, 'contact'))
                            <p class="mt-3 text-sm text-slate-500">{{ data_get($detailHolder, 'contact') }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
            @if(data_get($structure, 'description'))
                <div class="prose-content">{!! data_get($structure, 'description') !!}</div>
            @endif
        </div>
        @if(collect(data_get($structure, 'children') ?? [])->isNotEmpty())
            <aside class="card h-fit p-5">
                <h2 class="mb-3 font-semibold text-slate-900">Unit di bawahnya</h2>
                <ul class="space-y-2 text-sm">
                    @foreach(data_get($structure, 'children') as $childNode)
                        <li><a href="{{ route('public.organization-structures.show', data_get($childNode, 'slug')) }}" class="link">{{ data_get($childNode, 'position_name') }}</a></li>
                    @endforeach
                </ul>
            </aside>
        @endif
    </div>
@endsection
