# Theme Colors

The site admin picks colors in webuild-app. The theme's job is to make **everything** follow that
choice, including when the chosen color is very light or very dark.

## Token flow

```
theme.json → settings_schema.primary_color (default)
        ↓ admin changes it in webuild-app
views/layouts/public.blade.php → --theme-primary: {{ $primaryColor }}
        ↓
resources/theme.css @theme → --color-primary: var(--theme-primary, <fallback>)
        ↓
Tailwind classes: bg-primary, text-primary, border-primary/20, from-primary, ring-primary/30
```

Available tokens: `primary`, `secondary`, `accent`.

## "I want this theme to feel blue"

Don't write `bg-blue-700`. Change the default:

```json
"primary_color": { "type": "color", "default": "#1d4ed8", "label": "Warna Utama" }
```

Right now the default lives in **three places**, and all three must match:
1. `theme.json → settings_schema.<color>.default`
2. `views/layouts/public.blade.php` → `$themeTokens['primary_color'] ?? '<hex>'`
3. `resources/theme.css` → `var(--theme-primary, <hex>)`

## Need another color (e.g. a navy footer background)

Don't hardcode it. Make it configurable:
1. Add a field to `settings_schema`:
   `"footer_background": { "type": "color", "default": "#0f172a", "label": "Latar Footer" }`
2. In `public.blade.php`, read `$themeTokens['footer_background'] ?? '#0f172a'` and output it as
   `--theme-footer-background` in the same `:root` block as the other colors.
3. In `theme.css @theme`, add `--color-footer: var(--theme-footer-background, #0f172a);`
4. Use it as `bg-footer`.

## Allowed and not allowed

| Case | Status |
| --- | --- |
| Tokens (`bg-primary`, `text-secondary/80`, `from-primary to-accent`) | ✅ |
| Neutrals (`slate-*`, `gray-*`, `white`, `black`) for text, borders, backgrounds | ✅ |
| Hex inside the `@theme` block (`theme.css`) and fallbacks in `public.blade.php` | ✅ |
| Mapping a **user choice** to CSS, e.g. hero gradient presets (`ocean`, `sunset`) picked by the admin. Mark the block with `// theme-check:color-preset` or `{{-- theme-check:color-preset --}}` | ✅ |
| Status colors (success/error/warning) in flash messages or booking status: `emerald`, `red`, `amber`, `sky`, **for status meaning only** | ✅ for now |
| `bg-blue-600`, `text-indigo-700`, `#1d4ed8`, `style="color: ..."` for theme identity or decoration | ❌ |
| The `color-preset` marker on colors the user did **not** pick (e.g. header color) | ❌ |

Find violations:
```bash
grep -rnE "#[0-9a-fA-F]{3,8}\b|\b(bg|text|border|from|to|via|ring|fill|stroke|outline|shadow|decoration)-(red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose)-[0-9]{2,3}" views
```
Every hit must fall under one of the ✅ rows above.

## Contrast

The admin picks the color, so the theme can't assume the primary color is always dark.
- Text on `bg-primary`: test with light colors (`#facc15`, `#a3e635`). If it's unreadable, compute
  luminance in PHP (example in `sections/main/hero/hero.blade.php`) and pick dark or light text.
- For soft backgrounds, prefer token opacity (`bg-primary/10`) over a new hex.
- Test in the customizer with three colors: light (`#facc15`), dark (`#0f172a`), high saturation (`#e11d48`).
