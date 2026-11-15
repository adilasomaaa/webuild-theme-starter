{{--
    Ajakan mengisi buku tamu digital.
    Pengaturan: title, subtitle, button_text, button_url, show_qr (tampilkan kode QR menuju formulir).
--}}
@php
    $guestbookUrl = $config['button_url'] ?? route('public.guestbook.index');
    $guestbookAbsoluteUrl = str_starts_with($guestbookUrl, 'http') ? $guestbookUrl : url($guestbookUrl);
@endphp
<section class="section" data-section-type="guestbook_widget">
    <div class="container-page">
        <div class="flex flex-col items-center gap-8 rounded-3xl bg-linear-to-br from-primary to-secondary p-8 text-white sm:p-12 md:flex-row">
            <div class="flex-1">
                <span class="mb-4 inline-flex size-12 items-center justify-center rounded-xl bg-white/15">
                    @include('themes.starter.components.icon', ['name' => 'users', 'class' => 'size-6'])
                </span>
                <h2 class="text-2xl font-bold sm:text-3xl">{{ $config['title'] ?? 'Buku Tamu Digital' }}</h2>
                <p class="mt-3 max-w-xl text-white/85">{{ $config['subtitle'] ?? 'Berkunjung ke kantor kami? Catat kunjungan Anda secara daring agar pelayanan lebih cepat.' }}</p>
                <a href="{{ $guestbookUrl }}" class="btn btn-light mt-6">{{ $config['button_text'] ?? 'Isi Buku Tamu' }}</a>
            </div>
            @if($config['show_qr'] ?? false)
                <div class="rounded-2xl bg-white p-4 text-center">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data={{ urlencode($guestbookAbsoluteUrl) }}" alt="Kode QR buku tamu" class="size-40" loading="lazy">
                    <p class="mt-2 text-xs text-slate-500">Pindai untuk mengisi</p>
                </div>
            @endif
        </div>
    </div>
</section>
