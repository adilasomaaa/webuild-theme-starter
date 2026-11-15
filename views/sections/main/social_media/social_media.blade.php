{{--
    Media sosial resmi instansi dari $profile (instagram_url, facebook_url, twitter_url, youtube_url, website_url).
    Pengaturan: title, subtitle, include_organization_profile, links (array of ['platform','label','url']).
--}}
@php
    $socialIncludeProfile = (bool) ($config['include_organization_profile'] ?? true);
@endphp
@if($inFooter ?? false)
    <div>
        <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-white">{{ $config['title'] ?? 'Ikuti Kami' }}</h2>
        @include('themes.starter.components.social-links', ['profile' => $socialIncludeProfile ? ($profile ?? null) : null, 'socialExtra' => $config['links'] ?? [], 'socialDark' => true])
    </div>
@else
    <section class="section section-muted" data-section-type="social_media">
        <div class="container-page text-center">
            @include('themes.starter.components.section-heading', [
                'title' => $config['title'] ?? 'Ikuti Media Sosial Kami',
                'subtitle' => $config['subtitle'] ?? 'Dapatkan kabar terbaru melalui kanal resmi instansi.',
                'headingAlign' => 'center',
            ])
            <div class="flex justify-center [&_a]:size-12">
                @include('themes.starter.components.social-links', ['profile' => $socialIncludeProfile ? ($profile ?? null) : null, 'socialExtra' => $config['links'] ?? [], 'socialDark' => false])
            </div>
        </div>
    </section>
@endif
