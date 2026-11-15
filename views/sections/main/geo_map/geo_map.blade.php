{{--
    Daftar peta tematik (WebGIS) dari $geoMaps.
    Pengaturan: title, subtitle, badge, limit, show_view_all, button_text, button_url.
--}}
@php
    $geoItems = collect(($geoMaps ?? null) instanceof \Illuminate\Contracts\Pagination\Paginator ? $geoMaps->items() : ($geoMaps ?? []))->take((int) ($config['limit'] ?? 6))->values();
    $geoTitle = array_key_exists('title', $config) ? $config['title'] : 'Peta & Informasi Geospasial';
    $geoSubtitle = array_key_exists('subtitle', $config) ? $config['subtitle'] : 'Jelajahi peta tematik resmi instansi.';
@endphp
<section class="section" data-section-type="geo_map">
    <div class="container-page">
        @include('themes.starter.components.section-heading', [
            'title' => $geoTitle,
            'subtitle' => $geoSubtitle,
            'headingBadge' => $config['badge'] ?? null,
            'headingActionText' => ($config['show_view_all'] ?? true) ? ($config['button_text'] ?? 'Semua peta') : null,
            'headingActionUrl' => $config['button_url'] ?? route('public.geo-maps.index'),
        ])
        @if($geoItems->isEmpty())
            @include('themes.starter.components.empty-state', ['emptyMessage' => 'Belum ada peta yang dipublikasikan.', 'emptyIcon' => 'map'])
        @else
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($geoItems as $geoItem)
                    <a href="{{ route('public.geo-maps.show', data_get($geoItem, 'slug')) }}" class="card card-hover group overflow-hidden">
                        <div class="flex aspect-video items-center justify-center bg-linear-to-br from-primary/15 to-secondary/15 text-primary">
                            @if(data_get($geoItem, 'thumbnail_url'))
                                <img src="{{ data_get($geoItem, 'thumbnail_url') }}" alt="" class="size-full object-cover" loading="lazy">
                            @else
                                @include('themes.starter.components.icon', ['name' => 'map', 'class' => 'size-12'])
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="font-semibold text-slate-900 group-hover:text-primary">{{ data_get($geoItem, 'title') }}</h3>
                            <p class="mt-1 line-clamp-2 text-sm text-slate-600">{{ data_get($geoItem, 'description') }}</p>
                            <p class="mt-3 flex items-center gap-1 text-xs text-slate-500">
                                @include('themes.starter.components.icon', ['name' => 'layers', 'class' => 'size-3.5'])
                                {{ collect(data_get($geoItem, 'layers') ?? [])->count() }} layer
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
