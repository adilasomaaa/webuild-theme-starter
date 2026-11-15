{{--
    Slider/banner gambar dari data $sliders (title, description, image_url, button_text, button_url).
    Varian (config.aspect_ratio): 21:9 | 16:10 | 4:3 | 16:9. Pengaturan mengikuti SliderSectionForm webuild-app:
    title, subtitle, text_align (left|center|right), text_valign (bottom|center|top), text_size (small|normal|large),
    full_section, autoplay, interval (ms), overlay_opacity (0-90).
--}}
@php
    $slides = collect($sliders ?? [])->filter(fn ($slide) => data_get($slide, 'is_active', true))->sortBy(fn ($slide) => data_get($slide, 'sort_order', 0))->values();
    $sliderAspect = match ($config['aspect_ratio'] ?? $variant ?? '21:9') {
        '16:10' => 'aspect-[16/10]',
        '4:3' => 'aspect-[4/3]',
        '16:9' => 'aspect-video',
        default => 'aspect-[16/9] md:aspect-[21/9]',
    };
    $sliderInterval = filter_var($config['autoplay'] ?? true, FILTER_VALIDATE_BOOL) ? (int) ($config['interval'] ?? 5000) : 0;
    $sliderFull = filter_var($config['full_section'] ?? false, FILTER_VALIDATE_BOOL);
    $sliderOverlay = max(0, min(90, (int) ($config['overlay_opacity'] ?? 60))) / 100;
    $sliderAlign = match ($config['text_align'] ?? 'left') {
        'center' => 'mx-auto text-center',
        'right' => 'ml-auto text-right',
        default => '',
    };
    $sliderValign = match ($config['text_valign'] ?? 'bottom') {
        'top' => 'justify-start',
        'center' => 'justify-center',
        default => 'justify-end',
    };
    $sliderTitleSize = match ($config['text_size'] ?? 'normal') {
        'small' => 'text-xl sm:text-2xl',
        'large', 'extra_large' => 'text-3xl sm:text-5xl',
        default => 'text-2xl sm:text-4xl',
    };
@endphp
<section class="section pt-6 sm:pt-8" data-section-type="slider">
    @if(! empty($config['title']))
        <div class="container-page mb-4 flex flex-wrap items-baseline gap-x-3 gap-y-1">
            <h2 class="text-lg font-bold text-slate-900">{{ $config['title'] }}</h2>
            @if(! empty($config['subtitle']))
                <p class="text-sm text-slate-500">{{ $config['subtitle'] }}</p>
            @endif
        </div>
    @endif
    <div class="{{ $sliderFull ? '' : 'container-page' }}">
        @if($slides->isEmpty())
            @include('themes.starter.components.empty-state', ['emptyMessage' => 'Belum ada slider yang aktif.', 'emptyIcon' => 'image'])
        @else
            <div class="relative overflow-hidden bg-slate-900 {{ $sliderFull ? '' : 'rounded-2xl' }} {{ $sliderAspect }}" data-slider data-interval="{{ $sliderInterval }}" aria-roledescription="carousel">
                @foreach($slides as $slide)
                    @php($slideImage = data_get($slide, 'image_url') ?? data_get($slide, 'image'))
                    <div class="absolute inset-0 transition-opacity duration-700 {{ $loop->first ? '' : 'pointer-events-none opacity-0' }}" data-slide aria-roledescription="slide" aria-label="{{ $loop->iteration }} dari {{ $loop->count }}">
                        @if($slideImage)
                            <img src="{{ $slideImage }}" alt="{{ data_get($slide, 'title') }}" class="size-full object-cover" @unless($loop->first) loading="lazy" @endunless>
                        @endif
                        <div class="absolute inset-0 bg-slate-900" style="opacity: {{ $sliderOverlay }}"></div>
                        <div class="absolute inset-0 flex flex-col p-6 sm:p-10 {{ $sliderValign }}">
                            <div class="max-w-2xl {{ $sliderAlign }}">
                                @if(data_get($slide, 'title'))
                                    <h2 class="{{ $sliderTitleSize }} font-bold text-white">{{ data_get($slide, 'title') }}</h2>
                                @endif
                                @if(data_get($slide, 'description'))
                                    <p class="mt-2 line-clamp-2 text-sm text-white/85 sm:text-base">{{ data_get($slide, 'description') }}</p>
                                @endif
                                @if(data_get($slide, 'button_text') && data_get($slide, 'button_url'))
                                    <a href="{{ data_get($slide, 'button_url') }}" class="btn btn-light mt-5">{{ data_get($slide, 'button_text') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                @if($slides->count() > 1)
                    <button type="button" data-slider-prev class="absolute left-3 top-1/2 hidden size-10 sm:flex -translate-y-1/2 items-center justify-center rounded-full bg-white/20 text-white backdrop-blur hover:bg-white/40" aria-label="Slide sebelumnya">
                        @include('themes.starter.components.icon', ['name' => 'chevron-left', 'class' => 'size-5'])
                    </button>
                    <button type="button" data-slider-next class="absolute right-3 top-1/2 hidden size-10 sm:flex -translate-y-1/2 items-center justify-center rounded-full bg-white/20 text-white backdrop-blur hover:bg-white/40" aria-label="Slide berikutnya">
                        @include('themes.starter.components.icon', ['name' => 'chevron-right', 'class' => 'size-5'])
                    </button>
                    <div class="absolute bottom-4 right-6 flex gap-1.5">
                        @foreach($slides as $slide)
                            <button type="button" data-slider-dot class="h-1.5 w-6 rounded-full bg-white/40 aria-[current=true]:bg-white" aria-label="Ke slide {{ $loop->iteration }}"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>
</section>
