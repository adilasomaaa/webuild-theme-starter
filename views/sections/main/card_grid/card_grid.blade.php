{{--
    Grid kartu layanan/fitur.
    Pengaturan: title, subtitle, columns (2-6), cards (array of ['label'|'title', 'description', 'icon', 'link_url'|'url', 'action_label', 'open_in_new_tab']).
--}}
@php
    $gridCards = collect($config['cards'] ?? []);
    if ($gridCards->isEmpty()) {
        $gridCards = collect([
            ['label' => 'Layanan Informasi', 'description' => 'Ajukan permohonan informasi publik secara daring.', 'icon' => 'info', 'url' => route('public.faqs.index')],
            ['label' => 'Dokumen Publik', 'description' => 'Unduh regulasi, laporan, dan dokumen resmi.', 'icon' => 'file', 'url' => route('public.documents.index')],
            ['label' => 'Agenda Kegiatan', 'description' => 'Pantau jadwal kegiatan dan acara instansi.', 'icon' => 'calendar', 'url' => route('public.agenda.index')],
            ['label' => 'Buku Tamu', 'description' => 'Catat kunjungan Anda ke kantor kami.', 'icon' => 'users', 'url' => route('public.guestbook.index')],
        ]);
    }
    $gridColumns = match ((string) ($config['columns'] ?? 'auto')) {
        '2' => 'sm:grid-cols-2',
        '3' => 'sm:grid-cols-2 lg:grid-cols-3',
        '5' => 'sm:grid-cols-2 lg:grid-cols-5',
        '6' => 'sm:grid-cols-3 lg:grid-cols-6',
        default => 'sm:grid-cols-2 lg:grid-cols-4',
    };
@endphp
<section class="section section-muted" data-section-type="card_grid" id="layanan">
    <div class="container-page">
        @include('themes.starter.components.section-heading', [
            'title' => $config['title'] ?? 'Layanan Kami',
            'subtitle' => $config['subtitle'] ?? 'Akses cepat ke layanan publik yang tersedia.',
            'headingAlign' => 'center',
        ])
        <div class="grid gap-5 {{ $gridColumns }}">
            @foreach($gridCards as $gridCard)
                @php
                    $gridCardUrl = data_get($gridCard, 'link_url') ?: data_get($gridCard, 'url');
                    $gridCardTag = $gridCardUrl ? 'a' : 'div';
                @endphp
                <{{ $gridCardTag }} @if($gridCardUrl) href="{{ $gridCardUrl }}" @if(data_get($gridCard, 'open_in_new_tab')) target="_blank" rel="noopener" @endif @endif class="card card-hover group flex flex-col p-6">
                    <span class="mb-4 flex size-12 items-center justify-center rounded-xl bg-primary/10 text-primary transition group-hover:bg-primary group-hover:text-white">
                        @include('themes.starter.components.icon', ['name' => data_get($gridCard, 'icon') ?: 'grid', 'class' => 'size-6'])
                    </span>
                    <h3 class="font-semibold text-slate-900">{{ data_get($gridCard, 'label') ?? data_get($gridCard, 'title') }}</h3>
                    @if(data_get($gridCard, 'description'))
                        <p class="mt-2 text-sm text-slate-600">{{ data_get($gridCard, 'description') }}</p>
                    @endif
                    @if($gridCardUrl)
                        <span class="mt-auto inline-flex items-center gap-1 pt-4 text-sm font-medium text-primary">
                            {{ data_get($gridCard, 'action_label') ?: 'Selengkapnya' }}
                            @include('themes.starter.components.icon', ['name' => 'arrow-right', 'class' => 'size-4 transition group-hover:translate-x-0.5'])
                        </span>
                    @endif
                </{{ $gridCardTag }}>
            @endforeach
        </div>
    </div>
</section>
