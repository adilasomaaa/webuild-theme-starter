<?php

namespace Webuild\Themes\Starter;

use Illuminate\Support\ServiceProvider;
use Webuild\ThemeKit\ThemeRegistry;

class ThemeServiceProvider extends ServiceProvider
{
    public function boot(ThemeRegistry $registry): void
    {
        $manifest = json_decode(file_get_contents(__DIR__ . '/../theme.json'), true) ?: [];
        $registry->register('starter', dirname(__DIR__), $manifest);
    }
}