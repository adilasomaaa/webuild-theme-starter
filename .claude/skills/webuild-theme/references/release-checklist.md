# Release Checklist

1. **Version:** bump `theme.json → version` (semver). Patch for fixes, minor for new variants or
   components, major for large visual changes. Don't raise `api_version` beyond what Theme Kit
   supports (currently `1.1`).
2. **CHANGELOG.md:** move `[Unreleased]` into the new version with a date. Make sure **New variants**
   and **New components** are complete.
3. **Build:** run `npm run build` and commit `dist/`.
4. **Validate:** `php artisan theme:check --render` passes with no errors.
5. **Manual check in the workbench:**
   - Home with every section enabled, then home with most sections disabled.
   - Every list page with empty data.
   - Every variant of every component, including custom variants.
   - Three test colors: `#facc15`, `#0f172a`, `#e11d48`.
   - Phone width (≈375px) and desktop.
6. **Colors:** run the grep in `colors.md`. Every hit needs a legitimate reason.
7. **Design:** run the checks in `anti-slop.md` on files changed since the last release.
8. **Nothing removed:** confirm no `sections` entry or variant option disappeared compared with the
   previous release:
   ```bash
   git diff <previous-tag> -- theme.json
   ```
