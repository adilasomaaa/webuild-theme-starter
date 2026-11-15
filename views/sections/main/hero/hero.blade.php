{{--
    Hero beranda. Pengaturan mengikuti HeroSectionForm webuild-app:
    highlight_text, title, subtitle, text_align (left|center|right), text_size (small|normal|large),
    section_height (auto|tall|fullscreen), background_type (solid|gradient|image), background_color,
    background_gradient (ocean|sunset|forest|violet|slate), bg_image_url, overlay_opacity (0-100), hover_effect (none|blur),
    show_search_bar, search_placeholder, show_buttons, primary_button_text/url, secondary_button_text/url.
--}}
@php
    $heroTitle = $config['title'] ?? 'Selamat Datang di Portal Resmi';
    $heroSubtitle = $config['subtitle'] ?? 'Akses informasi publik, layanan, dan berita terbaru dari instansi kami.';
    $heroHighlight = $config['highlight_text'] ?? null;
    $heroImage = $config['bg_image_url'] ?? null;
    // 'color' dan 'medium'/'large' adalah nilai lama starter; tetap didukung.
    $heroType = match ($config['background_type'] ?? ($heroImage ? 'image' : 'gradient')) {
        'color' => 'solid',
        default => $config['background_type'] ?? ($heroImage ? 'image' : 'gradient'),
    };
    if ($heroType === 'image' && ! $heroImage) {
        $heroType = 'gradient';
    }
    // theme-check:color-preset — terjemahan preset background_gradient yang dipilih admin, bukan warna identitas tema.
    $heroGradients = [
        'ocean' => 'linear-gradient(135deg, #0f766e 0%, #1e3a8a 100%)',
        'sunset' => 'linear-gradient(135deg, #f97316 0%, #db2777 100%)',
        'forest' => 'linear-gradient(135deg, #166534 0%, #0f766e 100%)',
        'violet' => 'linear-gradient(135deg, #6d28d9 0%, #c026d3 100%)',
        'slate' => 'linear-gradient(135deg, #334155 0%, #020617 100%)',
    ];
    $heroBgColor = $config['background_color'] ?? '#ffffff';
    // Latar solid terang memakai teks gelap; gradien dan gambar memakai teks terang.
    $heroHex = ltrim($heroBgColor, '#');
    $heroLuminance = strlen($heroHex) === 6
        ? (0.299 * hexdec(substr($heroHex, 0, 2)) + 0.587 * hexdec(substr($heroHex, 2, 2)) + 0.114 * hexdec(substr($heroHex, 4, 2))) / 255
        : 1;
    $heroDark = $heroType !== 'solid' || $heroLuminance < 0.6;
    $heroBackground = match ($heroType) {
        'solid' => "background-color: {$heroBgColor}",
        'gradient' => isset($heroGradients[$config['background_gradient'] ?? null]) ? 'background-image: ' . $heroGradients[$config['background_gradient']] : null,
        default => null,
    };

    $heroAlign = $config['text_align'] ?? 'left';
    $heroAlignClass = match ($heroAlign) {
        'center' => 'mx-auto text-center',
        'right' => 'ml-auto text-right',
        default => '',
    };
    $heroJustify = match ($heroAlign) {
        'center' => 'justify-center',
        'right' => 'justify-end',
        default => '',
    };
    $heroTitleSize = match ($config['text_size'] ?? 'normal') {
        'small' => 'text-3xl sm:text-4xl',
        'large', 'extra_large' => 'text-5xl sm:text-6xl',
        default => 'text-4xl sm:text-5xl',
    };
    $heroHeight = match ($config['section_height'] ?? 'auto') {
        'tall', 'large' => 'min-h-[560px] lg:min-h-[680px]',
        'fullscreen' => 'min-h-[calc(100vh-4rem)]',
        'medium' => 'min-h-[420px] lg:min-h-[500px]',
        default => '',
    };
    $heroOverlay = max(0, min(100, (int) ($config['overlay_opacity'] ?? 40))) / 100;
    $heroBlur = ($config['hover_effect'] ?? 'none') === 'blur';
    $heroShowButtons = filter_var($config['show_buttons'] ?? true, FILTER_VALIDATE_BOOL);
    $heroShowSearch = filter_var($config['show_search_bar'] ?? false, FILTER_VALIDATE_BOOL);
@endphp
<section data-section-type="hero"
    class="group relative isolate flex items-center overflow-hidden {{ $heroHeight }} {{ $heroType === 'gradient' && ! $heroBackground ? 'bg-linear-to-br from-primary to-secondary' : '' }}"
    @if($heroBackground) style="{{ $heroBackground }}" @endif>
    @if($heroType === 'image')
        <img src="{{ $heroImage }}" alt="" class="absolute inset-0 -z-10 size-full object-cover transition duration-300 {{ $heroBlur ? 'group-hover:blur-sm' : '' }}">
        <div class="absolute inset-0 -z-10 bg-slate-900" style="opacity: {{ $heroOverlay }}"></div>
    @endif

    <div class="container-page w-full py-16 sm:py-24">
        <div class="max-w-3xl {{ $heroAlignClass }}">
            @if($heroHighlight)
                <span class="mb-4 inline-flex rounded-full px-3 py-1 text-xs font-semibold tracking-wide ring-1 {{ $heroDark ? 'bg-white/15 text-white ring-white/30' : 'bg-primary/10 text-primary ring-primary/20' }}">{{ $heroHighlight }}</span>
            @endif
            <h1 class="{{ $heroTitleSize }} font-bold tracking-tight {{ $heroDark ? 'text-white' : 'text-slate-900' }}">{{ $heroTitle }}</h1>
            @if($heroSubtitle)
                <p class="mt-5 text-lg leading-relaxed {{ $heroDark ? 'text-white/85' : 'text-slate-600' }}">{{ $heroSubtitle }}</p>
            @endif

            @if($heroShowSearch)
                <form action="{{ route('public.search') }}" method="GET" role="search" class="mt-8 flex max-w-xl gap-2 {{ $heroAlign === 'center' ? 'mx-auto' : ($heroAlign === 'right' ? 'ml-auto' : '') }}">
                    <input type="search" name="q" placeholder="{{ $config['search_placeholder'] ?? 'Cari layanan atau informasi...' }}" class="form-input flex-1 py-3 {{ $heroDark ? 'border-0' : '' }}" aria-label="Cari">
                    <button type="submit" class="btn {{ $heroDark ? 'btn-light' : 'btn-primary' }}">@include('themes.starter.components.icon', ['name' => 'search', 'class' => 'size-4']) Cari</button>
                </form>
            @endif

            @if($heroShowButtons)
                <div class="mt-8 flex flex-wrap gap-3 {{ $heroJustify }}">
                    @if(! empty($config['primary_button_text']) || ! array_key_exists('primary_button_text', $config))
                        <a href="{{ $config['primary_button_url'] ?? route('public.news.index') }}" class="btn btn-lg {{ $heroDark ? 'btn-light' : 'btn-primary' }}">
                            {{ $config['primary_button_text'] ?? 'Jelajahi Informasi' }}
                            @include('themes.starter.components.icon', ['name' => 'arrow-right', 'class' => 'size-4'])
                        </a>
                    @endif
                    @if(! empty($config['secondary_button_text']) || ! array_key_exists('secondary_button_text', $config))
                        <a href="{{ $config['secondary_button_url'] ?? route('public.guestbook.index') }}" class="btn btn-lg {{ $heroDark ? 'border border-white/40 text-white hover:bg-white/10' : 'btn-outline' }}">
                            {{ $config['secondary_button_text'] ?? 'Hubungi Kami' }}
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</section>
