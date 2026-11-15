{{-- Kartu aplikasi terdaftar. Parameter: $appItem (name, description, logo_url, url, activeHostname) --}}
@php
    $appHost = data_get($appItem, 'activeHostname.hostname');
    $appUrl = $appHost ? ((data_get($appItem, 'activeHostname.is_ssl') ? 'https://' : 'http://') . $appHost) : data_get($appItem, 'url');
    $appLogo = data_get($appItem, 'logo_url') ?? data_get($appItem, 'organizationProfile.logo_url');
@endphp
<a href="{{ $appUrl ?: '#' }}" @if($appUrl) target="_blank" rel="noopener" @endif class="card card-hover group flex flex-col p-5">
    <span class="mb-4 flex size-12 items-center justify-center overflow-hidden rounded-xl bg-primary/10 text-primary">
        @if($appLogo)
            <img src="{{ $appLogo }}" alt="" class="size-full object-contain p-1.5" loading="lazy">
        @else
            @include('themes.starter.components.icon', ['name' => 'apps', 'class' => 'size-6'])
        @endif
    </span>
    <h3 class="font-semibold text-slate-900 group-hover:text-primary">{{ data_get($appItem, 'name') }}</h3>
    @if(data_get($appItem, 'description'))
        <p class="mt-1 line-clamp-2 text-sm text-slate-600">{{ data_get($appItem, 'description') }}</p>
    @endif
    @if($appHost)
        <p class="mt-auto truncate pt-3 text-xs text-slate-400">{{ $appHost }}</p>
    @endif
</a>
