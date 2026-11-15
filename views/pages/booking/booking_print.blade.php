{{-- Bukti reservasi siap cetak. Variabel: $booking. --}}
@extends('themes.starter.layouts.public')

@section('content')
    <div class="container-page max-w-2xl py-10">
        <div class="no-print mb-6 flex justify-end">
            <button type="button" onclick="window.print()" class="btn btn-primary">@include('themes.starter.components.icon', ['name' => 'printer', 'class' => 'size-4']) Cetak</button>
        </div>
        <div class="card p-8">
            <div class="flex items-center justify-between border-b border-dashed border-slate-300 pb-6">
                <div>
                    <p class="text-sm text-slate-500">Bukti Reservasi</p>
                    <p class="text-lg font-bold text-slate-900">{{ data_get($profile ?? null, 'website_name') ?? data_get($application ?? null, 'name') }}</p>
                </div>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ urlencode((string) data_get($booking ?? null, 'booking_code')) }}" alt="QR kode booking" class="size-24">
            </div>
            <dl class="mt-6 grid gap-4 text-sm sm:grid-cols-2">
                <div><dt class="text-slate-500">Kode booking</dt><dd class="font-mono text-lg font-bold">{{ data_get($booking ?? null, 'booking_code') }}</dd></div>
                <div><dt class="text-slate-500">Nama</dt><dd class="font-medium">{{ data_get($booking ?? null, 'visitor_name') }}</dd></div>
                <div><dt class="text-slate-500">Layanan</dt><dd class="font-medium">{{ data_get($booking ?? null, 'schedule.name') ?? '-' }}</dd></div>
                <div><dt class="text-slate-500">Tanggal</dt><dd class="font-medium">{{ data_get($booking ?? null, 'booking_date') ? \Illuminate\Support\Carbon::parse(data_get($booking, 'booking_date'))->locale('id')->translatedFormat('d F Y') : '-' }}</dd></div>
                <div><dt class="text-slate-500">Jumlah pengunjung</dt><dd class="font-medium">{{ data_get($booking ?? null, 'party_size') }} orang</dd></div>
                <div><dt class="text-slate-500">Telepon</dt><dd class="font-medium">{{ data_get($booking ?? null, 'visitor_phone') }}</dd></div>
            </dl>
            <p class="mt-8 text-xs text-slate-500">Tunjukkan bukti ini kepada petugas saat kedatangan.</p>
        </div>
    </div>
@endsection
