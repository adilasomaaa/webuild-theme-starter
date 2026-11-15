@php
    // Menu dari aplikasi (model Menu) dinormalisasi menjadi array sederhana untuk header_menu dan menu mobile.
    $normalizeMenu = function ($menu) use (&$normalizeMenu): array {
        $url = is_object($menu) && method_exists($menu, 'getResolvedUrl') ? $menu->getResolvedUrl() : (data_get($menu, 'url') ?? '#');

        return [
            'label' => data_get($menu, 'label') ?? data_get($menu, 'title'),
            'url' => $url,
            'target' => data_get($menu, 'target') ?: '_self',
            'children' => collect(data_get($menu, 'children') ?? [])->map($normalizeMenu)->all(),
        ];
    };
    $navItems = collect($menus ?? [])->map($normalizeMenu)->all();
    if ($navItems === []) {
        $navItems = [
            ['label' => 'Beranda', 'url' => route('home'), 'target' => '_self', 'children' => []],
            ['label' => 'Berita', 'url' => route('public.news.index'), 'target' => '_self', 'children' => []],
            ['label' => 'Agenda', 'url' => route('public.agenda.index'), 'target' => '_self', 'children' => []],
            ['label' => 'Dokumen', 'url' => route('public.documents.index'), 'target' => '_self', 'children' => []],
            ['label' => 'Informasi', 'url' => '#', 'target' => '_self', 'children' => [
                ['label' => 'Galeri', 'url' => route('public.media.index'), 'target' => '_self', 'children' => []],
                ['label' => 'FAQ', 'url' => route('public.faqs.index'), 'target' => '_self', 'children' => []],
                ['label' => 'Buku Tamu', 'url' => route('public.guestbook.index'), 'target' => '_self', 'children' => []],
            ]],
        ];
    }

    $headerColumns = [
        'header_col_1' => 'flex min-w-0 items-center gap-3',
        'header_col_2' => 'hidden flex-1 items-center justify-center gap-3 lg:flex',
        'header_col_3' => 'flex items-center justify-end gap-2',
    ];
    $hasHeaderLayout = isset($layoutSections) && collect(array_keys($headerColumns))->contains(fn ($area) => $layoutSections->has($area));
@endphp

<header class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur">
    <div class="container-page flex h-16 items-center justify-between gap-4">
        @if($hasHeaderLayout)
            @foreach($headerColumns as $area => $columnClass)
                <div class="{{ $columnClass }}">
                    @foreach($layoutSections->get($area, collect()) as $headerSection)
                        @include('themes.starter.components.render-section', ['sectionItem' => $headerSection, 'area' => 'header', 'section' => $headerSection])
                    @endforeach
                </div>
            @endforeach
        @else
            <div class="flex min-w-0 items-center">
                @include('themes.starter.sections.header.header_logo.header_logo', ['config' => []])
            </div>
            <div class="hidden flex-1 justify-center lg:flex">
                @include('themes.starter.sections.header.header_menu.header_menu', ['config' => []])
            </div>
            <div class="flex items-center justify-end gap-2">
                @include('themes.starter.sections.header.header_search.header_search', ['config' => []])
            </div>
        @endif

        <button type="button" class="btn btn-ghost -mr-2 p-2 lg:hidden" data-toggle="menu-mobile" aria-controls="menu-mobile" aria-expanded="false" aria-label="Buka menu">
            @include('themes.starter.components.icon', ['name' => 'menu', 'class' => 'size-6'])
        </button>
    </div>

    {{-- Menu mobile --}}
    <nav id="menu-mobile" class="hidden border-t border-slate-200 bg-white lg:hidden" aria-label="Menu utama">
        <div class="container-page space-y-1 py-4">
            <form action="{{ route('public.search') }}" method="GET" class="mb-3">
                <input type="search" name="q" placeholder="Cari informasi..." class="form-input" aria-label="Cari">
            </form>
            @foreach($navItems as $navItem)
                @if($navItem['children'] !== [])
                    <details class="group">
                        <summary class="flex items-center justify-between rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                            {{ $navItem['label'] }}
                            @include('themes.starter.components.icon', ['name' => 'chevron-down', 'class' => 'size-4 transition group-open:rotate-180'])
                        </summary>
                        <div class="ml-3 border-l border-slate-200 pl-3">
                            @foreach($navItem['children'] as $child)
                                <a href="{{ $child['url'] }}" target="{{ $child['target'] }}" class="block rounded-lg px-3 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-primary">{{ $child['label'] }}</a>
                            @endforeach
                        </div>
                    </details>
                @else
                    <a href="{{ $navItem['url'] }}" target="{{ $navItem['target'] }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-primary">{{ $navItem['label'] }}</a>
                @endif
            @endforeach
        </div>
    </nav>
</header>
