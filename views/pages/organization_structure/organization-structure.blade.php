{{--
    Struktur organisasi (/f/organisasi).
    Variabel: $tree (node bertingkat dengan children), $structures (daftar datar), $search, $pageSettings.
--}}
@extends('themes.starter.layouts.public')

@php
    $orgTitle = $pageSettings['title'] ?? 'Struktur Organisasi';
    $orgTree = collect($tree ?? []);
    $orgFlat = collect($structures ?? []);
@endphp

@section('content')
    @include('themes.starter.components.page-header', ['title' => $orgTitle, 'subtitle' => $pageSettings['subtitle'] ?? null, 'breadcrumbs' => [['label' => $orgTitle]]])

    <div class="container-page py-10">
        @if($orgTree->isNotEmpty())
            <ul class="space-y-4">
                @foreach($orgTree as $orgRoot)
                    @include('themes.starter.components.org-tree-node', ['orgNode' => $orgRoot, 'orgDepth' => 0])
                @endforeach
            </ul>
        @elseif($orgFlat->isNotEmpty())
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($orgFlat as $orgItem)
                    @include('themes.starter.components.person-card', ['orgNode' => $orgItem, 'orgShowHolder' => true, 'orgShowContact' => false])
                @endforeach
            </div>
        @else
            @include('themes.starter.components.empty-state', ['emptyMessage' => 'Struktur organisasi belum diisi.', 'emptyIcon' => 'users'])
        @endif
    </div>
@endsection
