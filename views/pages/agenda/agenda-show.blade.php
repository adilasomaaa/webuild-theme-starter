{{--
    Detail agenda. Variabel: $agenda (title, description, location, start_at, end_at, organizer, official_name, official_position).
--}}
@extends('themes.starter.layouts.public')

@php
    $showStart = data_get($agenda, 'start_at') ? \Illuminate\Support\Carbon::parse(data_get($agenda, 'start_at'))->locale('id') : null;
    $showEnd = data_get($agenda, 'end_at') ? \Illuminate\Support\Carbon::parse(data_get($agenda, 'end_at'))->locale('id') : null;
    $calendarUrl = $showStart ? 'https://calendar.google.com/calendar/render?' . http_build_query([
        'action' => 'TEMPLATE',
        'text' => data_get($agenda, 'title'),
        'dates' => $showStart->copy()->utc()->format('Ymd\THis\Z') . '/' . ($showEnd ?? $showStart->copy()->addHour())->copy()->utc()->format('Ymd\THis\Z'),
        'location' => data_get($agenda, 'location'),
    ]) : null;
@endphp

@section('content')
    @include('themes.starter.components.page-header', [
        'title' => data_get($agenda, 'title'),
        'subtitle' => null,
        'breadcrumbs' => [['label' => 'Agenda', 'url' => route('public.agenda.index')], ['label' => 'Detail']],
    ])

    <div class="container-page grid gap-10 py-10 lg:grid-cols-3">
        <div class="prose-content lg:col-span-2">{!! data_get($agenda, 'description') ?: '<p>Tidak ada deskripsi.</p>' !!}</div>
        <aside class="card h-fit space-y-4 p-6 text-sm">
            @foreach([
                ['calendar', 'Tanggal', $showStart?->translatedFormat('l, d F Y')],
                ['clock', 'Waktu', $showStart ? $showStart->format('H:i') . ($showEnd ? ' – ' . $showEnd->format('H:i') : '') . ' WIB' : null],
                ['map-pin', 'Lokasi', data_get($agenda, 'location')],
                ['building', 'Penyelenggara', data_get($agenda, 'organizer')],
                ['user', 'Pejabat', trim(data_get($agenda, 'official_name') . (data_get($agenda, 'official_position') ? ' — ' . data_get($agenda, 'official_position') : ''))],
            ] as [$metaIcon, $metaLabel, $metaValue])
                @if(filled($metaValue))
                    <div class="flex gap-3">
                        <span class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary">@include('themes.starter.components.icon', ['name' => $metaIcon, 'class' => 'size-4'])</span>
                        <div>
                            <p class="text-xs text-slate-500">{{ $metaLabel }}</p>
                            <p class="font-medium text-slate-900">{{ $metaValue }}</p>
                        </div>
                    </div>
                @endif
            @endforeach
            @if($calendarUrl)
                <a href="{{ $calendarUrl }}" target="_blank" rel="noopener" class="btn btn-outline w-full">Tambah ke Google Calendar</a>
            @endif
        </aside>
    </div>
@endsection
