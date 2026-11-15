{{--
    Daftar ikon media sosial dari profil instansi, ditambah tautan kustom.
    Parameter: opsional $socialExtra (array of ['label','url','platform']), $socialDark (bool, untuk latar gelap)
--}}
@php
    $socialPlatforms = ['instagram' => 'Instagram', 'facebook' => 'Facebook', 'twitter' => 'X (Twitter)', 'youtube' => 'YouTube', 'website' => 'Situs Resmi'];
    $socialItems = collect($socialPlatforms)
        ->map(fn ($label, $platform) => ['platform' => $platform, 'label' => $label, 'url' => data_get($profile ?? null, "{$platform}_url")])
        ->merge(collect($socialExtra ?? [])->map(fn ($link) => [
            'platform' => data_get($link, 'platform', 'link'),
            'label' => data_get($link, 'label', 'Tautan'),
            'url' => data_get($link, 'url'),
        ]))
        ->filter(fn ($link) => filled($link['url']))
        ->values();
@endphp
@if($socialItems->isNotEmpty())
    <div class="flex flex-wrap gap-2">
        @foreach($socialItems as $social)
            <a href="{{ $social['url'] }}" target="_blank" rel="noopener" aria-label="{{ $social['label'] }}" title="{{ $social['label'] }}"
               class="flex size-9 items-center justify-center rounded-full transition {{ ($socialDark ?? false) ? 'bg-white/10 text-slate-300 hover:bg-primary hover:text-white' : 'bg-slate-100 text-slate-600 hover:bg-primary hover:text-white' }}">
                @include('themes.starter.components.icon', ['name' => $social['platform'] === 'website' ? 'globe' : $social['platform'], 'class' => 'size-4'])
            </a>
        @endforeach
    </div>
@endif
