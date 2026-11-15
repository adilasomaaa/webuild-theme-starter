{{--
    Halaman FAQ (/f/faqs).
    Variabel: $faqs, $categories (daftar nama kategori), $category (terpilih), $search, $pageSettings (title, subtitle, show_category_filter).
--}}
@extends('themes.starter.layouts.public')

@php
    $faqPageTitle = $pageSettings['title'] ?? 'Pertanyaan Umum';
    $faqSelected = $category ?? $selectedCategory ?? '';
@endphp

@section('content')
    @include('themes.starter.components.page-header', ['title' => $faqPageTitle, 'subtitle' => $pageSettings['subtitle'] ?? null, 'breadcrumbs' => [['label' => $faqPageTitle]]])

    <div class="container-page max-w-3xl py-10">
        <form method="GET" class="mb-6 flex gap-2">
            <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Cari pertanyaan..." class="form-input" aria-label="Cari pertanyaan">
            @if($faqSelected)
                <input type="hidden" name="category" value="{{ $faqSelected }}">
            @endif
            <button class="btn btn-primary">Cari</button>
        </form>

        @if(($pageSettings['show_category_filter'] ?? true) && collect($categories ?? [])->isNotEmpty())
            <div class="mb-8 flex flex-wrap gap-2">
                <a href="{{ route('public.faqs.index', array_filter(['search' => $search ?? null])) }}" class="btn btn-sm {{ $faqSelected === '' ? 'btn-primary' : 'btn-ghost' }}">Semua</a>
                @foreach($categories as $faqCategory)
                    @php($faqCategoryName = is_string($faqCategory) ? $faqCategory : data_get($faqCategory, 'name'))
                    <a href="{{ route('public.faqs.index', array_filter(['category' => $faqCategoryName, 'search' => $search ?? null])) }}"
                       class="btn btn-sm {{ $faqSelected === $faqCategoryName ? 'btn-primary' : 'btn-ghost' }}">{{ $faqCategoryName }}</a>
                @endforeach
            </div>
        @endif

        <div class="space-y-3">
            @forelse(($faqs ?? []) as $faqItem)
                @include('themes.starter.components.faq-item', ['faqItem' => $faqItem, 'faqOpen' => false])
            @empty
                @include('themes.starter.components.empty-state', ['emptyMessage' => 'Pertanyaan tidak ditemukan.', 'emptyIcon' => 'help'])
            @endforelse
        </div>
    </div>
@endsection
