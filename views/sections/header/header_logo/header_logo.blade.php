{{-- Logo instansi. Varian (config.mode): logo_name | logo_only | name_only --}}
@php
    $logoMode = $config['mode'] ?? data_get($profile ?? null, 'header_logo_mode') ?? 'logo_name';
    $logoUrl = data_get($profile ?? null, 'logo_url');
    $logoName = data_get($profile ?? null, 'website_name') ?? data_get($application ?? null, 'name') ?? config('app.name', 'Webuild');
    $logoInitials = collect(preg_split('/\s+/', trim($logoName)))->filter()->take(2)->map(fn ($word) => mb_substr($word, 0, 1))->implode('');
@endphp
<a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3" aria-label="{{ $logoName }}">
    @if($logoMode !== 'name_only')
        @if($logoUrl)
            <img src="{{ $logoUrl }}" alt="Logo {{ $logoName }}" class="size-10 shrink-0 object-contain">
        @else
            <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-primary text-sm font-bold text-white">{{ mb_strtoupper($logoInitials) }}</span>
        @endif
    @endif
    @if($logoMode !== 'logo_only')
        <span class="truncate text-base font-bold text-slate-900 sm:text-lg">{{ $logoName }}</span>
    @endif
</a>
