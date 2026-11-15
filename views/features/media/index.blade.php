{{--
    Galeri media (/media).
    Variabel: $feature, $contents (paginator media), $availableCategories, $currentCategory, $pageSettings.
--}}
@extends('themes.starter.layouts.public')

@php
    $mediaIndexTitle = $pageSettings['title'] ?? data_get($feature ?? null, 'name', 'Galeri');
@endphp

@section('content')
    @include('themes.starter.components.page-header', [
        'title' => data_get($currentCategory ?? null, 'name') ?? $mediaIndexTitle,
        'subtitle' => $pageSettings['subtitle'] ?? data_get($feature ?? null, 'description'),
        'breadcrumbs' => array_values(array_filter([
            ['label' => $mediaIndexTitle, 'url' => isset($currentCategory) && $currentCategory ? route('public.media.index') : null],
            isset($currentCategory) && $currentCategory ? ['label' => data_get($currentCategory, 'name')] : null,
        ])),
    ])

    <div class="container-page py-10">
        @if(($pageSettings['show_category_filter'] ?? true) && collect($availableCategories ?? [])->isNotEmpty())
            <div class="mb-8 flex flex-wrap gap-2">
                <a href="{{ route('public.media.index') }}" class="btn btn-sm {{ empty($currentCategory) ? 'btn-primary' : 'btn-ghost' }}">Semua</a>
                @foreach($availableCategories as $mediaCategory)
                    <a href="{{ route('public.media.category', data_get($mediaCategory, 'slug') ?? data_get($mediaCategory, 'id')) }}"
                       class="btn btn-sm {{ data_get($currentCategory ?? null, 'id') == data_get($mediaCategory, 'id') ? 'btn-primary' : 'btn-ghost' }}">{{ data_get($mediaCategory, 'name') }}</a>
                @endforeach
            </div>
        @endif

        @if(count($contents ?? []) === 0)
            @include('themes.starter.components.empty-state', ['emptyMessage' => 'Belum ada media.', 'emptyIcon' => 'image'])
        @else
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
                @foreach($contents as $mediaItem)
                    @php
                        $mediaThumb = data_get($mediaItem, 'thumbnail_url') ?? data_get($mediaItem, 'image_url') ?? data_get($mediaItem, 'file_url');
                        $mediaHref = data_get($mediaItem, 'embed_url') ?? data_get($mediaItem, 'external_url') ?? data_get($mediaItem, 'media_url') ?? data_get($mediaItem, 'file_url') ?? $mediaThumb;
                    @endphp
                    <a href="{{ $mediaHref }}" target="_blank" rel="noopener" class="card card-hover group overflow-hidden">
                        <div class="relative aspect-[4/3] bg-slate-100">
                            @if($mediaThumb)
                                <img src="{{ $mediaThumb }}" alt="{{ data_get($mediaItem, 'title') }}" class="size-full object-cover" loading="lazy">
                            @endif
                            @if(data_get($mediaItem, 'type') === 'video')
                                <span class="absolute left-1/2 top-1/2 flex size-11 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-primary">
                                    @include('themes.starter.components.icon', ['name' => 'play', 'class' => 'size-5'])
                                </span>
                            @endif
                        </div>
                        <div class="p-3">
                            <p class="line-clamp-2 text-sm font-medium text-slate-900 group-hover:text-primary">{{ data_get($mediaItem, 'title') }}</p>
                            @if(data_get($mediaItem, 'created_at'))
                                <p class="mt-1 text-xs text-slate-500">{{ \Illuminate\Support\Carbon::parse(data_get($mediaItem, 'created_at'))->locale('id')->translatedFormat('d M Y') }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
            @if(method_exists($contents, 'links'))
                {{ $contents->links('themes.starter.components.pagination') }}
            @endif
        @endif
    </div>
@endsection
