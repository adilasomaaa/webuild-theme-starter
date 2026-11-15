{{--
    Konten pilihan dari page builder (data $referencedContents dari core, di-key per id).
    Pengaturan: title, subtitle, mode (individual|majemuk), single_content_id, content_ids,
    display_mode (card|list), layout_direction (vertical|horizontal), columns (auto|1..4).
    - individual : satu konten tampil utuh (judul, gambar, isi)
    - majemuk    : kartu (card) atau daftar ringkas (list) sesuai urutan pilihan admin
--}}
@php
    $refPool = collect($referencedContents ?? []);
    $refMode = $config['mode'] ?? 'majemuk';
    $refIds = (array) ($config['content_ids'] ?? []);
    $refSingle = $refPool->get($config['single_content_id'] ?? ($refIds[0] ?? null));
    $refItems = collect($refIds)->map(fn ($id) => $refPool->get($id))->filter()->values();
    $refColSpan = (int) data_get($col ?? [], 'col_span', 12);
    $refColumns = (string) ($config['columns'] ?? 'auto');
    if ($refColumns === 'auto') {
        // Vertikal = ditumpuk; horizontal = menyesuaikan lebar kolom page builder
        $refColumns = ($config['layout_direction'] ?? 'vertical') === 'vertical' || $refColSpan <= 5 ? '1' : ($refColSpan <= 8 ? '2' : '3');
    }
    $refGridCols = ['1' => '', '2' => 'sm:grid-cols-2', '3' => 'sm:grid-cols-2 lg:grid-cols-3', '4' => 'sm:grid-cols-2 lg:grid-cols-4'][$refColumns] ?? 'sm:grid-cols-2 lg:grid-cols-3';
    $refHeading = [
        'title' => filled($config['title'] ?? null) ? $config['title'] : 'Konten Pilihan',
        'subtitle' => $config['subtitle'] ?? null,
    ];
@endphp

@if($refMode === 'individual' ? $refSingle : $refItems->isNotEmpty())
    <section class="section" data-section-type="content_reference">
        <div class="container-page">
            @include('themes.starter.components.section-heading', $refHeading)

            @if($refMode === 'individual')
                @php
                    $refDateRaw = data_get($refSingle, 'published_at') ?? data_get($refSingle, 'created_at');
                    $refImage = data_get($refSingle, 'featured_image_url');
                @endphp
                <article class="card p-6 sm:p-8 {{ $refColSpan >= 12 ? 'mx-auto max-w-3xl' : '' }}">
                    <h3 class="text-2xl font-bold text-slate-900">{{ data_get($refSingle, 'title') }}</h3>
                    @if($refDateRaw)
                        <p class="mt-2 text-sm text-slate-500">{{ \Illuminate\Support\Carbon::parse($refDateRaw)->locale('id')->translatedFormat('d F Y') }}</p>
                    @endif
                    @if($refImage)
                        <img src="{{ $refImage }}" alt="{{ data_get($refSingle, 'title') }}" loading="lazy" class="mt-6 aspect-video w-full rounded-xl object-cover">
                    @endif
                    <div class="prose-content mt-6">{!! data_get($refSingle, 'content') !!}</div>
                </article>

            @elseif(($config['display_mode'] ?? 'card') === 'list' || $refColumns === '1')
                <div class="space-y-4">
                    @foreach($refItems as $refItem)
                        @include('themes.starter.components.content-card', ['item' => $refItem, 'cardVariant' => $refColSpan <= 5 ? 'compact' : 'list'])
                    @endforeach
                </div>

            @else
                <div class="grid gap-6 {{ $refGridCols }}">
                    @foreach($refItems as $refItem)
                        @include('themes.starter.components.content-card', ['item' => $refItem, 'cardVariant' => 'grid'])
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endif
