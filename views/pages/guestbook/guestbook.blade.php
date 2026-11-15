{{--
    Buku tamu digital (/f/guestbook).
    Variabel: $categories (id, name), $pageSettings. Field sesuai StoreGuestbookRequest.
--}}
@extends('themes.starter.layouts.public')

@php
    $guestTitle = $pageSettings['title'] ?? 'Buku Tamu';
@endphp

@section('content')
    @include('themes.starter.components.page-header', ['title' => $guestTitle, 'subtitle' => $pageSettings['subtitle'] ?? 'Catat kunjungan Anda ke kantor kami.', 'breadcrumbs' => [['label' => $guestTitle]]])

    <div class="container-page max-w-2xl py-10">
        <form action="{{ route('public.guestbook.store') }}" method="POST" class="card space-y-5 p-6 sm:p-8">
            @csrf
            @include('themes.starter.components.flash')
            <div class="grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="name" class="form-label">Nama lengkap</label>
                    <input id="name" name="name" value="{{ old('name') }}" required maxlength="255" class="form-input">
                    @error('name')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="phone" class="form-label">Nomor telepon / WhatsApp</label>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required maxlength="50" class="form-input">
                    @error('phone')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="visit_date" class="form-label">Tanggal kunjungan</label>
                    <input id="visit_date" type="date" name="visit_date" value="{{ old('visit_date', now()->toDateString()) }}" required class="form-input">
                    @error('visit_date')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="party_size" class="form-label">Jumlah rombongan</label>
                    <input id="party_size" type="number" name="party_size" min="1" max="500" value="{{ old('party_size', 1) }}" required class="form-input">
                    @error('party_size')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                @if(collect($categories ?? [])->isNotEmpty())
                    <div>
                        <label for="category_id" class="form-label">Kategori tamu</label>
                        <select id="category_id" name="category_id" class="form-input">
                            <option value="">Pilih kategori</option>
                            @foreach($categories as $guestCategory)
                                <option value="{{ data_get($guestCategory, 'id') }}" @selected(old('category_id') == data_get($guestCategory, 'id'))>{{ data_get($guestCategory, 'name') }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="sm:col-span-2">
                    <label for="purpose" class="form-label">Keperluan kunjungan</label>
                    <textarea id="purpose" name="purpose" rows="4" required maxlength="1000" class="form-input">{{ old('purpose') }}</textarea>
                    @error('purpose')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-lg w-full sm:w-auto">Kirim</button>
        </form>
    </div>
@endsection
