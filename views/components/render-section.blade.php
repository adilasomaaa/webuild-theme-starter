{{--
    Merender satu section dari layout builder (header, main, footer) atau kolom page builder.

    Parameter:
    - $sectionItem : objek/array dengan section_type|type dan configuration|config
    - $area        : 'header' | 'main' | 'footer'

    Semua variabel data halaman (allContents, documents, faqs, menus, profile, dll.)
    otomatis diteruskan ke view section karena @include mewarisi variabel induknya.
--}}
@php
    $sectionType = data_get($sectionItem, 'section_type') ?? data_get($sectionItem, 'type');
    $sectionArea = $area ?? 'main';

    // $sections dari aplikasi berisi konfigurasi bawaan tema per komponen (array berindeks key)
    $themeSection = is_array($sections ?? null) ? ($sections[$sectionType] ?? null) : null;

    $sectionEnabled = (bool) data_get($sectionItem, 'is_enabled', true) && (bool) ($themeSection['is_enabled'] ?? true);
    $requiredFeature = $sectionType ? config("layout_sections.types.{$sectionType}.required_feature") : null;
    if ($requiredFeature && isset($application) && is_object($application) && method_exists($application, 'hasFeature')) {
        $sectionEnabled = $sectionEnabled && $application->hasFeature($requiredFeature);
    }

    $sectionConfig = array_merge(
        (array) ($themeSection['configuration'] ?? []),
        (array) (data_get($sectionItem, 'configuration') ?? data_get($sectionItem, 'config') ?? []),
    );

    $sectionView = $sectionType
        ? \Webuild\ThemeKit\ThemeRegistry::resolveSection('starter', $sectionType, $sectionArea)
        : null;
@endphp

@if($sectionEnabled && $sectionView)
    @include($sectionView, [
        'config' => $sectionConfig,
        'variant' => $themeSection['variant'] ?? null,
        'inFooter' => $sectionArea === 'footer',
        'inHeader' => $sectionArea === 'header',
    ])
@endif
