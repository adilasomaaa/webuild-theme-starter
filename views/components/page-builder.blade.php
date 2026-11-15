{{--
    Merender susunan section halaman dari page builder ($page->sections).
    Satu kolom → section tampil penuh; beberapa kolom → grid 12 kolom (section di dalamnya tanpa container sendiri).
--}}
@foreach(collect(data_get($page, 'sections') ?? [])->filter(fn ($s) => data_get($s, 'is_enabled', true)) as $pageSection)
    @php
        $pageColumns = collect(data_get($pageSection, 'columns') ?? []);
        $pageSingleColumn = $pageColumns->count() <= 1;
    @endphp
    @if($pageSingleColumn)
        @include('themes.starter.components.render-section', [
            'sectionItem' => $pageColumns->first() ?? $pageSection,
            'area' => 'main',
            'section' => $pageSection,
            'col' => $pageColumns->first() ?? [],
            'is_page' => ! ($is_homepage ?? false),
        ])
    @else
        <div class="container-page py-8 sm:py-12">
            <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-12">
                @foreach($pageColumns as $pageColumn)
                    @php
                        $columnSpan = [1 => 'lg:col-span-1', 2 => 'lg:col-span-2', 3 => 'lg:col-span-3', 4 => 'lg:col-span-4', 5 => 'lg:col-span-5', 6 => 'lg:col-span-6',
                            7 => 'lg:col-span-7', 8 => 'lg:col-span-8', 9 => 'lg:col-span-9', 10 => 'lg:col-span-10', 11 => 'lg:col-span-11'][(int) data_get($pageColumn, 'col_span', 12)] ?? 'lg:col-span-12';
                    @endphp
                    <div class="section-col {{ $columnSpan }}">
                        @include('themes.starter.components.render-section', [
                            'sectionItem' => $pageColumn,
                            'area' => 'main',
                            'section' => $pageSection,
                            'col' => $pageColumn,
                            'is_page' => true,
                        ])
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endforeach
