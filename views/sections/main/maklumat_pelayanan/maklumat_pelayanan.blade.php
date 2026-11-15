{{--
    Maklumat pelayanan instansi.
    Pengaturan: custom_title, custom_description, document_id (dokumen maklumat), thumbnail_url, button_text,
    background_style (primary|light).
--}}
@php
    $maklumatDoc = ! empty($config['document_id']) ? collect(($documents ?? null) instanceof \Illuminate\Contracts\Pagination\Paginator ? $documents->items() : ($documents ?? []))->firstWhere('id', $config['document_id']) : null;
    $maklumatTitle = $config['custom_title'] ?? data_get($maklumatDoc, 'title') ?? 'Maklumat Pelayanan';
    $maklumatText = $config['custom_description'] ?? 'Dengan ini, kami menyatakan sanggup menyelenggarakan pelayanan sesuai standar pelayanan yang telah ditetapkan dan apabila tidak menepati janji ini, kami siap menerima sanksi sesuai peraturan perundang-undangan yang berlaku.';
    $maklumatPrimary = ($config['background_style'] ?? 'primary') === 'primary';
@endphp
<section class="section {{ $maklumatPrimary ? 'bg-primary text-white' : 'section-muted' }}" data-section-type="maklumat_pelayanan">
    <div class="container-page">
        <div class="grid items-center gap-10 lg:grid-cols-5">
            <div class="lg:col-span-3">
                <span class="mb-4 inline-flex size-12 items-center justify-center rounded-xl {{ $maklumatPrimary ? 'bg-white/15' : 'bg-primary/10 text-primary' }}">
                    @include('themes.starter.components.icon', ['name' => 'quote', 'class' => 'size-6'])
                </span>
                <h2 class="text-2xl font-bold sm:text-3xl {{ $maklumatPrimary ? '' : 'text-slate-900' }}">{{ $maklumatTitle }}</h2>
                <blockquote class="mt-5 text-lg leading-relaxed {{ $maklumatPrimary ? 'text-white/90' : 'text-slate-600' }}">“{{ $maklumatText }}”</blockquote>
                @if($maklumatDoc)
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('public.documents.show', data_get($maklumatDoc, 'slug')) }}" class="btn {{ $maklumatPrimary ? 'btn-light' : 'btn-primary' }}">{{ $config['button_text'] ?? 'Lihat Dokumen' }}</a>
                        <a href="{{ route('public.documents.download', data_get($maklumatDoc, 'id')) }}" class="btn {{ $maklumatPrimary ? 'border border-white/40 hover:bg-white/10' : 'btn-outline' }}">
                            @include('themes.starter.components.icon', ['name' => 'download', 'class' => 'size-4']) Unduh
                        </a>
                    </div>
                @endif
            </div>
            @if(! empty($config['thumbnail_url']))
                <div class="lg:col-span-2">
                    <img src="{{ $config['thumbnail_url'] }}" alt="{{ $maklumatTitle }}" class="w-full rounded-2xl bg-white object-contain shadow-lg" loading="lazy">
                </div>
            @endif
        </div>
    </div>
</section>
