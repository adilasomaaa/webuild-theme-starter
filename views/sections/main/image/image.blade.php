{{--
    Gambar tunggal.
    Pengaturan: title, image_url, alt, caption, link_url, open_in_new_tab, aspect_ratio (auto|16:9|4:3|1:1|21:9), alignment (left|center|right).
--}}
@php
    $imageSrc = $config['image_url'] ?? null;
    $imageAspect = match ($config['aspect_ratio'] ?? 'auto') {
        '16:9' => 'aspect-video object-cover',
        '4:3' => 'aspect-[4/3] object-cover',
        '1:1' => 'aspect-square object-cover',
        '21:9' => 'aspect-[21/9] object-cover',
        default => 'h-auto',
    };
    $imageAlign = match ($config['alignment'] ?? 'center') {
        'left' => 'mr-auto',
        'right' => 'ml-auto',
        default => 'mx-auto',
    };
@endphp
<section class="section" data-section-type="image">
    <div class="container-page">
        <figure class="{{ $imageAlign }} max-w-5xl">
            @if(filled($config['title'] ?? null))
                <h2 class="mb-4 text-xl font-bold text-slate-900">{{ $config['title'] }}</h2>
            @endif
            @if($imageSrc)
                @if(! empty($config['link_url']))
                    <a href="{{ $config['link_url'] }}" @if(! empty($config['open_in_new_tab'])) target="_blank" rel="noopener" @endif>
                @endif
                <img src="{{ $imageSrc }}" alt="{{ $config['alt'] ?? ($config['caption'] ?? '') }}" class="w-full rounded-2xl {{ $imageAspect }}" loading="lazy">
                @if(! empty($config['link_url']))
                    </a>
                @endif
            @else
                <div class="flex aspect-video items-center justify-center rounded-2xl bg-slate-100 text-slate-300">
                    @include('themes.starter.components.icon', ['name' => 'image', 'class' => 'size-12'])
                </div>
            @endif
            @if(filled($config['caption'] ?? null))
                <figcaption class="mt-3 text-center text-sm text-slate-500">{{ $config['caption'] }}</figcaption>
            @endif
        </figure>
    </div>
</section>
