{{--
    Video profil (YouTube/Vimeo).
    Pengaturan: title, subtitle, video_embed_url, layout_orientation (vertical|horizontal), aspect_ratio (16:9|4:3|21:9|1:1).
--}}
@php
    $videoUrl = $config['video_embed_url'] ?? '';
    if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([\w-]{11})/', $videoUrl, $videoMatch)) {
        $videoUrl = "https://www.youtube.com/embed/{$videoMatch[1]}?rel=0";
    } elseif (preg_match('/vimeo\.com\/(\d+)/', $videoUrl, $videoMatch)) {
        $videoUrl = "https://player.vimeo.com/video/{$videoMatch[1]}";
    }
    $videoAspect = match ($config['aspect_ratio'] ?? '16:9') {
        '4:3' => 'aspect-[4/3]',
        '21:9' => 'aspect-[21/9]',
        '1:1' => 'aspect-square',
        default => 'aspect-video',
    };
    $videoHorizontal = ($config['layout_orientation'] ?? 'vertical') === 'horizontal';
    $videoTitle = $config['title'] ?? 'Video Profil';
    $videoSubtitle = $config['subtitle'] ?? 'Mengenal lebih dekat layanan dan program kerja kami.';
@endphp
<section class="section section-muted" data-section-type="profile_video">
    <div class="container-page {{ $videoHorizontal ? 'grid items-center gap-10 lg:grid-cols-2' : '' }}">
        @include('themes.starter.components.section-heading', ['title' => $videoTitle, 'subtitle' => $videoSubtitle, 'headingAlign' => $videoHorizontal ? 'left' : 'center'])
        <div class="{{ $videoHorizontal ? '' : 'mx-auto max-w-4xl' }}">
            @if($videoUrl)
                <div class="{{ $videoAspect }} overflow-hidden rounded-2xl bg-slate-900 shadow-lg">
                    <iframe src="{{ $videoUrl }}" title="{{ $videoTitle }}" class="size-full" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            @else
                @include('themes.starter.components.empty-state', ['emptyMessage' => 'Atur URL video pada pengaturan komponen.', 'emptyIcon' => 'play'])
            @endif
        </div>
    </div>
</section>
