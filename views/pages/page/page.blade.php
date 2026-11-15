{{--
    Halaman statis (/p/{slug}). Variabel: $page (title, excerpt, content, featured_image_url, sections, comments_enabled).
    Juga dipakai core untuk beranda buatan page builder ($is_homepage): tanpa breadcrumb dan judul halaman.
--}}
@extends('themes.starter.layouts.public')

@php
    $staticPage = $page ?? $content ?? null;
    $staticHasSections = collect(data_get($staticPage, 'sections') ?? [])->isNotEmpty();
    $staticIsHomepage = (bool) ($is_homepage ?? false) || (bool) data_get($staticPage, 'is_homepage');
@endphp

@section('content')
    @unless($staticIsHomepage)
        @include('themes.starter.components.page-header', [
            'title' => data_get($staticPage, 'title', 'Halaman'),
            'subtitle' => data_get($staticPage, 'excerpt'),
            'breadcrumbs' => [['label' => data_get($staticPage, 'title', 'Halaman')]],
        ])
    @endunless

    @if($staticHasSections)
        @include('themes.starter.components.page-builder', ['page' => $staticPage, 'is_homepage' => $staticIsHomepage])
    @endif

    @if(! $staticHasSections || data_get($staticPage, 'comments_enabled'))
        <div class="container-page py-12">
            <div class="mx-auto max-w-3xl">
                @if(! $staticHasSections)
                    @if(data_get($staticPage, 'featured_image_url'))
                        <img src="{{ data_get($staticPage, 'featured_image_url') }}" alt="" class="mb-8 w-full rounded-2xl">
                    @endif
                    <div class="prose-content">{!! data_get($staticPage, 'content') !!}</div>
                @endif
                @if(data_get($staticPage, 'comments_enabled'))
                    @include('themes.starter.components.comments', ['config' => [], 'commentable' => $staticPage, 'commentableType' => 'page'])
                @endif
            </div>
        </div>
    @endif
@endsection
