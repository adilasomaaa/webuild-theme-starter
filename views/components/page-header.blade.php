{{--
    Kepala halaman dalam (bukan beranda) dengan breadcrumb.
    Parameter: $title, $subtitle (opsional), $breadcrumbs (opsional: [['label' => '', 'url' => ''], ...])
--}}
<div class="border-b border-slate-200 bg-white">
    <div class="container-page py-10 sm:py-14">
        <nav aria-label="Breadcrumb" class="mb-4 flex flex-wrap items-center gap-1.5 text-sm text-slate-500">
            <a href="{{ route('home') }}" class="hover:text-primary">Beranda</a>
            @foreach(($breadcrumbs ?? []) as $crumb)
                @include('themes.starter.components.icon', ['name' => 'chevron-right', 'class' => 'size-3.5 text-slate-400'])
                @if(! empty($crumb['url']))
                    <a href="{{ $crumb['url'] }}" class="hover:text-primary">{{ $crumb['label'] }}</a>
                @else
                    <span class="text-slate-700">{{ $crumb['label'] }}</span>
                @endif
            @endforeach
        </nav>
        <h1 class="max-w-4xl text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">{{ $title }}</h1>
        @if(filled($subtitle ?? null))
            <p class="mt-3 max-w-3xl text-lg text-slate-600">{{ $subtitle }}</p>
        @endif
    </div>
</div>
