{{--
    Pertanyaan umum (FAQ) dari $faqs (question, answer, category).
    Varian (config.layout_orientation): vertical | horizontal. Di kolom (col_span < 12) selalu vertikal dan rata kiri.
    Pengaturan: title, subtitle, limit, category, allow_multiple, collapse_all_default.
--}}
@php
    $faqItems = collect(($faqs ?? null) instanceof \Illuminate\Contracts\Pagination\Paginator ? $faqs->items() : ($faqs ?? []))
        ->when(! empty($config['category']), fn ($items) => $items->where('category', $config['category']))
        ->sortBy(fn ($faq) => data_get($faq, 'sort_order', 0))
        ->take((int) ($config['limit'] ?? 6))
        ->values();
    $faqInColumn = (int) data_get($col ?? [], 'col_span', 12) < 12;
    $faqHorizontal = ! $faqInColumn && ($config['layout_orientation'] ?? $variant ?? 'vertical') === 'horizontal';
    $faqOpenFirst = ! ($config['collapse_all_default'] ?? true);
@endphp
<section class="section section-muted" data-section-type="faq" id="faq">
    <div class="{{ $faqInColumn ? '' : 'container-page' }} {{ $faqHorizontal ? 'grid gap-10 lg:grid-cols-3' : '' }}">
        <div>
            @include('themes.starter.components.section-heading', [
                'title' => $config['title'] ?? 'Pertanyaan Umum',
                'subtitle' => $config['subtitle'] ?? 'Jawaban atas pertanyaan yang sering diajukan masyarakat.',
                'headingAlign' => $faqHorizontal || $faqInColumn ? 'left' : 'center',
            ])
            @if($faqHorizontal || $faqInColumn)
                <a href="{{ route('public.faqs.index') }}" class="btn btn-outline btn-sm">Lihat semua FAQ</a>
            @endif
        </div>
        <div class="{{ $faqHorizontal ? 'lg:col-span-2' : ($faqInColumn ? 'mt-4' : 'mx-auto max-w-3xl') }} space-y-3" @unless($config['allow_multiple'] ?? true) data-accordion="single" @endunless>
            @forelse($faqItems as $faqItem)
                @include('themes.starter.components.faq-item', ['faqItem' => $faqItem, 'faqOpen' => $faqOpenFirst && $loop->first])
            @empty
                @include('themes.starter.components.empty-state', ['emptyMessage' => 'Belum ada pertanyaan yang diterbitkan.', 'emptyIcon' => 'help'])
            @endforelse
        </div>
    </div>
</section>
