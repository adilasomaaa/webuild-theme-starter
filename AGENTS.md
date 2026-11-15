# AGENTS.md — Webuild Theme

This repo is a public-portal theme for **Webuild**, built with Laravel Blade + Tailwind CSS 4.
It plugs into webuild-app through Theme Kit (`webuild/theme-kit`). Webuild-app owns the data and
settings; the theme only renders them.

Step-by-step workflows, the design system and anti-slop rules live in the **`webuild-theme`** skill.
Install it with `npx skills add adilasomaaa/webuild-skills` (Claude Code: `.claude/skills/`,
Codex/Antigravity/Cursor: `.agents/skills/`). The full component and variant inventory is in
`docs/guide/pembuatan-tema/02-inventaris-komponen.md`; the human guide starts at
`docs/guide/pembuatan-tema/README.md`.

## Commands

```bash
composer install && npm install
npm run dev                        # rebuild CSS/JS on change
php artisan serve                  # workbench + customizer at http://localhost:8000
npm run build                      # required before committing; dist/ is committed
php artisan theme:check --render   # must pass before commit/release
```

## Hard rules

1. **Every page and section file must exist.** The list lives in `theme.json → sections` and
   `views/pages/`. Do not delete or rename files. If a section doesn't fit the design, still ship
   a simple rendering. `theme:check` rejects incomplete themes.
2. **Every variant option must render; base variants can't be removed.** Support every option in
   the inventory, including fixed ones like `profile_video.layout_orientation`. Base variants in
   `component_variants` (e.g. `contents: grid | list | featured_list`) keep their options and
   `configuration_key`; themes may only **add** options (see rule 5).
3. **Don't hardcode brand colors.** Use tokens: `bg-primary`, `text-secondary`, `border-accent/20`,
   `from-primary to-secondary`. A class like `bg-blue-700` or a hex like `#1d4ed8` in a view means an
   institution that picks green still gets blue. Want a blue theme? Change the `default` in
   `theme.json → settings_schema`. Details: skill `webuild-theme`, `references/colors.md`.
4. **Don't change the data contract.** Variable names, config keys and route names come from
   webuild-app. Read them; never rename them. Always provide a fallback
   (`$config['title'] ?? '...'`) and render `empty-state` when data is empty.
5. **Additions follow the contract:**
   - Extra option for a base variant (`header_logo`, `header_button`, `contents`, `media_gallery`,
     `agenda`, `documents`, `faq`, `slider`): add it to `component_variants` with `label` and
     `description`. webuild-app shows it automatically.
   - New option for a fixed variant, or a new data field: a **proposal**. Don't implement it; log it.
   - New component: `component_definitions` + `sections` + a view file.
   - Log everything in `CHANGELOG.md` under **New variants** / **New components** / **Proposals**.
6. **Unknown values fall back to the default.** An unrecognized variant or option must not error
   or render blank. Legacy values (`media_gallery: editorial_grid`, `contents: sorotan`) must keep working.
7. **Escape output.** Use `{{ }}`. Use `{!! !!}` only for editor HTML (wrap it in `prose-content`)
   or components that are meant to embed.
8. **No dummy data, no new variables.** Use only the variables listed in the file header, `$config`
   keys registered in `theme.json`, and fields present in `demo/data.json`. If a design needs data
   that doesn't exist, report it — don't invent it.
9. **Study before changing, then follow the design system.** Read the target file, the components
   it includes, and one similar file before editing. Typography, spacing, UI elements and responsive
   behavior follow the `webuild-theme` skill (`references/design-system.md`). Avoid the patterns in
   its `references/anti-slop.md`.

## Where to look

| Question | Look at |
| --- | --- |
| Which variants/options must a component support? | `docs/guide/pembuatan-tema/02-inventaris-komponen.md` |
| What variables does this section/page get? | The `{{-- --}}` comment at the top of that file |
| Real data shapes | `demo/data.json` (news, articles, gallery, agenda, documents, faqs, sliders, pages, links, social_media, organization_structures) |
| Globals available in every view | `application`, `profile`, `seo`, `layoutSections`, `themeConfig`, `siteDisplayName`, `primaryColor`, `secondaryColor`, `accentColor` |
| Variables every section gets | `$config` (merged configuration), `$variant`, `$inHeader`, `$inFooter`, plus all parent page variables |
| Available CSS classes | `resources/theme.css` and the table in `README.md` |
| Reusable Blade components | `views/components/` and the parameter table in `README.md` |

## Structure

```
theme.json                                      Manifest: key, settings_schema (colors), sections, variants, settings
views/layouts/                                  public (head + color tokens), header, footer
views/pages/{group}/{name}.blade.php            Required pages
views/sections/{area}/{type}/{type}.blade.php   Layout-builder sections (area: header|main|footer)
views/components/                               Reusable partials
resources/theme.css, theme.js                   Asset sources → dist/ (build output, committed)
demo/data.json                                  Workbench sample data
```

## Before calling the work done

- [ ] `npm run build` and `php artisan theme:check --render` pass with no errors.
- [ ] Changed pages checked in the workbench with full data **and** empty data.
- [ ] Tried a light primary color (e.g. `#facc15`) and a dark one (e.g. `#0f172a`) in the
      customizer; text stays readable.
- [ ] Anything beyond the base contract is flagged and logged in `CHANGELOG.md`.
