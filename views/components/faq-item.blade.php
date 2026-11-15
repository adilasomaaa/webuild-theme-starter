{{-- Satu butir FAQ (akordeon <details>). Parameter: $faqItem (question, answer), opsional $faqOpen --}}
<details class="card group p-0" @if($faqOpen ?? false) open @endif>
    <summary class="flex items-center justify-between gap-4 p-5 font-medium text-slate-900">
        {{ data_get($faqItem, 'question') }}
        <span class="flex size-7 shrink-0 items-center justify-center rounded-full bg-slate-100 text-slate-500 transition group-open:rotate-180 group-open:bg-primary group-open:text-white">
            @include('themes.starter.components.icon', ['name' => 'chevron-down', 'class' => 'size-4'])
        </span>
    </summary>
    <div class="prose-content border-t border-slate-100 px-5 pb-5 pt-4 text-sm">{!! data_get($faqItem, 'answer') !!}</div>
</details>
