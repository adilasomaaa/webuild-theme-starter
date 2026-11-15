{{--
    Item dokumen (unduhan/regulasi).
    Parameter: $document, opsional $docVariant ('list'|'grid')
--}}
@php
    $docSlug = data_get($document, 'slug');
    $docId = data_get($document, 'id');
    $docUrl = $docSlug ? route('public.documents.show', $docSlug) : '#';
    $docDownloadUrl = $docId ? route('public.documents.download', $docId) : null;
    $docExt = strtoupper(data_get($document, 'file_type') ?: pathinfo((string) (data_get($document, 'file_name') ?? data_get($document, 'file_path')), PATHINFO_EXTENSION) ?: 'FILE');
    $docSize = data_get($document, 'file_size');
    $docSizeLabel = is_numeric($docSize) ? \Illuminate\Support\Number::fileSize((int) $docSize, 1) : $docSize;
    $docDateRaw = data_get($document, 'published_at') ?? data_get($document, 'created_at');
    $docDate = $docDateRaw ? \Illuminate\Support\Carbon::parse($docDateRaw)->locale('id') : null;
    $docLayout = $docVariant ?? 'list';
@endphp

<article class="card card-hover flex gap-4 p-4 {{ $docLayout === 'grid' ? 'flex-col' : 'items-center' }}">
    <span class="flex size-12 shrink-0 flex-col items-center justify-center rounded-xl bg-primary/10 text-primary">
        @include('themes.starter.components.icon', ['name' => 'file', 'class' => 'size-5'])
        <span class="mt-0.5 text-[10px] font-bold">{{ \Illuminate\Support\Str::limit($docExt, 4, '') }}</span>
    </span>
    <div class="min-w-0 flex-1">
        <h3 class="line-clamp-2 font-semibold text-slate-900">
            <a href="{{ $docUrl }}" class="hover:text-primary">{{ data_get($document, 'title') }}</a>
        </h3>
        <p class="mt-1 flex flex-wrap gap-x-3 gap-y-1 text-xs text-slate-500">
            @if(data_get($document, 'category.name'))
                <span>{{ data_get($document, 'category.name') }}</span>
            @endif
            @if($docDate)
                <span>{{ $docDate->translatedFormat('d M Y') }}</span>
            @endif
            @if($docSizeLabel)
                <span>{{ $docSizeLabel }}</span>
            @endif
            @if(! is_null(data_get($document, 'download_count')))
                <span>{{ number_format((int) data_get($document, 'download_count'), 0, ',', '.') }} unduhan</span>
            @endif
        </p>
    </div>
    @if($docDownloadUrl)
        <a href="{{ $docDownloadUrl }}" class="btn btn-outline btn-sm shrink-0 {{ $docLayout === 'grid' ? 'w-full' : '' }}">
            @include('themes.starter.components.icon', ['name' => 'download', 'class' => 'size-4'])
            Unduh
        </a>
    @endif
</article>
