{{--
    Tampilan saat data kosong.
    Parameter: $emptyMessage, $emptyIcon (opsional)
--}}
<div class="flex flex-col items-center justify-center rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center">
    <span class="mb-3 flex size-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
        @include('themes.starter.components.icon', ['name' => $emptyIcon ?? 'info', 'class' => 'size-6'])
    </span>
    <p class="text-sm text-slate-500">{{ $emptyMessage ?? 'Belum ada data untuk ditampilkan.' }}</p>
</div>
