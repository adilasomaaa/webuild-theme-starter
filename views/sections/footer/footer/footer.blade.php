{{--
    Identitas instansi di footer: logo, nama, alamat, kontak, dan media sosial.
    Pengaturan: copyright_text, privacy_url, terms_url, contact_url (baris hak cipta dirender di layouts/footer).
--}}
@php
    $footerName = data_get($profile ?? null, 'website_name') ?? data_get($application ?? null, 'name') ?? config('app.name', 'Webuild');
    $footerLogo = data_get($profile ?? null, 'logo_url');
    $footerAddress = data_get($address ?? null, 'full_address') ?: (collect([
        data_get($address ?? null, 'street'),
        data_get($address ?? null, 'regency'),
        data_get($address ?? null, 'province'),
    ])->filter()->implode(', ') ?: data_get($profile ?? null, 'address'));
    $footerContactUrl = $config['contact_url'] ?? null;
@endphp
<div class="space-y-5">
    <a href="{{ route('home') }}" class="flex items-center gap-3">
        @if($footerLogo)
            <img src="{{ $footerLogo }}" alt="Logo {{ $footerName }}" class="size-11 rounded-lg bg-white p-1 object-contain">
        @endif
        <span class="text-lg font-bold text-white">{{ $footerName }}</span>
    </a>
    @if(data_get($profile ?? null, 'description'))
        <p class="max-w-md leading-relaxed">{{ \Illuminate\Support\Str::limit(strip_tags(data_get($profile, 'description')), 180) }}</p>
    @endif
    <ul class="space-y-2.5">
        @if($footerAddress)
            <li class="flex gap-2.5">@include('themes.starter.components.icon', ['name' => 'map-pin', 'class' => 'mt-0.5 size-4 text-primary']) <span>{{ $footerAddress }}</span></li>
        @endif
        @if(data_get($profile ?? null, 'phone'))
            <li class="flex gap-2.5">@include('themes.starter.components.icon', ['name' => 'phone', 'class' => 'mt-0.5 size-4 text-primary']) <a href="tel:{{ preg_replace('/[^0-9+]/', '', data_get($profile, 'phone')) }}" class="hover:text-white">{{ data_get($profile, 'phone') }}</a></li>
        @endif
        @if(data_get($profile ?? null, 'email'))
            <li class="flex gap-2.5">@include('themes.starter.components.icon', ['name' => 'mail', 'class' => 'mt-0.5 size-4 text-primary']) <a href="mailto:{{ data_get($profile, 'email') }}" class="hover:text-white">{{ data_get($profile, 'email') }}</a></li>
        @endif
    </ul>
    @include('themes.starter.components.social-links', ['socialExtra' => [], 'socialDark' => true])
    @if($footerContactUrl)
        <a href="{{ $footerContactUrl }}" class="btn btn-primary btn-sm">Hubungi Kami</a>
    @endif
</div>
