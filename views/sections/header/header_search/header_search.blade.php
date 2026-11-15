{{-- Kotak pencarian di header. Pengaturan: placeholder --}}
@php
    $searchPlaceholder = $config['placeholder'] ?? 'Cari informasi...';
@endphp
<form action="{{ route('public.search') }}" method="GET" role="search" class="relative hidden md:block">
    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
        @include('themes.starter.components.icon', ['name' => 'search', 'class' => 'size-4'])
    </span>
    <input type="search" name="q" value="{{ request('q') }}" placeholder="{{ $searchPlaceholder }}" aria-label="{{ $searchPlaceholder }}" class="form-input w-48 rounded-full py-1.5 pl-9 xl:w-64">
</form>
