# Theme Design System

This reference is derived from the starter's most consistent components:
`components/section-heading`, `components/page-header`, `components/content-card`, and the classes in
`resources/theme.css`. Some older starter views don't fully follow it yet. New code and code you are
changing should follow it; don't tidy unrelated files nobody asked about.

A theme can have its own identity (font, radius, shadow depth). Do that by changing the **system**
in one place (tokens in `@theme`, classes in `@layer components`), not by writing different values in
each view. Consistency matters more than any particular value.

## Contents
1. Typography
2. Spacing
3. UI elements
4. Responsive

---

## 1. Typography

### Heading hierarchy

Heading tags express **structure**; visual size comes from classes. Screen readers and search engines
read the tags, so choose a tag by its position on the page, not by the size you want.

- **One `h1` per page.** On the home page it's the hero title; on inner pages it's in `page-header`.
  Sections and cards never use `h1`.
- **Sections use `h2`**, preferably through `components/section-heading`.
- **Section contents (cards, items, panels) use `h3`**, and `h4` below that.
- **Don't skip levels** (e.g. `h2` straight to `h4`).
- Footer column labels are still `h2` structurally, but rendered small (see table).

### Scale

| Role | Tag | Classes |
| --- | --- | --- |
| Hero title | `h1` | `text-4xl sm:text-5xl font-bold tracking-tight leading-tight` (size follows `text_size`) |
| Page title | `h1` | `text-3xl sm:text-4xl font-bold tracking-tight leading-tight` |
| Section title | `h2` | `text-2xl sm:text-3xl font-bold tracking-tight` |
| Block title (sidebar, panel, sub-section) | `h2`/`h3` | `text-lg font-semibold` |
| Card title | `h3` | `text-lg font-semibold leading-snug` (small card: `text-base`, compact: `text-sm`) |
| Footer/header column label | `h2` | `text-sm font-semibold uppercase tracking-wider` |
| Page lead | `p` | `text-lg text-slate-600` |
| Section subtitle | `p` | `text-slate-600` (`text-base`) |
| Body text | `p` | `text-base leading-relaxed text-slate-700` |
| Meta (date, category, count) | | `text-sm text-slate-500` |
| Small caption | | `text-xs text-slate-500` |
| Editor HTML | | wrap in `prose-content`; don't restyle tags inside it |

### Font weight

Use only four weights, each with a role:

| Class | Used for |
| --- | --- |
| `font-normal` | Body text (default, no need to write it) |
| `font-medium` | Form labels, nav links, badges, text that needs slight emphasis |
| `font-semibold` | `h3` and below, card titles, buttons, column labels |
| `font-bold` | `h1` and `h2` only |

`font-light`, `font-thin`, `font-extrabold` and `font-black` aren't used. Weight is not decoration:
when everything is bold, nothing stands out.

### Line height and line length

- Large headings (`text-3xl` and up): `leading-tight`. Default line height is too loose for big text.
- Card titles that can wrap to two lines: `leading-snug`, plus `line-clamp-2` when title length is uncontrolled.
- Reading text longer than one paragraph: `leading-relaxed`.
- Single-line UI (buttons, badges, meta): leave the default.
- Limit reading width: `max-w-2xl` for subtitles, `max-w-3xl` for article bodies. Overly long lines tire the eye.

### Text color

`text-slate-900` for headings, `text-slate-700` for body, `text-slate-600` for subtitles/leads, and
`text-slate-500` for meta. Don't use `text-slate-400` or lighter for text people need to read; it
fails WCAG AA contrast. Those shades are for icons and placeholders only.

---

## 2. Spacing

Tailwind's 4px scale. Use only these steps: `1, 1.5, 2, 3, 4, 5, 6, 8, 10, 12, 16`.
Avoid arbitrary values like `p-[13px]` or `mt-[22px]`. Arbitrary values are only for aspect ratios
(`aspect-[4/3]`) and hero heights driven by settings.

| Role | Value |
| --- | --- |
| Section vertical rhythm | `section` class (`py-12 sm:py-16`). Don't write your own `py-*` on `<section>` |
| Alternating section background | `section section-muted` |
| Width and horizontal padding | `container-page` class. Don't write `max-w-7xl px-4` yourself |
| Page header | `page-header` (`py-10 sm:py-14`) |
| Section heading → content | handled by `section-heading` (`mb-8`) |
| Card grid | `gap-6` |
| Stacked list items | `gap-4`, or `divide-y` with `py-4` per item |
| Inline elements (badges, meta, side-by-side buttons) | `gap-2`, or `gap-3` for buttons |
| Icon + text | `gap-1.5` or `gap-2` |
| Content + sidebar layout | `gap-10` |
| Card padding | `p-5` (standard), `p-6` (large/featured card), `p-4` (small card) |
| Title → meta/text below it | `mt-1` to `mt-2` |
| Text block → action button | `mt-6` |

Spacing expresses relatedness: related elements sit close, separate groups get more room. When every
gap is the same, grouping disappears.

---

## 3. UI elements

Use what exists before creating something new. If a utility combination is used in three or more
places, make it a class in `@layer components` (`resources/theme.css`) and add it to the table in
`README.md`. Don't copy long utility strings across files.

| Element | Use | Notes |
| --- | --- | --- |
| Button | `btn` + `btn-primary` / `btn-outline` / `btn-ghost` / `btn-light` / `btn-secondary`, sizes `btn-sm` / `btn-lg` | At most **one** `btn-primary` per block; other actions use `btn-outline` or `btn-ghost` |
| Text link | `link` | |
| Card | `card`, plus `card-hover` when the whole card is clickable | No cards inside cards |
| Label | `badge`, `badge-muted` | Only for real data (category, status) |
| Form | `form-label`, `form-input`, `form-error` | Every input has a `<label>` |
| Section title | `components/section-heading` | |
| Page header | `components/page-header` | |
| Empty data | `components/empty-state` | |
| Icon | `components/icon` | `size-4` in buttons/text, `size-5` standalone, `size-10` for empty states |
| Pagination | `components/pagination` | |

### Radius

| Element | Radius |
| --- | --- |
| Cards, panels, framed sections | `rounded-2xl` (built into `card`) |
| Images/media inside a card or standalone | `rounded-xl` |
| Buttons, inputs, small thumbnails | `rounded-lg` |
| Badges, avatars, pills, round icon buttons | `rounded-full` |

### Shadows, borders and interaction

- Shadows: `shadow-sm` (cards), `hover:shadow-md` (via `card-hover`), `shadow-lg` (dropdowns, overlays). Nothing else.
- Borders: `border-slate-200`. Dividers: `divide-slate-100`. Don't stack border, ring and shadow together.
- Hover: change color (`hover:text-primary`, `hover:bg-primary/90`) or lift the card via `card-hover`. Image zoom at most `scale-105`.
- Transitions: `transition-colors`, or `transition duration-300` for images. Avoid `animate-bounce`, decorative `animate-pulse`, and parallax.
- Don't remove focus styles. `:focus-visible` is already set in `theme.css`.

---

## 4. Responsive

Write for mobile first, then add breakpoints. Most visitors to government portals are on phones.

- **Test widths:** 375px (phone), 768px (tablet), 1280px (desktop). No horizontal scroll at 375px.
- **Grids:** one column on mobile, then add more. E.g. `grid gap-6 sm:grid-cols-2 lg:grid-cols-3`
  (or `lg:grid-cols-4` for small cards). Never `grid-cols-3` without a breakpoint.
- **Flex rows:** `flex flex-col sm:flex-row`. Meta that can get long gets `flex-wrap`.
- **Heading sizes** step up at `sm:` per the typography table.
- **Images:** always `aspect-*` + `object-cover` + `loading="lazy"` + `alt`. Give the wrapper
  `bg-slate-100` so layout doesn't jump while the image loads.
- **Long text:** flex children get `min-w-0`; long URLs/words get `break-words`; tables get wrapped in `overflow-x-auto`.
- **Touch targets** at least 44px. Icon buttons use `size-10` or `size-11`.
- **Fixed widths:** avoid `w-screen` and fixed widths over 320px.
- **Sections in narrow placements:** a section can sit in a page-builder column (`$config['col_span'] < 12`,
  wrapped in `.section-col`) or in the header/footer (`$inHeader`, `$inFooter`). Make sure it still
  looks right there. See `sections/main/faq/faq.blade.php` for an example.
