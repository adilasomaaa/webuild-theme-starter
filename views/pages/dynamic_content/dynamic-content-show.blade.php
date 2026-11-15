{{--
    Detail konten dinamis.
    Variabel: $content (title, thumbnail_url, attribute_values, published_at), $category (name, slug, attributes: key, label, type),
    $relatedContents, $comments.
--}}
@extends('themes.starter.layouts.public')

@php
    $dynamicValues = (array) (data_get($content, 'attribute_values') ?? []);
    $dynamicAttributes = collect(data_get($category ?? null, 'attributes') ?? data_get($content, 'category.attributes') ?? [])
        ->filter(fn ($attr) => filled($dynamicValues[data_get($attr, 'key')] ?? null));
    $dynamicImage = data_get($content, 'thumbnail_url');
@endphp

@section('content')
    @include('themes.starter.components.page-header', [
        'title' => data_get($content, 'title'),
        'subtitle' => null,
        'breadcrumbs' => array_values(array_filter([
            ['label' => 'Katalog', 'url' => route('public.dynamic-content.index')],
            data_get($category ?? null, 'slug') ? ['label' => data_get($category, 'name'), 'url' => route('public.dynamic-category.show', data_get($category, 'slug'))] : null,
        ])),
    ])

    <div class="container-page grid gap-10 py-10 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            @if($dynamicImage)
                <img src="{{ $dynamicImage }}" alt="" class="aspect-video w-full rounded-2xl object-cover">
            @endif
            <dl class="grid gap-4 sm:grid-cols-2">
                @forelse($dynamicAttributes as $attr)
                    @php
                        $attrType = data_get($attr, 'type');
                        $attrType = is_object($attrType) ? ($attrType->value ?? null) : $attrType;
                        $attrValue = $dynamicValues[data_get($attr, 'key')];
                        $attrUrl = in_array($attrType, ['image', 'audio', 'file'], true) && is_object($content) && method_exists($content, $attrType === 'audio' ? 'getAudioUrl' : 'getImageUrl')
                            ? $content->{$attrType === 'audio' ? 'getAudioUrl' : 'getImageUrl'}(data_get($attr, 'key'))
                            : (is_string($attrValue) ? $attrValue : null);
                    @endphp
                    <div class="card p-4 {{ $attrType === 'richtext' ? 'sm:col-span-2' : '' }}">
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ data_get($attr, 'label') }}</dt>
                        <dd class="mt-1 text-slate-900">
                            @if($attrType === 'richtext')
                                <div class="prose-content">{!! $attrValue !!}</div>
                            @elseif($attrType === 'image' && $attrUrl)
                                <img src="{{ $attrUrl }}" alt="{{ data_get($attr, 'label') }}" class="mt-1 max-h-48 rounded-lg">
                            @elseif($attrType === 'audio' && $attrUrl)
                                <audio controls src="{{ $attrUrl }}" class="mt-1 w-full"></audio>
                            @elseif(is_array($attrValue))
                                {{ implode(', ', $attrValue) }}
                            @else
                                {{ $attrValue }}
                            @endif
                        </dd>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 sm:col-span-2">Tidak ada rincian tambahan.</p>
                @endforelse
            </dl>
            @include('themes.starter.components.comments', ['config' => [], 'commentable' => $content, 'commentableType' => 'dynamic-content'])
        </div>

        @if(collect($relatedContents ?? [])->isNotEmpty())
            <aside>
                <h2 class="mb-4 font-semibold text-slate-900">Lainnya</h2>
                <div class="space-y-4">
                    @foreach(collect($relatedContents)->take(5) as $relatedItem)
                        @include('themes.starter.components.dynamic-card', ['dynamicItem' => $relatedItem])
                    @endforeach
                </div>
            </aside>
        @endif
    </div>
@endsection
