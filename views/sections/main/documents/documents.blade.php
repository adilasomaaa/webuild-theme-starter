{{--
    Daftar dokumen terbaru dari $documents.
    Varian (config.layout_variant): grid | list. Pengaturan: title, subtitle, category_id, limit.
--}}
@php
    $docsVariant = $config['layout_variant'] ?? $variant ?? 'grid';
    $docsItems = collect(($documents ?? null) instanceof \Illuminate\Contracts\Pagination\Paginator ? $documents->items() : ($documents ?? []))
        ->when(! empty($config['category_id']), fn ($items) => $items->filter(fn ($doc) => (string) data_get($doc, 'category_id', data_get($doc, 'category.id')) === (string) $config['category_id']))
        ->take((int) ($config['limit'] ?? 6))
        ->values();
@endphp
<section class="section section-muted" data-section-type="documents" id="dokumen">
    <div class="container-page">
        @include('themes.starter.components.section-heading', [
            'title' => $config['title'] ?? 'Dokumen Publik',
            'subtitle' => $config['subtitle'] ?? 'Regulasi, laporan, dan dokumen resmi yang dapat diunduh.',
            'headingActionText' => 'Semua dokumen',
            'headingActionUrl' => route('public.documents.index'),
        ])
        @if($docsItems->isEmpty())
            @include('themes.starter.components.empty-state', ['emptyMessage' => 'Belum ada dokumen yang dipublikasikan.', 'emptyIcon' => 'file'])
        @else
            <div class="grid gap-4 {{ $docsVariant === 'list' ? '' : 'md:grid-cols-2' }}">
                @foreach($docsItems as $docItem)
                    @include('themes.starter.components.document-item', ['document' => $docItem, 'docVariant' => 'list'])
                @endforeach
            </div>
        @endif
    </div>
</section>
