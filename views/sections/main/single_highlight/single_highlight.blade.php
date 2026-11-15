{{--
    Sorotan satu konten pilihan.
    Pengaturan: content_type (article|news), content_id, custom_title, custom_description, button_text.
--}}
@php
    $highlightPool = collect(($allContents ?? null) instanceof \Illuminate\Contracts\Pagination\Paginator ? $allContents->items() : ($allContents ?? []));
    $highlightItem = (! empty($config['content_id']) ? $highlightPool->firstWhere('id', $config['content_id']) : null) ?? $highlightPool->first();
    $highlightType = data_get($highlightItem, 'type');
    $highlightType = is_object($highlightType) ? ($highlightType->value ?? null) : $highlightType;
    $highlightUrl = data_get($highlightItem, 'slug')
        ? ($highlightType === 'news' ? route('public.news.show', data_get($highlightItem, 'slug')) : route('public.articles.show', data_get($highlightItem, 'slug')))
        : '#';
    $highlightImage = data_get($highlightItem, 'featured_image_url') ?? data_get($highlightItem, 'thumbnail');
@endphp
@if($highlightItem)
    <section class="section section-muted" data-section-type="single_highlight">
        <div class="container-page">
            <div class="card grid overflow-hidden md:grid-cols-2">
                <div class="aspect-video bg-slate-100 md:aspect-auto">
                    @if($highlightImage)
                        <img src="{{ $highlightImage }}" alt="" class="size-full object-cover" loading="lazy">
                    @endif
                </div>
                <div class="flex flex-col justify-center p-8 sm:p-10">
                    <span class="badge mb-4 self-start">@include('themes.starter.components.icon', ['name' => 'star', 'class' => 'size-3.5']) Sorotan</span>
                    <h2 class="text-2xl font-bold text-slate-900 sm:text-3xl">{{ $config['custom_title'] ?? data_get($highlightItem, 'title') }}</h2>
                    <p class="mt-4 text-slate-600">{{ $config['custom_description'] ?? (data_get($highlightItem, 'summary') ?? data_get($highlightItem, 'excerpt')) }}</p>
                    <a href="{{ $highlightUrl }}" class="btn btn-primary mt-6 self-start">
                        {{ ! empty($config['button_text']) ? $config['button_text'] : 'Lihat Selengkapnya' }}
                        @include('themes.starter.components.icon', ['name' => 'arrow-right', 'class' => 'size-4'])
                    </a>
                </div>
            </div>
        </div>
    </section>
@endif
