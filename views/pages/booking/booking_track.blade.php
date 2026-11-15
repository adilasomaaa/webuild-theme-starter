{{--
    Lacak booking (/f/booking/track?code=...).
    Variabel: $code, $booking (booking_code, status, booking_date, visitor_name, party_size, schedule), $searched.
--}}
@extends('themes.starter.layouts.public')

@php
    $trackCode = $code ?? request('code', '');
    $trackStatus = data_get($booking ?? null, 'status');
    $trackStatus = is_object($trackStatus) ? ($trackStatus->value ?? '') : (string) $trackStatus;
    $trackStatusClass = match ($trackStatus) {
        'approved', 'confirmed', 'attended' => 'bg-emerald-100 text-emerald-700',
        'rejected', 'cancelled' => 'bg-red-100 text-red-700',
        default => 'bg-amber-100 text-amber-700',
    };
@endphp

@section('content')
    @include('themes.starter.components.page-header', ['title' => 'Lacak Booking', 'subtitle' => 'Masukkan kode booking untuk melihat status reservasi.', 'breadcrumbs' => [['label' => 'Reservasi', 'url' => route('public.booking.index')], ['label' => 'Lacak']]])

    <div class="container-page max-w-2xl py-10">
        <form method="GET" class="flex gap-2">
            <input type="text" name="code" value="{{ $trackCode }}" required placeholder="Kode booking" class="form-input uppercase" aria-label="Kode booking">
            <button class="btn btn-primary">Lacak</button>
        </form>

        @if(! empty($booking))
            <div class="card mt-8 p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs text-slate-500">Kode booking</p>
                        <p class="font-mono text-xl font-bold text-slate-900">{{ data_get($booking, 'booking_code') }}</p>
                    </div>
                    <span class="rounded-full px-3 py-1 text-xs font-semibold capitalize {{ $trackStatusClass }}">{{ $trackStatus ?: 'menunggu' }}</span>
                </div>
                <dl class="mt-6 grid gap-4 text-sm sm:grid-cols-2">
                    <div><dt class="text-slate-500">Nama</dt><dd class="font-medium">{{ data_get($booking, 'visitor_name') }}</dd></div>
                    <div><dt class="text-slate-500">Layanan</dt><dd class="font-medium">{{ data_get($booking, 'schedule.name') ?? data_get($booking, 'schedule.title') ?? '-' }}</dd></div>
                    <div><dt class="text-slate-500">Tanggal</dt><dd class="font-medium">{{ data_get($booking, 'booking_date') ? \Illuminate\Support\Carbon::parse(data_get($booking, 'booking_date'))->locale('id')->translatedFormat('l, d F Y') : '-' }}</dd></div>
                    <div><dt class="text-slate-500">Jumlah pengunjung</dt><dd class="font-medium">{{ data_get($booking, 'party_size') }} orang</dd></div>
                </dl>
                @if(data_get($booking, 'status_note'))
                    <p class="mt-4 rounded-lg bg-slate-50 p-3 text-sm text-slate-600">{{ data_get($booking, 'status_note') }}</p>
                @endif
                <a href="{{ route('public.booking.print', data_get($booking, 'booking_code')) }}" target="_blank" class="btn btn-outline mt-6">
                    @include('themes.starter.components.icon', ['name' => 'printer', 'class' => 'size-4']) Cetak Bukti
                </a>
            </div>
        @elseif(($searched ?? false) || filled($trackCode))
            <div class="mt-8">
                @include('themes.starter.components.empty-state', ['emptyMessage' => "Booking dengan kode \"{$trackCode}\" tidak ditemukan.", 'emptyIcon' => 'search'])
            </div>
        @endif
    </div>
@endsection
