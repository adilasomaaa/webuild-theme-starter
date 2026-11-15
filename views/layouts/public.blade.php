@php
    $profile = $profile ?? data_get($application ?? null, 'organizationProfile');
    $themeTokens = (array) ($themeConfig ?? data_get($application ?? null, 'activeTheme.configuration', []));
    $primaryColor = $themeTokens['primary_color'] ?? '#2563eb';
    $secondaryColor = $themeTokens['secondary_color'] ?? '#1e40af';
    $accentColor = $themeTokens['accent_color'] ?? '#0ea5e9';
    $siteDisplayName = data_get($profile, 'website_name') ?? data_get($application ?? null, 'name') ?? config('app.name', 'Webuild');
    $seoTitle = $seo['title'] ?? $siteDisplayName;
    $seoDescription = $seo['description'] ?? 'Portal resmi layanan informasi publik.';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    @if(! empty($seo['keywords']))
        <meta name="keywords" content="{{ $seo['keywords'] }}">
    @endif
    <link rel="canonical" href="{{ $seo['url'] ?? url()->current() }}">

    <meta property="og:site_name" content="{{ $siteDisplayName }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:type" content="{{ $seo['type'] ?? 'website' }}">
    <meta property="og:url" content="{{ $seo['url'] ?? url()->current() }}">
    <meta name="twitter:card" content="{{ ! empty($seo['image']) ? 'summary_large_image' : 'summary' }}">
    @if(! empty($seo['image']))
        <meta property="og:image" content="{{ $seo['image'] }}">
        <meta name="twitter:image" content="{{ $seo['image'] }}">
    @endif
    @if(! empty($seo['schema']))
        <script type="application/ld+json">{!! json_encode($seo['schema'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @endif

    @if(data_get($profile, 'favicon_url'))
        <link rel="icon" href="{{ data_get($profile, 'favicon_url') }}">
    @else
        <link rel="icon" href="/favicon.ico" sizes="any">
    @endif

    {{-- CSS & JS hasil build (dist/) didaftarkan di theme.json → assets --}}
    @themeAssets('starter')

    {{-- Warna dari pengaturan tema menjadi token Tailwind: bg-primary, text-secondary, dll. --}}
    <style>
        :root {
            --theme-primary: {{ $primaryColor }};
            --theme-secondary: {{ $secondaryColor }};
            --theme-accent: {{ $accentColor }};
        }
    </style>

    @if(! empty($headScript ?? null))
        {!! $headScript !!}
    @elseif(! empty($rybbitSiteId ?? null) && ! empty($rybbitInstanceUrl ?? null))
        <script defer src="{{ rtrim($rybbitInstanceUrl, '/') }}/api/script.js" data-site-id="{{ $rybbitSiteId }}"></script>
    @endif
    @stack('head')
</head>
<body class="flex min-h-screen flex-col bg-white font-sans text-slate-800 antialiased">
    <a href="#konten-utama" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:shadow">Lewati ke konten utama</a>

    @include('themes.starter.layouts.header')

    <main id="konten-utama" class="flex-1">
        @yield('content')
    </main>

    @include('themes.starter.layouts.footer')

    @stack('scripts')
</body>
</html>
