{{--
    Detail dokumen.
    Variabel: $document (title, description, file_name, file_type, file_size, download_count, view_count, category, created_at),
    $relatedDocuments, $previewFileSize.
--}}
@extends('themes.starter.layouts.public')

@php
    $documentExt = strtolower(data_get($document, 'file_type') ?: pathinfo((string) data_get($document, 'file_name'), PATHINFO_EXTENSION));
    $documentCanPreview = $documentExt === 'pdf' && (($previewFileSize ?? 0) <= 20 * 1024 * 1024);
    $documentSize = data_get($document, 'file_size');
@endphp

@section('content')
    @include('themes.starter.components.page-header', [
        'title' => data_get($document, 'title'),
        'subtitle' => null,
        'breadcrumbs' => [['label' => 'Dokumen', 'url' => route('public.documents.index')], ['label' => \Illuminate\Support\Str::limit(data_get($document, 'title'), 40)]],
    ])

    <div class="container-page grid gap-10 py-10 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            @if(data_get($document, 'description'))
                <div class="prose-content">{!! nl2br(e(data_get($document, 'description'))) !!}</div>
            @endif
            @if($documentCanPreview)
                <iframe src="{{ route('public.documents.preview', data_get($document, 'id')) }}" title="Pratinjau {{ data_get($document, 'title') }}" class="h-[75vh] w-full rounded-2xl border border-slate-200"></iframe>
            @endif
        </div>

        <aside class="space-y-6">
            <div class="card p-6">
                <dl class="space-y-3 text-sm">
                    @foreach([
                        'Kategori' => data_get($document, 'category.name'),
                        'Format' => $documentExt ? strtoupper($documentExt) : null,
                        'Ukuran' => is_numeric($documentSize) ? \Illuminate\Support\Number::fileSize((int) $documentSize, 1) : $documentSize,
                        'Diunggah' => data_get($document, 'created_at') ? \Illuminate\Support\Carbon::parse(data_get($document, 'created_at'))->locale('id')->translatedFormat('d F Y') : null,
                        'Dilihat' => data_get($document, 'view_count'),
                        'Diunduh' => data_get($document, 'download_count'),
                    ] as $metaLabel => $metaValue)
                        @if(! is_null($metaValue) && $metaValue !== '')
                            <div class="flex justify-between gap-4">
                                <dt class="text-slate-500">{{ $metaLabel }}</dt>
                                <dd class="text-right font-medium text-slate-900">{{ $metaValue }}</dd>
                            </div>
                        @endif
                    @endforeach
                </dl>
                <a href="{{ route('public.documents.download', data_get($document, 'id')) }}" class="btn btn-primary mt-6 w-full">
                    @include('themes.starter.components.icon', ['name' => 'download', 'class' => 'size-4']) Unduh Dokumen
                </a>
            </div>

            @if(collect($relatedDocuments ?? [])->isNotEmpty())
                <div>
                    <h2 class="mb-3 font-semibold text-slate-900">Dokumen Terkait</h2>
                    <div class="space-y-3">
                        @foreach($relatedDocuments as $relatedDocument)
                            @include('themes.starter.components.document-item', ['document' => $relatedDocument, 'docVariant' => 'list'])
                        @endforeach
                    </div>
                </div>
            @endif
        </aside>
    </div>
@endsection
