{{--
    Judul section yang konsisten.
    Parameter: $title, $subtitle, lalu opsional $headingBadge, $headingActionText + $headingActionUrl, $headingAlign ('left'|'center').
    (Parameter opsional diberi prefiks agar tidak tertimpa variabel milik view pemanggil.)
--}}
@php
    $headingCentered = ($headingAlign ?? 'left') === 'center';
@endphp
@if(filled($title ?? null) || filled($subtitle ?? null))
    <div class="mb-8 flex flex-col gap-4 {{ $headingCentered ? 'items-center text-center' : 'sm:flex-row sm:items-end sm:justify-between' }}">
        <div class="max-w-2xl">
            @if(filled($headingBadge ?? null))
                <span class="badge mb-3">{{ $headingBadge }}</span>
            @endif
            @if(filled($title ?? null))
                <h2 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">{{ $title }}</h2>
            @endif
            @if(filled($subtitle ?? null))
                <p class="mt-2 text-slate-600">{{ $subtitle }}</p>
            @endif
        </div>
        @if(filled($headingActionUrl ?? null) && filled($headingActionText ?? null))
            <a href="{{ $headingActionUrl }}" class="btn btn-outline btn-sm shrink-0">
                {{ $headingActionText }}
                @include('themes.starter.components.icon', ['name' => 'arrow-right', 'class' => 'size-4'])
            </a>
        @endif
    </div>
@endif
