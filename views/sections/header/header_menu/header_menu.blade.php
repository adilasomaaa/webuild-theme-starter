{{-- Navigasi utama desktop. $navItems disiapkan oleh layouts/header.blade.php dari $menus aplikasi. --}}
@php
    $menuItems = $navItems ?? [];
    $isActiveUrl = function (string $url): bool {
        $path = trim((string) parse_url($url, PHP_URL_PATH), '/');

        return $url !== '#' && request()->is($path === '' ? '/' : $path, $path === '' ? '/' : $path . '/*');
    };
@endphp
<nav class="hidden items-center gap-1 lg:flex" aria-label="Menu utama">
    @foreach($menuItems as $menuItem)
        @if($menuItem['children'] !== [])
            <details class="group relative" data-dropdown>
                <summary class="flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-primary">
                    {{ $menuItem['label'] }}
                    @include('themes.starter.components.icon', ['name' => 'chevron-down', 'class' => 'size-4 transition group-open:rotate-180'])
                </summary>
                <div class="absolute left-0 top-full z-50 mt-2 min-w-52 rounded-xl border border-slate-200 bg-white p-1.5 shadow-lg">
                    @foreach($menuItem['children'] as $child)
                        <a href="{{ $child['url'] }}" target="{{ $child['target'] }}" class="block rounded-lg px-3 py-2 text-sm {{ $isActiveUrl($child['url']) ? 'bg-primary/10 font-semibold text-primary' : 'text-slate-700 hover:bg-slate-50 hover:text-primary' }}">{{ $child['label'] }}</a>
                    @endforeach
                </div>
            </details>
        @else
            <a href="{{ $menuItem['url'] }}" target="{{ $menuItem['target'] }}" class="rounded-lg px-3 py-2 text-sm font-medium {{ $isActiveUrl($menuItem['url']) ? 'text-primary' : 'text-slate-700 hover:bg-slate-50 hover:text-primary' }}">{{ $menuItem['label'] }}</a>
        @endif
    @endforeach
</nav>
