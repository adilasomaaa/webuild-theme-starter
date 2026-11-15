{{-- Simpul pohon struktur organisasi (rekursif). Parameter: $orgNode, $orgDepth --}}
@php
    $treeHolder = collect(data_get($orgNode, 'activeHolders') ?? data_get($orgNode, 'holders') ?? [])->first();
    $treeChildren = collect(data_get($orgNode, 'children') ?? []);
@endphp
<li>
    <div class="card flex items-center gap-4 p-4 {{ $orgDepth === 0 ? 'border-primary/40 bg-primary/5' : '' }}">
        @if(data_get($treeHolder, 'photo_url'))
            <img src="{{ data_get($treeHolder, 'photo_url') }}" alt="" class="size-12 rounded-full object-cover">
        @else
            <span class="flex size-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">@include('themes.starter.components.icon', ['name' => 'user', 'class' => 'size-5'])</span>
        @endif
        <div class="min-w-0">
            <a href="{{ data_get($orgNode, 'slug') ? route('public.organization-structures.show', data_get($orgNode, 'slug')) : '#' }}" class="font-semibold text-slate-900 hover:text-primary">{{ data_get($orgNode, 'position_name') }}</a>
            @if(data_get($treeHolder, 'name'))
                <p class="text-sm text-slate-600">{{ data_get($treeHolder, 'name') }}</p>
            @endif
        </div>
    </div>
    @if($treeChildren->isNotEmpty())
        <ul class="ml-6 mt-3 space-y-3 border-l-2 border-slate-200 pl-6">
            @foreach($treeChildren as $treeChild)
                @include('themes.starter.components.org-tree-node', ['orgNode' => $treeChild, 'orgDepth' => $orgDepth + 1])
            @endforeach
        </ul>
    @endif
</li>
