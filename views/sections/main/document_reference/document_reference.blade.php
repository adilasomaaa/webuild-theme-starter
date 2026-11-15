{{--
    Satu dokumen pilihan dari page builder (data $referencedDocuments dari core, di-key per id).
    Pengaturan: title, single_document_id.
--}}
@php
    $refDocument = collect($referencedDocuments ?? [])->get($config['single_document_id'] ?? null);
@endphp

@if($refDocument)
    <section class="section" data-section-type="document_reference">
        <div class="container-page">
            @if(filled($config['title'] ?? null))
                @include('themes.starter.components.section-heading', ['title' => $config['title'], 'subtitle' => null])
            @endif
            @include('themes.starter.components.document-item', ['document' => $refDocument, 'docVariant' => 'list'])
            @if(filled(data_get($refDocument, 'description')))
                <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ strip_tags((string) data_get($refDocument, 'description')) }}</p>
            @endif
            <a href="{{ route('public.documents.preview', data_get($refDocument, 'id')) }}" target="_blank" rel="noopener" class="mt-3 inline-flex text-sm font-semibold text-primary hover:underline">Pratinjau dokumen →</a>
        </div>
    </section>
@endif
