{{--
    Pemutar audio (podcast, siaran, lagu daerah).
    Pengaturan: title, subtitle, description, audio_url, cover_url, artist, autoplay, loop.
--}}
<section class="section" data-section-type="audio">
    <div class="container-page">
        <div class="card mx-auto flex max-w-3xl flex-col gap-6 p-6 sm:flex-row sm:items-center">
            @if(! empty($config['cover_url']))
                <img src="{{ $config['cover_url'] }}" alt="" class="size-28 shrink-0 rounded-xl object-cover" loading="lazy">
            @else
                <span class="flex size-28 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    @include('themes.starter.components.icon', ['name' => 'music', 'class' => 'size-10'])
                </span>
            @endif
            <div class="min-w-0 flex-1">
                @if(filled($config['subtitle'] ?? null))
                    <span class="badge mb-2">{{ $config['subtitle'] }}</span>
                @endif
                <h2 class="text-xl font-bold text-slate-900">{{ $config['title'] ?? 'Audio' }}</h2>
                @if(filled($config['artist'] ?? null))
                    <p class="text-sm text-slate-500">{{ $config['artist'] }}</p>
                @endif
                @if(filled($config['description'] ?? null))
                    <p class="mt-2 text-sm text-slate-600">{{ $config['description'] }}</p>
                @endif
                @if(! empty($config['audio_url']))
                    <audio controls preload="none" class="mt-4 w-full" @if(! empty($config['autoplay'])) autoplay @endif @if(! empty($config['loop'])) loop @endif>
                        <source src="{{ $config['audio_url'] }}">
                        Peramban Anda tidak mendukung pemutar audio.
                    </audio>
                @else
                    <p class="mt-4 text-sm text-slate-400">Atur URL audio pada pengaturan komponen.</p>
                @endif
            </div>
        </div>
    </div>
</section>
