{{--
    Kartu jabatan/pejabat struktur organisasi.
    Parameter: $orgNode (position_name, slug, is_leader, activeHolders|holders), opsional $orgShowHolder, $orgShowContact
--}}
@php
    $orgHolder = ($orgShowHolder ?? true) ? collect(data_get($orgNode, 'activeHolders') ?? data_get($orgNode, 'holders') ?? [])->first() : null;
    $orgHolderName = data_get($orgHolder, 'name');
    $orgDetailUrl = data_get($orgNode, 'slug') ? route('public.organization-structures.show', data_get($orgNode, 'slug')) : null;
@endphp
<article class="card overflow-hidden text-center">
    <div class="aspect-[4/5] bg-linear-to-b from-primary/10 to-slate-100">
        @if(data_get($orgHolder, 'photo_url'))
            <img src="{{ data_get($orgHolder, 'photo_url') }}" alt="Foto {{ $orgHolderName }}" class="size-full object-cover object-top" loading="lazy">
        @else
            <span class="flex size-full items-center justify-center text-primary/40">
                @include('themes.starter.components.icon', ['name' => 'user', 'class' => 'size-16'])
            </span>
        @endif
    </div>
    <div class="p-4">
        @if(data_get($orgNode, 'is_leader'))
            <span class="badge mb-2">Pimpinan</span>
        @endif
        <h3 class="font-semibold text-slate-900">
            @if($orgDetailUrl)
                <a href="{{ $orgDetailUrl }}" class="hover:text-primary">{{ $orgHolderName ?? data_get($orgNode, 'position_name') }}</a>
            @else
                {{ $orgHolderName ?? data_get($orgNode, 'position_name') }}
            @endif
        </h3>
        @if($orgHolderName)
            <p class="mt-1 text-sm text-slate-600">{{ data_get($orgNode, 'position_name') }}</p>
        @endif
        @if(($orgShowContact ?? false) && data_get($orgHolder, 'contact'))
            <p class="mt-2 text-xs text-slate-500">{{ data_get($orgHolder, 'contact') }}</p>
        @endif
    </div>
</article>
