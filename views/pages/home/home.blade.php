{{--
    Beranda. Urutan section diatur admin melalui layout builder ($layoutSections['main'])
    atau halaman beranda khusus dari page builder ($page->is_homepage).
--}}
@extends('themes.starter.layouts.public')

@section('content')
    @if(isset($page) && data_get($page, 'is_homepage'))
        @include('themes.starter.components.page-builder', ['page' => $page, 'is_homepage' => true])
    @else
        @php
            $homeSections = isset($layoutSections) ? $layoutSections->get('main', collect()) : collect();
        @endphp
        @forelse($homeSections as $homeSection)
            @include('themes.starter.components.render-section', ['sectionItem' => $homeSection, 'area' => 'main', 'section' => $homeSection, 'is_homepage' => true])
        @empty
            @include('themes.starter.sections.main.hero.hero', ['config' => []])
            @include('themes.starter.sections.main.contents.contents', ['config' => []])
        @endforelse
    @endif
@endsection
