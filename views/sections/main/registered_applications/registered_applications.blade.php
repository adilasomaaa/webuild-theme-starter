{{--
    Aplikasi/portal yang terdaftar di Webuild dari $registeredApplications (name, description, logo_url, activeHostname).
    Pengaturan: title, subtitle, limit, button_text, button_url.
--}}
@php
    $registeredItems = collect(($registeredApplications ?? null) instanceof \Illuminate\Contracts\Pagination\Paginator ? $registeredApplications->items() : ($registeredApplications ?? []))->take((int) ($config['limit'] ?? 8))->values();
@endphp
<section class="section" data-section-type="registered_applications">
    <div class="container-page">
        @include('themes.starter.components.section-heading', [
            'title' => $config['title'] ?? 'Aplikasi & Portal Terkait',
            'subtitle' => $config['subtitle'] ?? 'Layanan digital lain di lingkungan pemerintah daerah.',
            'headingActionText' => $config['button_text'] ?? 'Semua aplikasi',
            'headingActionUrl' => $config['button_url'] ?? route('public.applications.index'),
        ])
        @if($registeredItems->isEmpty())
            @include('themes.starter.components.empty-state', ['emptyMessage' => 'Belum ada aplikasi terdaftar.', 'emptyIcon' => 'apps'])
        @else
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($registeredItems as $registeredItem)
                    @include('themes.starter.components.app-card', ['appItem' => $registeredItem])
                @endforeach
            </div>
        @endif
    </div>
</section>
