# Anti-Slop Design

"Slop" is UI that looks generator-made: decoration that shows up out of habit, not because users
need it. Visitors to a government portal are citizens of every age, many on cheap phones with slow
connections. They come to **find information quickly and trust that the site is official**. Every
element should serve one of those two goals.

Before adding something, ask: does this help citizens find or trust information? If the answer is
"so it looks modern", remove it.

## Patterns to avoid

| Slop | Do this instead |
| --- | --- |
| Purple-blue gradients, gradient text (`bg-clip-text`), decorative blurred blobs | Solid token colors. Gradients only when they come from an admin choice (hero presets) |
| Glassmorphism everywhere (`backdrop-blur`, `bg-white/10`) | Solid surfaces (`bg-white`, `section-muted`). Blur only for overlays on images |
| Emoji as icons, "✨", "🚀" | `components/icon` |
| Made-up numbers, stats, testimonials or partner logos ("Trusted by 10,000+ citizens") | Show only data from variables. If the data doesn't exist, don't build the block |
| Filler 3-column grid of "icon in a colored circle + title + two lines" | Show real content (services, news, documents) from data |
| Everything centered | Left-align reading text and lists. Center only the hero, empty states and short CTAs |
| Cards inside cards, or stacked border + ring + shadow | One surface layer. Separate content with spacing and `divide-y` |
| Random radii and shadows (`rounded-3xl`, `shadow-2xl`, `rounded-[20px]`) | Follow the radius and shadow tables in `design-system.md` |
| Animation on everything: `hover:scale-110`, `animate-bounce`, fade-in on scroll, parallax | A color change or `card-hover` is enough. Animation costs battery and frames on cheap phones |
| Generic copy: "Innovative solutions for a digital future", "Experience the best" | Formal, concrete Bahasa Indonesia, matching the existing fallback copy ("Berita & Informasi Terbaru") |
| Images from Unsplash/Picsum/ui-avatars, or extra external fonts and CDNs | Images from data. When empty, show an icon placeholder like `content-card` does |
| Decorative badges ("New!", "Popular", "Hot") with no data behind them | Badges only for real categories or statuses |
| Pale gray text for "elegance" (`text-slate-400` for body) | Follow the text colors in `design-system.md` |
| Giant hero padding on every section (`py-32`), bloated spacing | The `section` class. Only the hero may be tall, and its height follows `section_height` |
| Partially added `dark:` classes | The theme has no dark mode. Don't add half of one |
| Several competing colored CTAs | One `btn-primary` per block |
| Icons on every heading, label and button | Icons only where they speed up recognition (date, download, location, "see all" arrow) |

## Check before you finish

Run these on the changed files. Every hit needs a legitimate reason:

```bash
FILES="<changed files>"
grep -nE "bg-clip-text|backdrop-blur|animate-(bounce|pulse|spin)|rounded-(3xl|\[)|shadow-(xl|2xl)|font-(light|thin|extrabold|black)|dark:|unsplash|picsum|ui-avatars|lorem" $FILES
grep -nP "[\x{1F300}-\x{1FAFF}\x{2728}]" $FILES    # emoji
grep -nE "<h1" $FILES                                 # h1 only in the hero / page-header
grep -nE "\b(p|m|gap|w|h|text)-\[[0-9]+px\]" $FILES   # arbitrary px values
```

Then reread the result as a 55-year-old citizen opening the site on a phone to find service hours.
Is the information visible right away? Is anything there only as decoration?
