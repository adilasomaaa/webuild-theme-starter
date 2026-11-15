{{--
    Pranala / tautan terkait dari $links (title, url, logo_url, description).
    Pengaturan: title, subtitle, variant (strip|grid), limit, columns.
--}}
@php
    $pranalaItems = collect(($links ?? null) instanceof \Illuminate\Contracts\Pagination\Paginator ? $links->items() : ($links ?? []))->take((int) ($config['limit'] ?? (($inFooter ?? false) ? 6 : 12)))->values();
    $pranalaTitle = array_key_exists('title', $config) ? $config['title'] : 'Tautan Terkait';
    $pranalaColumns = match ((string) ($config['columns'] ?? 'auto')) {
        '2' => 'sm:grid-cols-2',
        '3' => 'sm:grid-cols-2 lg:grid-cols-3',
        default => 'sm:grid-cols-2 lg:grid-cols-4',
    };
@endphp
@if($inFooter ?? false)
    <div>
        @if(filled($pranalaTitle))
            <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-white">{{ $pranalaTitle }}</h2>
        @endif
        <ul class="space-y-2.5">
            @foreach($pranalaItems as $pranalaItem)
                <li><a href="{{ data_get($pranalaItem, 'url') }}" target="_blank" rel="noopener" class="hover:text-white">{{ data_get($pranalaItem, 'title') }}</a></li>
            @endforeach
        </ul>
    </div>
@else
    <section class="section" data-section-type="pranala">
        <div class="container-page">
            @include('themes.starter.components.section-heading', [
                'title' => $pranalaTitle,
                'subtitle' => array_key_exists('subtitle', $config) ? $config['subtitle'] : 'Akses cepat ke portal dan layanan mitra.',
                'headingActionText' => 'Semua tautan',
                'headingActionUrl' => route('public.pranala.index'),
            ])
            @if($pranalaItems->isEmpty())
                @include('themes.starter.components.empty-state', ['emptyMessage' => 'Belum ada tautan terkait.', 'emptyIcon' => 'link'])
            @elseif(($config['variant'] ?? 'strip') === 'strip')
                <div class="flex flex-wrap items-center justify-center gap-4">
                    @foreach($pranalaItems as $pranalaItem)
                        <a href="{{ data_get($pranalaItem, 'url') }}" target="_blank" rel="noopener" title="{{ data_get($pranalaItem, 'title') }}" class="card card-hover flex h-20 min-w-40 items-center justify-center gap-3 px-5">
                            @if(data_get($pranalaItem, 'logo_url'))
                                <img src="{{ data_get($pranalaItem, 'logo_url') }}" alt="{{ data_get($pranalaItem, 'title') }}" class="max-h-12 max-w-32 object-contain" loading="lazy">
                            @else
                                @include('themes.starter.components.icon', ['name' => 'link', 'class' => 'size-5 text-primary'])
                                <span class="text-sm font-medium text-slate-700">{{ data_get($pranalaItem, 'title') }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            @else
                <div class="grid gap-4 {{ $pranalaColumns }}">
                    @foreach($pranalaItems as $pranalaItem)
                        @include('themes.starter.components.link-card', ['linkItem' => $pranalaItem])
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endif
