{{--
    Item agenda dengan kotak tanggal.
    Parameter: $agenda
--}}
@php
    $agendaStart = data_get($agenda, 'start_at') ? \Illuminate\Support\Carbon::parse(data_get($agenda, 'start_at'))->locale('id') : null;
    $agendaEnd = data_get($agenda, 'end_at') ? \Illuminate\Support\Carbon::parse(data_get($agenda, 'end_at'))->locale('id') : null;
    $agendaUrl = data_get($agenda, 'slug') ? route('public.agenda.show', data_get($agenda, 'slug')) : '#';
@endphp

<article class="card card-hover flex gap-4 p-4">
    <div class="flex w-16 shrink-0 flex-col items-center justify-center rounded-xl bg-primary text-white">
        @if($agendaStart)
            <span class="text-2xl font-bold leading-none">{{ $agendaStart->format('d') }}</span>
            <span class="mt-1 text-xs uppercase">{{ $agendaStart->translatedFormat('M') }}</span>
        @else
            @include('themes.starter.components.icon', ['name' => 'calendar', 'class' => 'size-6'])
        @endif
    </div>
    <div class="min-w-0 flex-1">
        <h3 class="line-clamp-2 font-semibold text-slate-900">
            <a href="{{ $agendaUrl }}" class="hover:text-primary">{{ data_get($agenda, 'title') }}</a>
        </h3>
        <div class="mt-2 space-y-1 text-xs text-slate-500">
            @if($agendaStart)
                <p class="flex items-center gap-1.5">
                    @include('themes.starter.components.icon', ['name' => 'clock', 'class' => 'size-3.5'])
                    {{ $agendaStart->format('H:i') }}@if($agendaEnd) – {{ $agendaEnd->format('H:i') }}@endif WIB
                </p>
            @endif
            @if(data_get($agenda, 'location'))
                <p class="flex items-center gap-1.5">
                    @include('themes.starter.components.icon', ['name' => 'map-pin', 'class' => 'size-3.5'])
                    {{ data_get($agenda, 'location') }}
                </p>
            @endif
        </div>
    </div>
</article>
