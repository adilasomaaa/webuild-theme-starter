{{--
    Daftar tautan cepat di footer.
    Pengaturan: title, links (array of ['label', 'url', 'target']). Jika kosong memakai menu utama aplikasi.
--}}
@php
    $quickTitle = $config['title'] ?? 'Tautan Cepat';
    $quickLinks = collect($config['links'] ?? [])->filter(fn ($link) => filled(data_get($link, 'label')));
    if ($quickLinks->isEmpty()) {
        $quickLinks = collect($menus ?? [])->take(6)->map(fn ($menu) => [
            'label' => data_get($menu, 'label'),
            'url' => is_object($menu) && method_exists($menu, 'getResolvedUrl') ? $menu->getResolvedUrl() : data_get($menu, 'url', '#'),
        ]);
    }
    if ($quickLinks->isEmpty()) {
        $quickLinks = collect([
            ['label' => 'Berita', 'url' => route('public.news.index')],
            ['label' => 'Agenda', 'url' => route('public.agenda.index')],
            ['label' => 'Dokumen Publik', 'url' => route('public.documents.index')],
            ['label' => 'Galeri', 'url' => route('public.media.index')],
            ['label' => 'FAQ', 'url' => route('public.faqs.index')],
        ]);
    }
@endphp
<div>
    @if(filled($quickTitle))
        <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider {{ ($inFooter ?? false) ? 'text-white' : 'text-slate-900' }}">{{ $quickTitle }}</h2>
    @endif
    <ul class="space-y-2.5">
        @foreach($quickLinks as $quickLink)
            <li>
                <a href="{{ data_get($quickLink, 'url', '#') }}" target="{{ data_get($quickLink, 'target', '_self') }}" class="inline-flex items-center gap-1.5 transition {{ ($inFooter ?? false) ? 'hover:text-white' : 'text-slate-600 hover:text-primary' }}">
                    @include('themes.starter.components.icon', ['name' => 'chevron-right', 'class' => 'size-3.5'])
                    {{ data_get($quickLink, 'label') }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
