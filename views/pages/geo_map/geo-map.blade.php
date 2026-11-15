{{--
    Peta interaktif (Leaflet). Variabel: $map (title, description, center_lat, center_lng, zoom_level, layers).
    Contoh ini hanya menampilkan peta dasar; tambahkan layer WMS/GeoJSON sesuai $map->layers.
--}}
@extends('themes.starter.layouts.public')

@push('head')
    @vite('resources/js/vendor/leaflet.ts')
@endpush

@section('content')
    @include('themes.starter.components.page-header', [
        'title' => data_get($map, 'title', 'Peta'),
        'subtitle' => data_get($map, 'description'),
        'breadcrumbs' => [['label' => 'Peta', 'url' => route('public.geo-maps.index')], ['label' => data_get($map, 'title', 'Peta')]],
    ])

    <div class="container-page grid gap-6 py-10 lg:grid-cols-4">
        <div id="peta" class="h-[70vh] rounded-2xl border border-slate-200 lg:col-span-3"
             data-lat="{{ data_get($map, 'center_lat', 0.5435) }}" data-lng="{{ data_get($map, 'center_lng', 123.0568) }}" data-zoom="{{ data_get($map, 'zoom_level', 10) }}"></div>
        <aside class="card h-fit p-5">
            <h2 class="mb-3 font-semibold text-slate-900">Layer</h2>
            <ul class="space-y-2 text-sm">
                @forelse(data_get($map, 'layers') ?? [] as $mapLayer)
                    <li class="flex items-center gap-2">@include('themes.starter.components.icon', ['name' => 'layers', 'class' => 'size-4 text-primary']) {{ data_get($mapLayer, 'name') ?? data_get($mapLayer, 'title') ?? data_get($mapLayer, 'wms_layer_name') }}</li>
                @empty
                    <li class="text-slate-500">Tidak ada layer tambahan.</li>
                @endforelse
            </ul>
        </aside>
    </div>
@endsection

@push('scripts')
    <script>
        window.addEventListener('load', () => {
            const el = document.getElementById('peta');
            if (!el || !window.L) return;
            const map = L.map(el).setView([Number(el.dataset.lat), Number(el.dataset.lng)], Number(el.dataset.zoom));
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap' }).addTo(map);
        });
    </script>
@endpush
