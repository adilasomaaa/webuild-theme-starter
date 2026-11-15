{{--
    Komentar publik untuk konten/halaman.
    Variabel: $comments (author_name, body, created_at, approvedReplies), $commentable (model yang dikomentari),
    $commentableType ('content'|'page'|'document'|'dynamic-content').
--}}
@php
    $commentTarget = $commentable ?? $content ?? $page ?? null;
    $commentType = $commentableType ?? (isset($content) ? 'content' : 'page');
    $commentList = collect($comments ?? []);
    $commentEnabled = (bool) data_get($commentTarget, 'comments_enabled', true);
@endphp
<section class="mt-12 border-t border-slate-200 pt-10" id="komentar" data-section-type="comments">
    <h2 class="text-xl font-bold text-slate-900">Komentar ({{ $commentList->count() }})</h2>

    <div class="mt-6 space-y-5">
        @forelse($commentList as $comment)
            <div class="flex gap-3">
                <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-primary/10 font-semibold text-primary">{{ mb_strtoupper(mb_substr((string) data_get($comment, 'author_name', '?'), 0, 1)) }}</span>
                <div class="flex-1">
                    <p class="text-sm"><span class="font-semibold text-slate-900">{{ data_get($comment, 'author_name') }}</span>
                        @if(data_get($comment, 'created_at'))<span class="text-slate-400"> · {{ \Illuminate\Support\Carbon::parse(data_get($comment, 'created_at'))->locale('id')->diffForHumans() }}</span>@endif
                    </p>
                    <p class="mt-1 text-sm text-slate-700">{{ data_get($comment, 'body') }}</p>
                    @foreach(data_get($comment, 'approvedReplies') ?? [] as $reply)
                        <div class="mt-3 rounded-xl bg-slate-50 p-3 text-sm">
                            <p class="font-semibold text-slate-900">{{ data_get($reply, 'author_name') }} @if(data_get($reply, 'is_admin'))<span class="badge ml-1">Admin</span>@endif</p>
                            <p class="mt-1 text-slate-700">{{ data_get($reply, 'body') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-sm text-slate-500">Belum ada komentar. Jadilah yang pertama memberi tanggapan.</p>
        @endforelse
    </div>

    @if($commentEnabled && data_get($commentTarget, 'id'))
        <form action="{{ route('public.comments.store', ['type' => $commentType, 'id' => data_get($commentTarget, 'id')]) }}" method="POST" class="card mt-8 space-y-4 p-6">
            @csrf
            <h3 class="font-semibold text-slate-900">Tulis komentar</h3>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="author_name" class="form-label">Nama</label>
                    <input id="author_name" name="author_name" value="{{ old('author_name') }}" required minlength="2" maxlength="100" class="form-input">
                    @error('author_name')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="author_email" class="form-label">Email <span class="font-normal text-slate-400">(tidak dipublikasikan)</span></label>
                    <input id="author_email" type="email" name="author_email" value="{{ old('author_email') }}" required class="form-input">
                    @error('author_email')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label for="body" class="form-label">Komentar</label>
                <textarea id="body" name="body" rows="4" required minlength="3" maxlength="2000" class="form-input">{{ old('body') }}</textarea>
                @error('body')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="btn btn-primary">Kirim Komentar</button>
        </form>
    @endif
</section>
