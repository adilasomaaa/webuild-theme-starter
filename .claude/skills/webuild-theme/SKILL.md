---
name: webuild-theme
description: Guide and workflows for developing Webuild public-portal themes (Laravel Blade + Tailwind 4) from theme-starter, including design quality standards (anti-slop, typography, spacing, UI elements, responsive). Use whenever touching views, CSS or theme.json in a Webuild theme repo — creating a new theme, renaming the theme key, turning a design/mockup/Figma into a theme, beautifying or redesigning a section/page/header/footer, fixing mobile layout, tidying typography or spacing, adding variants or components, setting theme colors, or preparing a release. Also for questions like "what variables does this section get", "can I remove section X", or "why does it look broken on mobile", even if the user never says "theme".
---

# Developing a Webuild Theme

The hard rules are in `AGENTS.md` (repo root). This skill is how to work so the theme is both
**correct** (matches the webuild-app contract) and **good** (clean, consistent, easy for citizens to use).

## Principles

1. **Webuild-app owns data and settings; the theme owns presentation.** The theme renders what it
   is given. It doesn't invent data and doesn't lock in choices that belong to the site admin
   (colors, variants, copy).
2. **Study first, then change.** Almost every bad result comes from writing a fresh design without
   looking at the existing system: duplicated classes, wrong variables, mismatched styles.
3. **One system, not many local decisions.** Typography, spacing, radius and buttons follow the same
   scale across the whole theme. A theme gets its identity by changing the system, not by writing
   different values in every file.

## Step 0 — Orientation (required before changing code)

Do this every time you are about to change a view or CSS, even for small changes.

1. Read `AGENTS.md`, then the parts of `theme.json` relevant to the target: `sections`,
   `component_variants.<component>`, and `component_settings.<component>`.
2. Read `references/design-system.md` and `references/anti-slop.md` if you haven't in this session.
3. Read the **whole** target file, including its header comment (the variable contract), and every
   component it `@include`s.
4. Read one or two similar files as a pattern reference. E.g. before changing `documents`, look at
   `contents`; before building a list page, look at `pages/content/content.blade.php`.
5. Find the real data shape in `demo/data.json` for the content type being rendered.
6. Write a short brief to the user before editing:
   - **Data:** variables and fields available to this block, and where they come from.
   - **Reuse:** classes and components you will use.
   - **Structure:** this block's heading level on the page (`h1`/`h2`/`h3`).
   - **Responsive:** behavior on mobile, in a narrow column, and in header/footer.
   - **Gaps:** design needs the existing data can't satisfy (see Data rules).

The brief is evidence the orientation happened, and it gives the user a chance to correct course
before code changes.

## Data rules — no dummy data, no new variables

This theme is installed for many institutions with real data. Invented data in a view shows up on
an official government site as false information, and a key webuild-app doesn't send will never be filled.

**Use only:**
- variables and fields listed in the file's header comment,
- globals (`application`, `profile`, `seo`, `layoutSections`, `themeConfig`, `siteDisplayName`, `primaryColor`, `secondaryColor`, `accentColor`),
- `$config` keys registered in `theme.json → component_settings` or the section header,
- fields visible in `demo/data.json`.

**Don't:**
- build content arrays in a view (services, stats, testimonials, contacts, schedules),
- write lorem ipsum, sample phone numbers or addresses, or external image URLs,
- read `$config` keys or data fields that aren't in the sources above,
- add fields to `demo/data.json` to make a design look like it works.

**Allowed:**
- short fallback labels following the existing pattern (`$config['title'] ?? 'Berita & Informasi Terbaru'`),
- local `@php` variables that transform existing data (date formatting, filtering, picking classes).
  Prefix them with the section name (`$contentsItems`, `$heroTitle`): `@include` inherits the parent
  view's variables, so generic names like `$items` can collide.

**When optional data is empty**, hide the element with `@if(filled(...))` instead of showing
placeholder text. **When a design needs data that doesn't exist**, don't invent it. Stop that part
and report it to the user, e.g.: *"This design needs `service_stats`, but webuild-app doesn't send
that field. It needs to be requested as a new field, or the block should be dropped."*

## Design standards

Full detail in `references/design-system.md`. In short:

- **Typography:** one `h1` per page, sections `h2`, content `h3`, no skipped levels. Only four font
  weights (normal, medium, semibold, bold); `leading-tight` for large headings, `leading-relaxed` for
  reading text.
- **Spacing:** `section` and `container-page` for the frame; the defined `gap`/`p` scale; no
  arbitrary px values.
- **UI elements:** `btn-*`, `card`, `badge`, `form-*`, and the existing Blade components. One primary
  button per block. Radius and shadows follow the table.
- **Responsive:** mobile first, grids gain columns per breakpoint, no horizontal scroll at 375px,
  still tidy in narrow columns and the footer.
- **Anti-slop:** no decorative gradients, glassmorphism, emoji, made-up numbers or excessive
  animation. See `references/anti-slop.md`.

## Workflows

Start every workflow with **Step 0** and finish with **Verification**.

### Workflow 1 — Starting a new theme from the starter

1. Pick a theme key (lowercase slug, e.g. `kabupaten-hijau`).
2. Replace every `starter` reference with the new key. About 80 files reference it:
   ```bash
   grep -rln "starter" theme.json composer.json src views resources
   ```
   Replace: `theme.json → key/name`, `themes.starter.` in views, `@themeAssets('starter')`,
   `resolveSection('starter', ...)`, `$registry->register('starter', ...)` in `src/ThemeServiceProvider.php`,
   and the `name` and PSR-4 namespace in `composer.json`. Check before replacing "starter" where it is plain text.
3. Set identity at the system level: default colors (`references/colors.md`), font (`--font-sans`
   in `@theme`), radius and shadows (classes in `@layer components`).
4. Run `composer dump-autoload`.

### Workflow 2 — Changing or beautifying a section/page

1. Sections receive `$config`, `$variant`, `$inHeader`, `$inFooter`, plus all page variables. Read
   the variant with the starter's pattern:
   `$x = $config['<configuration_key>'] ?? $variant ?? '<default>';`
2. Handle every state: full data, empty data (`empty-state`), a single item, a very long title, a
   missing image, a narrow column (`$config['col_span'] < 12`), and header/footer placement.
3. Use existing classes and components. Add a new class to `theme.css` only when the pattern repeats
   in three or more places.
4. If the variables a file reads change, update its header comment.

### Workflow 3 — Turning a design/mockup into a theme

1. Extract the **system** from the design, not per-element values: brand colors → `settings_schema`,
   font → `--font-sans`, radius/shadows/buttons → `@layer components`. If the design uses five
   different radii, pick the dominant one and map it onto the radius table.
2. Map every block in the design to a section in `theme.json → sections`. A block with no match is
   a candidate new component (Workflow 4) or a data gap. Don't hardcode it into a page.
3. Content in the mockup (copy, numbers, photos) is **sample content**. Replace it with the matching
   variables. Mockup content that has no data source is reported as a gap, not copied.
4. Sections that don't appear in the design are **still required**. Style them to match.
5. Work in stages: layout (header/footer), then home, then list pages, then detail pages. Verify at each stage.

### Workflow 4 — Adding a variant or component

Follow `references/variants-and-components.md`. Additions are fine as long as they're flagged
(`"custom": true` + `description`), logged in `CHANGELOG.md`, and base options stay untouched.

### Workflow 5 — Colors

Follow `references/colors.md`.

### Workflow 6 — Preparing a release

Follow `references/release-checklist.md`.

## Verification (required at the end of every workflow)

```bash
npm run build
php artisan theme:check --render
```

Then:
1. Run the grep checks in `references/anti-slop.md` on the changed files.
2. Re-check the tables in `references/design-system.md` against the new code: headings, weights,
   spacing, radius.
3. Open `php artisan serve` and check the changed pages at 375px and 1280px. Use the customizer
   (gear button) to switch variants, colors and column placement.

Don't call it done while `theme:check` has errors. Report warnings (⚠️) and data gaps to the user
instead of silently ignoring them. If you can't open a browser, say the visual check wasn't done.

## Don'ts

- Delete or rename files in `views/pages/` or `views/sections/`, or remove entries from `theme.json → sections`.
- Remove base variant options or change their `configuration_key`.
- Rename variables/config keys that come from webuild-app, or read keys that don't exist.
- Invented data in views or in `demo/data.json`.
- Hex values or colored palette classes (`blue-*`, `emerald-*`, etc.) for brand colors in views.
- Edit `dist/` by hand. Always generate it with `npm run build`.
- Touch `theme-kit/workbench/` or vendor. The customizer is not part of the theme.
