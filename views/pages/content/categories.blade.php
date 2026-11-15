{{-- Daftar kategori konten. Variabel: $categories (name, slug, contents_count). --}}
@extends('themes.starter.layouts.public')

@section('content')
    @include('themes.starter.components.page-header', ['title' => 'Kategori', 'subtitle' => 'Telusuri konten berdasarkan kategori.', 'breadcrumbs' => [['label' => 'Kategori']]])

    <div class="container-page py-10">
        @if(count($categories ?? []) === 0)
            @include('themes.starter.components.empty-state', ['emptyMessage' => 'Belum ada kategori.', 'emptyIcon' => 'layers'])
        @else
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($categories as $categoryItem)
                    <a href="{{ route('public.categories.show', data_get($categoryItem, 'slug')) }}" class="card card-hover flex items-center justify-between p-5">
                        <span class="font-semibold text-slate-900">{{ data_get($categoryItem, 'name') }}</span>
                        @if(! is_null(data_get($categoryItem, 'contents_count')))
                            <span class="badge">{{ data_get($categoryItem, 'contents_count') }}</span>
                        @endif
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
