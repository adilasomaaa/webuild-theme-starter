{{--
    Kartu informasi dengan gambar dan tombol.
    Pengaturan: title, subtitle, description, image_url, button_text, button_url, open_in_new_tab, hide_border, hide_shadow.
--}}
@php
    $infoBorder = ! empty($config['hide_border']) || ! empty($config['no_border']) ? 'border-0' : '';
    $infoShadow = ! empty($config['hide_shadow']) || ! empty($config['no_shadow']) ? 'shadow-none' : '';
@endphp
<section class="section" data-section-type="card_info">
    <div class="container-page">
        <div class="card {{ $infoBorder }} {{ $infoShadow }} grid overflow-hidden {{ ! empty($config['image_url']) ? 'md:grid-cols-2' : '' }}">
            @if(! empty($config['image_url']))
                <img src="{{ $config['image_url'] }}" alt="" class="aspect-video size-full object-cover md:aspect-auto" loading="lazy">
            @endif
            <div class="flex flex-col justify-center p-8">
                @if(filled($config['subtitle'] ?? null))
                    <span class="badge mb-3 self-start">{{ $config['subtitle'] }}</span>
                @endif
                <h2 class="text-2xl font-bold text-slate-900">{{ $config['title'] ?? 'Informasi Layanan' }}</h2>
                <p class="mt-3 text-slate-600">{{ $config['description'] ?? 'Tambahkan deskripsi singkat untuk menjelaskan informasi atau layanan ini.' }}</p>
                @if(! empty($config['button_text']) && ! empty($config['button_url']))
                    <a href="{{ $config['button_url'] }}" @if(! empty($config['open_in_new_tab'])) target="_blank" rel="noopener" @endif class="btn btn-primary mt-6 self-start">
                        {{ $config['button_text'] }}
                        @include('themes.starter.components.icon', ['name' => 'arrow-right', 'class' => 'size-4'])
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
