{{--
    Informasi kontak instansi dari $profile.
    Pengaturan: title, subtitle, button_text. Saat ditempatkan di footer ($inFooter) tampil sebagai daftar ringkas.
--}}
@php
    $contactAddress = data_get($address ?? null, 'full_address') ?: data_get($profile ?? null, 'address');
    $contactItems = collect([
        ['icon' => 'map-pin', 'label' => 'Alamat', 'value' => $contactAddress, 'href' => $contactAddress ? 'https://maps.google.com/?q=' . urlencode($contactAddress) : null],
        ['icon' => 'phone', 'label' => 'Telepon', 'value' => data_get($profile ?? null, 'phone'), 'href' => 'tel:' . preg_replace('/[^0-9+]/', '', (string) data_get($profile ?? null, 'phone'))],
        ['icon' => 'mail', 'label' => 'Email', 'value' => data_get($profile ?? null, 'email'), 'href' => 'mailto:' . data_get($profile ?? null, 'email')],
    ])->filter(fn ($item) => filled($item['value']));
    $contactTitle = $config['title'] ?? 'Hubungi Kami';
@endphp
@if($inFooter ?? false)
    <div>
        <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-white">{{ $contactTitle }}</h2>
        <ul class="space-y-3">
            @foreach($contactItems as $contactItem)
                <li class="flex gap-2.5">
                    @include('themes.starter.components.icon', ['name' => $contactItem['icon'], 'class' => 'mt-0.5 size-4 text-primary'])
                    <a href="{{ $contactItem['href'] }}" class="hover:text-white">{{ $contactItem['value'] }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@else
    <section class="section" data-section-type="contact" id="kontak">
        <div class="container-page">
            @include('themes.starter.components.section-heading', [
                'title' => $contactTitle,
                'subtitle' => $config['subtitle'] ?? 'Kami siap membantu kebutuhan informasi dan layanan Anda.',
                'headingAlign' => 'center',
            ])
            <div class="grid gap-5 md:grid-cols-3">
                @forelse($contactItems as $contactItem)
                    <a href="{{ $contactItem['href'] }}" class="card card-hover flex flex-col items-center p-6 text-center" @if($contactItem['icon'] === 'map-pin') target="_blank" rel="noopener" @endif>
                        <span class="mb-4 flex size-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                            @include('themes.starter.components.icon', ['name' => $contactItem['icon'], 'class' => 'size-5'])
                        </span>
                        <p class="text-sm font-semibold text-slate-900">{{ $contactItem['label'] }}</p>
                        <p class="mt-1 text-sm text-slate-600">{{ $contactItem['value'] }}</p>
                    </a>
                @empty
                    <div class="md:col-span-3">
                        @include('themes.starter.components.empty-state', ['emptyMessage' => 'Lengkapi profil instansi untuk menampilkan kontak.', 'emptyIcon' => 'phone'])
                    </div>
                @endforelse
            </div>
            @if(! empty($config['button_text']))
                <div class="mt-8 text-center">
                    <a href="{{ route('public.guestbook.index') }}" class="btn btn-primary">{{ $config['button_text'] }}</a>
                </div>
            @endif
        </div>
    </section>
@endif
