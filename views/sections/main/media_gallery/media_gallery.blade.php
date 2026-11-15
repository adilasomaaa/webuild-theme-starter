{{--
    Galeri foto & video dari $mediaItems.
    Varian (config.layout_variant): asymmetric_grid | marquee.
    Pengaturan: title, subtitle, media_type (all|image|video), category_id, limit, show_filter_tabs.
--}}
@php
    $galleryVariant = $config['layout_variant'] ?? $variant ?? 'asymmetric_grid';
    $galleryType = $config['media_type'] ?? 'all';
    $galleryItems = collect(($mediaItems ?? null) instanceof \Illuminate\Contracts\Pagination\Paginator ? $mediaItems->items() : ($mediaItems ?? []))
        ->when($galleryType !== 'all', fn ($items) => $items->where('type', $galleryType))
        ->when(! empty($config['category_id']), fn ($items) => $items->filter(fn ($m) => (string) data_get($m, 'category_id') === (string) $config['category_id']))
        ->take((int) ($config['limit'] ?? 8))
        ->values();
    $galleryCategories = $galleryItems->map(fn ($m) => data_get($m, 'category'))->filter()->unique(fn ($c) => data_get($c, 'id'))->values();
    $galleryShowTabs = ($config['show_filter_tabs'] ?? true) && $galleryCategories->count() > 1 && $galleryVariant !== 'marquee';
    $galleryThumb = fn ($m) => data_get($m, 'thumbnail_url') ?? data_get($m, 'image_url') ?? data_get($m, 'file_url') ?? data_get($m, 'media_url');
    $galleryLink = fn ($m) => data_get($m, 'embed_url') ?? data_get($m, 'external_url') ?? data_get($m, 'media_url') ?? data_get($m, 'file_url') ?? data_get($m, 'image_url') ?? '#';
@endphp
<section class="section" data-section-type="media_gallery" id="galeri">
    <div class="container-page" data-filter-group>
        @include('themes.starter.components.section-heading', [
            'title' => $config['title'] ?? 'Galeri Kegiatan',
            'subtitle' => $config['subtitle'] ?? 'Dokumentasi foto dan video kegiatan instansi.',
            'headingActionText' => 'Lihat galeri',
            'headingActionUrl' => route('public.media.index'),
        ])

        @if($galleryShowTabs)
            <div class="mb-6 flex flex-wrap gap-2">
                <button type="button" data-filter="all" aria-pressed="true" class="btn btn-sm btn-ghost aria-pressed:bg-primary aria-pressed:text-white">Semua</button>
                @foreach($galleryCategories as $galleryCategory)
                    <button type="button" data-filter="{{ data_get($galleryCategory, 'id') }}" aria-pressed="false" class="btn btn-sm btn-ghost aria-pressed:bg-primary aria-pressed:text-white">{{ data_get($galleryCategory, 'name') }}</button>
                @endforeach
            </div>
        @endif

        @if($galleryItems->isEmpty())
            @include('themes.starter.components.empty-state', ['emptyMessage' => 'Belum ada dokumentasi.', 'emptyIcon' => 'image'])
        @elseif($galleryVariant === 'marquee')
            <div class="overflow-hidden">
                <div class="flex w-max animate-marquee gap-4 hover:[animation-play-state:paused]">
                    @foreach([1, 2] as $loopCopy)
                        @foreach($galleryItems as $mediaItem)
                            <a href="{{ $galleryLink($mediaItem) }}" target="_blank" rel="noopener" class="block w-72 shrink-0 overflow-hidden rounded-xl" @if($loopCopy === 2) aria-hidden="true" tabindex="-1" @endif>
                                <img src="{{ $galleryThumb($mediaItem) }}" alt="{{ data_get($mediaItem, 'title') }}" class="aspect-[4/3] w-full object-cover" loading="lazy">
                            </a>
                        @endforeach
                    @endforeach
                </div>
            </div>
        @else
            <div class="grid auto-rows-[180px] grid-cols-2 gap-3 md:grid-cols-4">
                @foreach($galleryItems as $mediaItem)
                    <a href="{{ $galleryLink($mediaItem) }}" target="_blank" rel="noopener" data-filter-item="{{ data_get($mediaItem, 'category.id', data_get($mediaItem, 'category_id')) }}"
                       class="group relative overflow-hidden rounded-xl bg-slate-100 {{ $loop->first ? 'col-span-2 row-span-2' : '' }}">
                        <img src="{{ $galleryThumb($mediaItem) }}" alt="{{ data_get($mediaItem, 'title') }}" class="size-full object-cover transition duration-300 group-hover:scale-105" loading="lazy">
                        <div class="absolute inset-0 flex items-end bg-linear-to-t from-slate-900/70 to-transparent p-3 opacity-0 transition group-hover:opacity-100">
                            <p class="line-clamp-2 text-sm font-medium text-white">{{ data_get($mediaItem, 'title') }}</p>
                        </div>
                        @if(data_get($mediaItem, 'type') === 'video')
                            <span class="absolute left-1/2 top-1/2 flex size-12 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-primary">
                                @include('themes.starter.components.icon', ['name' => 'play', 'class' => 'size-5'])
                            </span>
                        @endif
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
