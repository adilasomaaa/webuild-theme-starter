{{-- Teks bebas dari editor. Pengaturan: title, content (HTML) atau html_content. --}}
@php
    $richHtml = $config['content'] ?? $config['html_content'] ?? '<p>Tulis konten di sini melalui pengaturan komponen.</p>';
@endphp
<section class="section" data-section-type="rich_text">
    <div class="container-page">
        <div class="mx-auto max-w-3xl">
            @if(filled($config['title'] ?? null))
                <h2 class="mb-6 text-2xl font-bold text-slate-900 sm:text-3xl">{{ $config['title'] }}</h2>
            @endif
            <div class="prose-content">{!! $richHtml !!}</div>
        </div>
    </div>
</section>
