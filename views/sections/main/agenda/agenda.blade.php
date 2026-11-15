{{--
    Agenda kegiatan dari $todayAgendas (disiapkan aplikasi sesuai rentang waktu) atau $agendas.
    Varian (config.timeframe): today | this_week | this_month.
    Pengaturan: title, subtitle, badge, limit, button_text, button_url.
--}}
@php
    $agendaTimeframe = $config['timeframe'] ?? $variant ?? 'today';
    $agendaLabel = ['today' => 'Hari Ini', 'this_week' => 'Minggu Ini', 'this_month' => 'Bulan Ini'][$agendaTimeframe] ?? 'Terdekat';
    $agendaSource = $todayAgendas ?? $agendas ?? [];
    $agendaItems = collect($agendaSource instanceof \Illuminate\Contracts\Pagination\Paginator ? $agendaSource->items() : $agendaSource)
        ->take((int) ($config['limit'] ?? 4))
        ->values();
@endphp
<section class="section" data-section-type="agenda" id="agenda">
    <div class="container-page">
        @include('themes.starter.components.section-heading', [
            'title' => $config['title'] ?? 'Agenda Kegiatan',
            'subtitle' => $config['subtitle'] ?? 'Jadwal kegiatan dan acara resmi instansi.',
            'headingBadge' => $config['badge'] ?? $agendaLabel,
            'headingActionText' => $config['button_text'] ?? 'Semua agenda',
            'headingActionUrl' => $config['button_url'] ?? route('public.agenda.index'),
        ])
        @if($agendaItems->isEmpty())
            @include('themes.starter.components.empty-state', ['emptyMessage' => "Tidak ada agenda {$agendaLabel}.", 'emptyIcon' => 'calendar'])
        @else
            <div class="grid gap-4 md:grid-cols-2">
                @foreach($agendaItems as $agendaItem)
                    @include('themes.starter.components.agenda-item', ['agenda' => $agendaItem])
                @endforeach
            </div>
        @endif
    </div>
</section>
