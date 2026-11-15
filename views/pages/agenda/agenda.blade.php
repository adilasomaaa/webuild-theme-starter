{{--
    Daftar agenda (/f/agenda).
    Variabel: $agendas (paginator), $selectedMonth, $selectedYear, $search, $pageSettings (title, subtitle), $websiteName.
--}}
@extends('themes.starter.layouts.public')

@php
    $agendaPageTitle = $pageSettings['title'] ?? 'Agenda Kegiatan';
    $agendaPageSubtitle = str_replace('{website_name}', $websiteName ?? '', $pageSettings['subtitle'] ?? 'Jadwal kegiatan resmi instansi.');
    $agendaMonth = (int) ($selectedMonth ?? now()->month);
    $agendaYear = (int) ($selectedYear ?? now()->year);
@endphp

@section('content')
    @include('themes.starter.components.page-header', ['title' => $agendaPageTitle, 'subtitle' => $agendaPageSubtitle, 'breadcrumbs' => [['label' => $agendaPageTitle]]])

    <div class="container-page py-10">
        <form method="GET" class="card mb-8 grid gap-3 p-4 sm:grid-cols-4">
            <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Cari agenda..." class="form-input sm:col-span-2" aria-label="Cari agenda">
            <select name="month" class="form-input" aria-label="Bulan">
                @foreach(range(1, 12) as $monthNumber)
                    <option value="{{ $monthNumber }}" @selected($monthNumber === $agendaMonth)>{{ \Illuminate\Support\Carbon::create(null, $monthNumber, 1)->locale('id')->translatedFormat('F') }}</option>
                @endforeach
            </select>
            <div class="flex gap-2">
                <select name="year" class="form-input" aria-label="Tahun">
                    @foreach(range(now()->year - 2, now()->year + 1) as $yearNumber)
                        <option value="{{ $yearNumber }}" @selected($yearNumber === $agendaYear)>{{ $yearNumber }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">@include('themes.starter.components.icon', ['name' => 'search', 'class' => 'size-4'])<span class="sr-only">Terapkan</span></button>
            </div>
        </form>

        @if(count($agendas ?? []) === 0)
            @include('themes.starter.components.empty-state', ['emptyMessage' => 'Tidak ada agenda pada periode ini.', 'emptyIcon' => 'calendar'])
        @else
            <div class="grid gap-4 md:grid-cols-2">
                @foreach($agendas as $agendaItem)
                    @include('themes.starter.components.agenda-item', ['agenda' => $agendaItem])
                @endforeach
            </div>
            @if(method_exists($agendas, 'links'))
                {{ $agendas->links('themes.starter.components.pagination') }}
            @endif
        @endif
    </div>
@endsection
