{{-- Pesan sukses/galat setelah mengirim formulir. --}}
@if(session('success') || session('status'))
    <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800" role="status">
        @include('themes.starter.components.icon', ['name' => 'check-circle', 'class' => 'size-5'])
        <p>{{ session('success') ?? session('status') }}</p>
    </div>
@endif
@if(isset($errors) && $errors->any())
    <div class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800" role="alert">
        @include('themes.starter.components.icon', ['name' => 'alert', 'class' => 'size-5'])
        <ul class="space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
