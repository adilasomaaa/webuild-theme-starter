{{--
    Formulir lacak status booking.
    Pengaturan: title, subtitle, placeholder, button_text, layout_orientation (horizontal|vertical).
--}}
<section class="section" data-section-type="booking_tracking">
    <div class="container-page">
        <div class="card mx-auto flex max-w-3xl flex-col gap-6 p-8 {{ ($config['layout_orientation'] ?? 'horizontal') === 'horizontal' ? 'md:flex-row md:items-center' : '' }}">
            <div class="flex-1">
                <h2 class="text-xl font-bold text-slate-900">{{ $config['title'] ?? 'Lacak Status Booking' }}</h2>
                <p class="mt-1 text-sm text-slate-600">{{ $config['subtitle'] ?? 'Masukkan kode booking untuk melihat status reservasi Anda.' }}</p>
            </div>
            <form action="{{ route('public.booking.track') }}" method="GET" class="flex flex-1 gap-2">
                <input type="text" name="code" required placeholder="{{ $config['placeholder'] ?? 'Contoh: BK-2026-0001' }}" class="form-input uppercase" aria-label="Kode booking">
                <button type="submit" class="btn btn-primary shrink-0">{{ $config['button_text'] ?? 'Lacak' }}</button>
            </form>
        </div>
    </div>
</section>
