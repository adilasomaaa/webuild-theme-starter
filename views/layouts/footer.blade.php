@php
    $footerColumns = ['footer_col_1', 'footer_col_2', 'footer_col_3'];
    $hasFooterLayout = isset($layoutSections) && collect($footerColumns)->contains(fn ($area) => $layoutSections->has($area));

    // Pengaturan baris hak cipta diambil dari komponen "footer" (theme.json → component_settings.footer)
    $footerSectionItem = isset($layoutSections)
        ? collect($footerColumns)->flatMap(fn ($area) => $layoutSections->get($area, collect()))->first(fn ($s) => data_get($s, 'section_type') === 'footer')
        : null;
    $footerConfig = array_merge(
        (array) (is_array($sections ?? null) ? ($sections['footer']['configuration'] ?? []) : []),
        (array) (data_get($footerSectionItem, 'configuration') ?? []),
    );
    $footerSiteName = data_get($profile ?? null, 'website_name') ?? data_get($application ?? null, 'name') ?? config('app.name', 'Webuild');
@endphp

<footer class="mt-auto bg-slate-900 text-sm text-slate-400">
    <div class="container-page grid gap-10 py-12 md:grid-cols-3">
        @if($hasFooterLayout)
            @foreach($footerColumns as $area)
                <div class="space-y-6">
                    @foreach($layoutSections->get($area, collect()) as $footerSection)
                        @include('themes.starter.components.render-section', ['sectionItem' => $footerSection, 'area' => 'footer', 'section' => $footerSection])
                    @endforeach
                </div>
            @endforeach
        @else
            <div class="md:col-span-2">
                @include('themes.starter.sections.footer.footer.footer', ['config' => $footerConfig, 'inFooter' => true])
            </div>
            <div>
                @include('themes.starter.sections.footer.quick_links.quick_links', ['config' => [], 'inFooter' => true])
            </div>
        @endif
    </div>

    <div class="border-t border-slate-800">
        <div class="container-page flex flex-col gap-3 py-5 text-xs sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ date('Y') }} {{ $footerSiteName }}. {{ $footerConfig['copyright_text'] ?? 'Hak cipta dilindungi undang-undang.' }}</p>
            <div class="flex gap-4">
                @if(! empty($footerConfig['privacy_url']))
                    <a href="{{ $footerConfig['privacy_url'] }}" class="hover:text-white">Kebijakan Privasi</a>
                @endif
                @if(! empty($footerConfig['terms_url']))
                    <a href="{{ $footerConfig['terms_url'] }}" class="hover:text-white">Syarat & Ketentuan</a>
                @endif
            </div>
        </div>
    </div>
</footer>
