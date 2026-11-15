{{--
    Pimpinan & struktur organisasi dari $organizationStructures (position_name, slug, is_leader, activeHolders/holders).
    Pengaturan: title, subtitle, show_holders, show_contact, limit.
--}}
@php
    $orgNodes = collect(($organizationStructures ?? null) instanceof \Illuminate\Contracts\Pagination\Paginator ? $organizationStructures->items() : ($organizationStructures ?? []))->take((int) ($config['limit'] ?? 8))->values();
    $orgShowHolders = (bool) ($config['show_holders'] ?? true);
@endphp
<section class="section" data-section-type="organization_structure">
    <div class="container-page">
        @include('themes.starter.components.section-heading', [
            'title' => $config['title'] ?? 'Struktur Organisasi',
            'subtitle' => $config['subtitle'] ?? 'Pimpinan dan pejabat yang mengoordinasikan layanan instansi.',
            'headingActionText' => 'Lihat struktur lengkap',
            'headingActionUrl' => route('public.organization-structures.index'),
        ])
        @if($orgNodes->isEmpty())
            @include('themes.starter.components.empty-state', ['emptyMessage' => 'Struktur organisasi belum diisi.', 'emptyIcon' => 'users'])
        @else
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($orgNodes as $orgNode)
                    @include('themes.starter.components.person-card', ['orgNode' => $orgNode, 'orgShowHolder' => $orgShowHolders, 'orgShowContact' => (bool) ($config['show_contact'] ?? false)])
                @endforeach
            </div>
        @endif
    </div>
</section>
