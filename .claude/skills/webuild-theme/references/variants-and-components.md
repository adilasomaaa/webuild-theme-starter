# Variants and Components

## Base variants (required, can't be removed)

| Component | configuration_key | Base options |
| --- | --- | --- |
| `header_logo` | `mode` | `logo_name`, `logo_only`, `name_only` |
| `header_button` | `button_variant` | `primary`, `secondary`, `outline` |
| `contents` | `layout_variant` | `grid`, `list`, `featured_list` |
| `media_gallery` | `layout_variant` | `asymmetric_grid`, `marquee` |
| `agenda` | `timeframe` | `today`, `this_week`, `this_month` |
| `documents` | `layout_variant` | `grid`, `list` |
| `faq` | `layout_orientation` | `vertical`, `horizontal` |
| `slider` | `aspect_ratio` | `21:9`, `16:10`, `4:3`, `16:9` |

Source of truth: `DefaultThemeContract::getBaseVariants()` in theme-kit. If this table disagrees,
follow theme-kit.

Legacy values that must still render: `media_gallery: editorial_grid` → `asymmetric_grid`,
`contents: sorotan` → `featured_list`. Legacy section keys: `gallery_media` → `media_gallery`,
`links` → `pranala`, `contact_info` → `contact`.

## Adding a variant option

1. Add the option under `theme.json → component_variants.<component>.options`:
   ```json
   "magazine": {
       "label": "Majalah",
       "custom": true,
       "description": "One large lead story plus 4 smaller stories in two columns."
   }
   ```
   - `custom: true` marks the option as outside the base contract, so webuild-app needs to review
     and accommodate it.
   - `description` explains the layout to reviewers and admins.
   - Optional: `"view": "sections/main/contents/components/magazine.blade.php"` (relative to
     `views/`). The file must exist if listed.
2. If the component also has a `select` field with the same key in `component_settings`, add the
   same option to its `options`.
3. Render it in the section view. Unknown values must fall back to the default:
   ```php
   $v = $config['layout_variant'] ?? $variant ?? 'grid';
   // ... @if($v === 'magazine') ... @elseif($v === 'list') ... @else (grid) ... @endif
   ```
4. Update the view's header comment: `Varian (config.layout_variant): grid | list | featured_list | magazine.`
5. Log it in `CHANGELOG.md` → `### New variants` → `contents.magazine — <description>`.
6. Test it in the customizer, then run `theme:check`.

Don't create variants for a component that has no `component_variants` entry without discussing it
first. A variant there needs a new `configuration_key`, which has to be agreed with webuild-app.

## Adding component settings

`theme.json → component_settings.<component>.<field>`: requires `type` and `label`. A `select`
requires `options`. Provide a `default`, and always use a fallback when reading it in the view.

## Adding a new component

Use this path only when no existing section could take a variant for the need.

1. Add the key to `theme.json → sections.<area>`.
2. Add a definition under `component_definitions`:
   ```json
   "announcement_bar": {
       "label": "Pengumuman",
       "category": "content",
       "icon": "IconSpeakerphone",
       "data_source": ["static"],
       "default_configuration": { "text": "", "url": "" }
   }
   ```
   `data_source` may only contain: `static`, `news`, `articles`, `gallery`, `agenda`, `documents`,
   `faqs`, `sliders`.
3. Create `views/sections/<area>/<key>/<key>.blade.php` with a header comment (description,
   variants, settings) like the other sections.
4. Log it in `CHANGELOG.md` → `### New components`.
5. Run `theme:check`. All three parts (sections, definition, view) must agree.

## Compatibility across versions

When a theme is updated, Theme Kit compares the old and new manifests. A release is rejected if it
**removes** an existing section or variant option. Adding is always safe; removing never is.
