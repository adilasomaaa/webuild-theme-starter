{{--
    Alur reservasi kunjungan.
    Pengaturan: title, subtitle, button_text, button_url, layout_orientation (horizontal|vertical).
--}}
@php
    $bookingSteps = [
        ['icon' => 'calendar', 'title' => 'Pilih jadwal', 'text' => 'Tentukan layanan, tanggal, dan sesi kunjungan yang tersedia.'],
        ['icon' => 'user', 'title' => 'Isi data diri', 'text' => 'Lengkapi nama, nomor telepon, dan jumlah pengunjung.'],
        ['icon' => 'ticket', 'title' => 'Simpan kode booking', 'text' => 'Gunakan kode booking untuk melacak status dan saat datang.'],
    ];
    $bookingHorizontal = ($config['layout_orientation'] ?? 'horizontal') === 'horizontal';
@endphp
<section class="section section-muted" data-section-type="booking_methods">
    <div class="container-page">
        @include('themes.starter.components.section-heading', [
            'title' => $config['title'] ?? 'Reservasi Kunjungan',
            'subtitle' => $config['subtitle'] ?? 'Atur jadwal kunjungan Anda secara daring dalam tiga langkah.',
            'headingAlign' => 'center',
        ])
        <ol class="grid gap-5 {{ $bookingHorizontal ? 'md:grid-cols-3' : 'mx-auto max-w-2xl' }}">
            @foreach($bookingSteps as $step)
                <li class="card flex gap-4 p-6 {{ $bookingHorizontal ? 'flex-col' : 'items-start' }}">
                    <span class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-primary text-white">
                        @include('themes.starter.components.icon', ['name' => $step['icon'], 'class' => 'size-6'])
                    </span>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-primary">Langkah {{ $loop->iteration }}</p>
                        <h3 class="mt-1 font-semibold text-slate-900">{{ $step['title'] }}</h3>
                        <p class="mt-1 text-sm text-slate-600">{{ $step['text'] }}</p>
                    </div>
                </li>
            @endforeach
        </ol>
        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <a href="{{ $config['button_url'] ?? route('public.booking.index') }}" class="btn btn-primary">{{ $config['button_text'] ?? 'Buat Reservasi' }}</a>
            <a href="{{ route('public.booking.track') }}" class="btn btn-outline">Lacak Booking</a>
        </div>
    </div>
</section>
