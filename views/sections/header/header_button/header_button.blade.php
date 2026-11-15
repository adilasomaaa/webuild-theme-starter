{{-- Tombol aksi di header. Pengaturan: button_text, button_url, button_variant (primary|secondary|outline) --}}
@php
    $headerButtonText = $config['button_text'] ?? 'Hubungi Kami';
    $headerButtonUrl = $config['button_url'] ?? route('public.guestbook.index');
    $headerButtonClass = match ($config['button_variant'] ?? 'primary') {
        'secondary' => 'btn-secondary',
        'outline' => 'btn-outline',
        default => 'btn-primary',
    };
@endphp
<a href="{{ $headerButtonUrl }}" target="{{ ! empty($config['target']) ? $config['target'] : '_self' }}" class="btn btn-sm {{ $headerButtonClass }} hidden sm:inline-flex">
    {{ $headerButtonText }}
</a>
