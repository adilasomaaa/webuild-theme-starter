{{--
    Daftar berita/artikel terbaru dari $allContents.
    Varian (config.layout_variant): grid | list | featured_list.
    Pengaturan: title, subtitle, content_type (all|news|article), category_id, limit, button_text, button_url.
--}}
@php
    $contentsVariant = $config['layout_variant'] ?? $variant ?? 'grid';
    $contentsType = $config['content_type'] ?? 'all';
    $contentsItems = collect(($allContents ?? null) instanceof \Illuminate\Contracts\Pagination\Paginator ? $allContents->items() : ($allContents ?? []))
        ->when($contentsType !== 'all', fn ($items) => $items->filter(function ($item) use ($contentsType) {
            $type = data_get($item, 'type');

            return (is_object($type) ? ($type->value ?? null) : $type) === $contentsType;
        }))
        ->when(! empty($config['category_id']), fn ($items) => $items->filter(fn ($item) => (string) data_get($item, 'category.id', data_get($item, 'category_id')) === (string) $config['category_id']))
        ->take((int) ($config['limit'] ?? 6))
        ->values();
    $contentsAllUrl = $config['button_url'] ?? ($contentsType === 'article' ? route('public.articles.index') : route('public.news.index'));
@endphp
<section class="section" data-section-type="contents" id="berita">
    <div class="container-page">
        @include('themes.starter.components.section-heading', [
            'title' => $config['title'] ?? 'Berita & Informasi Terbaru',
            'subtitle' => $config['subtitle'] ?? 'Kabar resmi seputar kegiatan, kebijakan, dan layanan instansi.',
            'headingActionText' => $config['button_text'] ?? 'Lihat semua',
            'headingActionUrl' => $contentsAllUrl,
        ])

        @if($contentsItems->isEmpty())
            @include('themes.starter.components.empty-state', ['emptyMessage' => 'Belum ada berita yang diterbitkan.', 'emptyIcon' => 'megaphone'])
        @elseif($contentsVariant === 'featured_list')
            <div class="grid gap-6 lg:grid-cols-5">
                <div class="lg:col-span-3">
                    @include('themes.starter.components.content-card', ['item' => $contentsItems->first(), 'cardVariant' => 'grid'])
                </div>
                <div class="card divide-y divide-slate-100 p-5 lg:col-span-2">
                    @foreach($contentsItems->skip(1) as $contentItem)
                        <div class="py-4 first:pt-0 last:pb-0">
                            @include('themes.starter.components.content-card', ['item' => $contentItem, 'cardVariant' => 'compact'])
                        </div>
                    @endforeach
                </div>
            </div>
        @elseif($contentsVariant === 'list')
            <div class="space-y-4">
                @foreach($contentsItems as $contentItem)
                    @include('themes.starter.components.content-card', ['item' => $contentItem, 'cardVariant' => 'list'])
                @endforeach
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($contentsItems as $contentItem)
                    @include('themes.starter.components.content-card', ['item' => $contentItem, 'cardVariant' => 'grid'])
                @endforeach
            </div>
        @endif
    </div>
</section>
