{{--
    Sematan HTML bebas (widget pihak ketiga, iframe, dll.).
    Pengaturan: title, embed_code atau html. Kode dirender apa adanya — hanya admin yang dapat mengisinya.
--}}
@php
    $embedHtml = $config['embed_code'] ?? $config['html'] ?? null;
@endphp
<section class="section" data-section-type="html_embed">
    <div class="container-page">
        @if(filled($config['title'] ?? null))
            <h2 class="mb-6 text-2xl font-bold text-slate-900">{{ $config['title'] }}</h2>
        @endif
        @if(filled($embedHtml))
            <div class="overflow-hidden rounded-2xl [&_iframe]:w-full">{!! $embedHtml !!}</div>
        @else
            @include('themes.starter.components.empty-state', ['emptyMessage' => 'Tempel kode sematan pada pengaturan komponen.', 'emptyIcon' => 'grid'])
        @endif
    </div>
</section>
