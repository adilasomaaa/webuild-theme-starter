{{--
    Hasil pencarian (/search?q=...).
    Variabel: $keyword (atau $query), $type, $counts, $results (paginator berisi model Content, Document, DynamicContent, Page), $pageSettings.
--}}
@extends('themes.starter.layouts.public')

@php
    $searchKeyword = $keyword ?? $query ?? request('q', '');
    $searchResults = $results ?? collect();
    $searchUrl = function ($result): string {
        $kind = class_basename($result);
        $slug = data_get($result, 'slug');
        if (! $slug) {
            return '#';
        }

        return match (true) {
            $kind === 'Document' => route('public.documents.show', $slug),
            $kind === 'Page' => route('public.pages.show', $slug),
            $kind === 'DynamicContent' && data_get($result, 'category.slug') => route('public.dynamic-content.show', [data_get($result, 'category.slug'), $slug]),
            (is_object(data_get($result, 'type')) ? data_get($result, 'type')->value : data_get($result, 'type')) === 'news' => route('public.news.show', $slug),
            default => route('public.articles.show', $slug),
        };
    };
    $searchKindLabel = ['Document' => 'Dokumen', 'Page' => 'Halaman', 'DynamicContent' => 'Katalog', 'Content' => 'Berita & Artikel'];
@endphp

@section('content')
    @include('themes.starter.components.page-header', [
        'title' => $searchKeyword !== '' ? "Hasil pencarian \"{$searchKeyword}\"" : ($pageSettings['title'] ?? 'Pencarian'),
        'subtitle' => $searchKeyword !== '' ? number_format((int) ($counts['all'] ?? (method_exists($searchResults, 'total') ? $searchResults->total() : collect($searchResults)->count())), 0, ',', '.') . ' hasil ditemukan' : null,
        'breadcrumbs' => [['label' => 'Pencarian']],
    ])

    <div class="container-page max-w-4xl py-10">
        <form action="{{ route('public.search') }}" method="GET" class="mb-8 flex gap-2">
            <input type="search" name="q" value="{{ $searchKeyword }}" placeholder="Ketik kata kunci..." class="form-input py-3" aria-label="Kata kunci" autofocus>
            <button class="btn btn-primary">Cari</button>
        </form>

        <div class="space-y-4">
            @forelse($searchResults as $searchResult)
                <a href="{{ $searchUrl($searchResult) }}" class="card card-hover block p-5">
                    <span class="badge badge-muted mb-2">{{ $searchKindLabel[class_basename($searchResult)] ?? 'Konten' }}</span>
                    <h2 class="font-semibold text-slate-900">{{ data_get($searchResult, 'title') }}</h2>
                    <p class="mt-1 line-clamp-2 text-sm text-slate-600">{{ data_get($searchResult, 'excerpt') ?? data_get($searchResult, 'description') ?? \Illuminate\Support\Str::limit(strip_tags((string) data_get($searchResult, 'content')), 160) }}</p>
                </a>
            @empty
                @include('themes.starter.components.empty-state', ['emptyMessage' => $searchKeyword !== '' ? 'Tidak ada hasil. Coba kata kunci lain.' : 'Masukkan kata kunci untuk mulai mencari.', 'emptyIcon' => 'search'])
            @endforelse
        </div>
        @if(method_exists($searchResults, 'links'))
            {{ $searchResults->links('themes.starter.components.pagination') }}
        @endif
    </div>
@endsection
