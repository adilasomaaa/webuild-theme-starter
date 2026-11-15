{{--
    Peta lokasi (Google Maps embed).
    Pengaturan: title, subtitle, embed_url atau map_embed_url (boleh berupa kode <iframe>), layout_orientation (vertical|horizontal).
    Tanpa URL, peta dicari otomatis dari alamat instansi.
--}}
@php
    $mapAddress = data_get($address ?? null, 'full_address') ?: data_get($profile ?? null, 'address');
    $mapRaw = $config['embed_url'] ?? $config['map_embed_url'] ?? '';
    $mapSrc = preg_match('/src=["\']([^"\']+)["\']/', $mapRaw, $mapMatch) ? $mapMatch[1] : $mapRaw;
    if (! $mapSrc && $mapAddress) {
        $mapSrc = 'https://maps.google.com/maps?q=' . urlencode($mapAddress) . '&output=embed';
    }
    $mapHorizontal = ($config['layout_orientation'] ?? 'horizontal') === 'horizontal' && ! ($inFooter ?? false);
@endphp
<section class="{{ ($inFooter ?? false) ? '' : 'section' }}" data-section-type="maps_embed">
    <div class="{{ ($inFooter ?? false) ? '' : 'container-page' }} {{ $mapHorizontal ? 'grid items-center gap-10 lg:grid-cols-3' : '' }}">
        @unless($inFooter ?? false)
            <div>
                @include('themes.starter.components.section-heading', [
                    'title' => $config['title'] ?? 'Lokasi Kami',
                    'subtitle' => $config['subtitle'] ?? $mapAddress,
                ])
            </div>
        @endunless
        <div class="{{ $mapHorizontal ? 'lg:col-span-2' : '' }}">
            @if($mapSrc)
                <iframe src="{{ $mapSrc }}" title="Peta lokasi" class="aspect-video w-full rounded-2xl border border-slate-200" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            @else
                @include('themes.starter.components.empty-state', ['emptyMessage' => 'Atur URL peta atau alamat instansi.', 'emptyIcon' => 'map-pin'])
            @endif
        </div>
    </div>
</section>
