{{--
    Formulir reservasi kunjungan (/f/booking).
    Variabel: $schedules (id, name|title, description), $pageSettings (title, subtitle).
    Field dikirim ke public.booking.store sesuai StoreBookingRequest.
--}}
@extends('themes.starter.layouts.public')

@php
    $bookingSchedules = collect($schedules ?? $services ?? []);
    $bookingTitle = $pageSettings['title'] ?? 'Reservasi Kunjungan';
    // Nilai harus sama dengan enum App\Enums\VisitorCategory di aplikasi
    $visitorCategories = ['Umum', 'Pelajar', 'Mahasiswa', 'Guru', 'Dosen', 'Peneliti', 'Seniman', 'Wisatawan Asing'];
@endphp

@section('content')
    @include('themes.starter.components.page-header', ['title' => $bookingTitle, 'subtitle' => $pageSettings['subtitle'] ?? 'Isi formulir untuk menjadwalkan kunjungan Anda.', 'breadcrumbs' => [['label' => $bookingTitle]]])

    <div class="container-page grid gap-10 py-10 lg:grid-cols-3">
        <form action="{{ route('public.booking.store') }}" method="POST" class="card space-y-5 p-6 sm:p-8 lg:col-span-2">
            @csrf
            @include('themes.starter.components.flash')

            <fieldset>
                <legend class="form-label">Pilih layanan / jadwal</legend>
                @if($bookingSchedules->isEmpty())
                    <p class="rounded-lg bg-amber-50 p-3 text-sm text-amber-800">Belum ada jadwal layanan yang dibuka.</p>
                @else
                    <div class="grid gap-3 sm:grid-cols-2">
                        @foreach($bookingSchedules as $schedule)
                            <label class="flex cursor-pointer gap-3 rounded-xl border border-slate-200 p-4 has-checked:border-primary has-checked:bg-primary/5">
                                <input type="radio" name="schedule_id" value="{{ data_get($schedule, 'id') }}" required class="mt-1 accent-(--color-primary)" @checked(old('schedule_id') == data_get($schedule, 'id'))>
                                <span>
                                    <span class="block font-medium text-slate-900">{{ data_get($schedule, 'name') ?? data_get($schedule, 'title') }}</span>
                                    @if(data_get($schedule, 'description'))
                                        <span class="mt-0.5 block text-xs text-slate-500">{{ \Illuminate\Support\Str::limit(strip_tags(data_get($schedule, 'description')), 90) }}</span>
                                    @endif
                                </span>
                            </label>
                        @endforeach
                    </div>
                @endif
                @error('schedule_id')<p class="form-error">{{ $message }}</p>@enderror
            </fieldset>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="booking_date" class="form-label">Tanggal kunjungan</label>
                    <input id="booking_date" type="date" name="booking_date" min="{{ now()->toDateString() }}" value="{{ old('booking_date') }}" required class="form-input">
                    @error('booking_date')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="party_size" class="form-label">Jumlah pengunjung</label>
                    <input id="party_size" type="number" name="party_size" min="1" max="100" value="{{ old('party_size', 1) }}" required class="form-input">
                    @error('party_size')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="visitor_name" class="form-label">Nama lengkap</label>
                    <input id="visitor_name" name="visitor_name" value="{{ old('visitor_name') }}" required maxlength="255" class="form-input">
                    @error('visitor_name')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="visitor_phone" class="form-label">Nomor telepon / WhatsApp</label>
                    <input id="visitor_phone" type="tel" name="visitor_phone" value="{{ old('visitor_phone') }}" required maxlength="50" class="form-input">
                    @error('visitor_phone')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="visitor_email" class="form-label">Email <span class="font-normal text-slate-400">(opsional)</span></label>
                    <input id="visitor_email" type="email" name="visitor_email" value="{{ old('visitor_email') }}" class="form-input">
                </div>
                <div>
                    <label for="visitor_category" class="form-label">Kategori pengunjung</label>
                    <select id="visitor_category" name="visitor_category" required class="form-input">
                        @foreach($visitorCategories as $visitorCategory)
                            <option value="{{ $visitorCategory }}" @selected(old('visitor_category') === $visitorCategory)>{{ $visitorCategory }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label for="visitor_origin" class="form-label">Asal instansi / daerah <span class="font-normal text-slate-400">(opsional)</span></label>
                    <input id="visitor_origin" name="visitor_origin" value="{{ old('visitor_origin') }}" maxlength="255" class="form-input">
                </div>
                <div class="sm:col-span-2">
                    <label for="notes" class="form-label">Catatan <span class="font-normal text-slate-400">(opsional)</span></label>
                    <textarea id="notes" name="notes" rows="3" maxlength="1000" class="form-input">{{ old('notes') }}</textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-full sm:w-auto" @disabled($bookingSchedules->isEmpty())>Kirim Reservasi</button>
        </form>

        <aside class="space-y-4">
            <div class="card p-6">
                <h2 class="font-semibold text-slate-900">Sudah punya kode booking?</h2>
                <p class="mt-1 text-sm text-slate-600">Cek status reservasi Anda kapan saja.</p>
                <a href="{{ route('public.booking.track') }}" class="btn btn-outline mt-4 w-full">Lacak Booking</a>
            </div>
        </aside>
    </div>
@endsection
