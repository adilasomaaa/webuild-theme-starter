# Tema Starter (`theme-starter`)

Kerangka tema portal publik Webuild yang sudah berisi desain dasar berbasis Tailwind CSS 4.
Setiap halaman dan section punya isi minimal yang berfungsi, sehingga bisa langsung dipakai
atau dijadikan acuan saat membuat tema baru.

## Menjalankan di Lingkungan Lokal

```bash
composer install
npm install
npm run build        # atau: npm run dev (build ulang otomatis saat file berubah)
php artisan serve
```

Buka `http://localhost:8000`. `artisan` otomatis menautkan tema ini ke workbench Theme Kit
(`theme-kit/workbench/views/themes/{key}` dan `themes/{key}`) agar view dan aset terbaca.

## Customizer Workbench

Saat dijalankan lewat `php artisan serve`, workbench menampilkan tombol gerigi di kanan bawah yang membuka drawer
pengaturan tampilan. Drawer ini disisipkan oleh workbench Theme Kit, **bukan bagian dari view tema**, sehingga tidak ikut
terpasang ke aplikasi Webuild.

| Tab | Isi |
| --- | --- |
| Halaman ini | Pengaturan grup halaman yang sedang dibuka (mis. `/document` → grup Dokumen: varian default folder/grid/list, tampilkan pilihan varian, filter). Grup lain bisa dipilih dari daftar. |
| Section | Susunan beranda seperti page builder webuild-app: **+ Tambah Section** memilih tata letak kolom (12, 6/6, 8/4, 4/8, 4/4/4, 3/3/3/3), setiap kolom diisi satu komponen lewat **+ Pilih komponen**, lebar kolom bisa diubah (x/12), dan section maupun kolom digeser ⋮⋮ untuk mengurutkan. Atribut hero, slider, profile video, card grid, card info, dan media sosial mengikuti form webuild-app (`theme-kit/workbench/config/component_fields.php`); `component_settings` tema menimpanya. Beranda dikirim ke tema sebagai `$page->sections` (`is_homepage`) dan juga diratakan ke `$layoutSections['main']`. |
| Header / Footer | Komponen per kolom (`header_col_1..3`, `footer_col_1..3`): tambah, hapus, geser antarkolom, varian, dan pengaturan. |
| Menu | Menu utama dan submenu: tampil/sembunyi, geser untuk mengurutkan, serta form Tambah/Ubah Menu (label, menu induk, tipe menu, target) dengan pilihan halaman, konten, fitur, dan kategori dari data demo. |

Pengaturan disimpan per tema di `theme-kit/workbench/storage/customizer/{key}-{folder}.json` dan diteruskan ke view sebagai
`$layoutSections`, `$menus`, `$pageSettings`, dan `$layoutVariant`, sama seperti yang dikirim aplikasi Webuild.
Gunakan **Reset default** untuk kembali ke susunan awal, atau jalankan dengan `THEME_CUSTOMIZER=false` untuk menyembunyikan drawer.

## Memvalidasi Integritas Tema

```bash
php artisan theme:check --render
```

## Struktur

```
resources/theme.css   Token desain + kelas komponen (Tailwind 4)
resources/theme.js    Interaksi ringan: menu mobile, dropdown, slider, akordeon, filter galeri
dist/                 Hasil build (di-commit; dimuat lewat @themeAssets sesuai theme.json → assets)
views/layouts/        public (head & token warna), header, footer
views/components/     Komponen yang dipakai ulang (lihat di bawah)
views/sections/       Komponen layout builder: header/, main/, footer/
views/pages/          Halaman wajib (daftar di DefaultThemeContract)
views/features/       Indeks berita, dokumen, dan galeri
demo/data.json        Data contoh untuk workbench
```

## Sistem Desain

Warna diambil dari pengaturan tema (`primary_color`, `secondary_color`, `accent_color`) dan tersedia
sebagai utilitas Tailwind: `bg-primary`, `text-primary`, `border-primary/20`, `from-primary to-secondary`, dst.

Kelas komponen di `resources/theme.css`:

| Kelas | Kegunaan |
| --- | --- |
| `container-page`, `section`, `section-muted` | Lebar konten dan jarak vertikal section |
| `btn` + `btn-primary` / `btn-secondary` / `btn-outline` / `btn-ghost` / `btn-light`, `btn-sm` / `btn-lg` | Tombol |
| `card`, `card-hover` | Kartu |
| `badge`, `badge-muted` | Label kecil |
| `form-label`, `form-input`, `form-error` | Formulir |
| `prose-content` | Tipografi HTML dari editor |

Komponen Blade di `views/components/` dipanggil dengan `@include('themes.starter.components.<nama>', [...])`:

| Komponen | Parameter |
| --- | --- |
| `icon` | `name`, `class` |
| `section-heading` | `title`, `subtitle`, opsional `headingBadge`, `headingActionText`, `headingActionUrl`, `headingAlign` |
| `page-header` | `title`, `subtitle`, `breadcrumbs` |
| `empty-state` | `emptyMessage`, `emptyIcon` |
| `content-card` | `item`, `cardVariant` (`grid`/`list`/`compact`), `cardType` |
| `document-item`, `agenda-item`, `faq-item`, `link-card`, `app-card`, `person-card`, `dynamic-card` | satu item data |
| `pagination` | dipakai lewat `$paginator->links('themes.starter.components.pagination')` |
| `render-section` | merender section dari layout/page builder |

> Parameter opsional sengaja diberi prefiks (`heading…`, `empty…`, `card…`) karena `@include`
> mewarisi semua variabel view pemanggil; nama umum seperti `$title` atau `$icon` bisa tertimpa.

## Komponen dan Variant

Daftar section adalah **katalog widget Webuild** dan sama untuk semua tema
(`DefaultThemeContract::getRequiredSections()` di theme-kit). `sections.{header|main|footer}` harus memuat seluruh
katalog dan tidak boleh berisi key lain; `theme:check` menolak section asing (mis. `running_text`) maupun alias lama
(`gallery_media`, `links`, `contact_info` → `media_gallery`, `pranala`, `contact`). Setiap section punya view Blade di
`views/sections/{area}/{id}/{id}.blade.php`. Partial yang bukan widget (mis. komentar) diletakkan di `views/components/`.

Section menerima `$config` (pengaturan dari admin), `$variant`, `$inFooter`, serta data halaman (`$allContents`, `$documents`,
`$faqs`, `$profile`, `$menus`, dll.). Field yang dapat diedit didaftarkan di `component_settings`.
Komentar di bagian atas setiap view section menjelaskan pengaturan yang dipakai.

**Variant boleh ditambah, tidak boleh dikurangi.** `component_variants` wajib memuat pilihan dasar berikut
(`DefaultThemeContract::getBaseVariants()`), dengan `configuration_key` yang sama; tema bebas menambah pilihan sendiri
dan memilih `default`-nya. Admin selalu menampilkan pilihan dasar ditambah pilihan tema.

| Komponen | `configuration_key` | Pilihan dasar |
|---|---|---|
| `header_logo` | `mode` | `logo_name`, `logo_only`, `name_only` |
| `header_button` | `button_variant` | `primary`, `secondary`, `outline` |
| `contents` | `layout_variant` | `grid`, `list`, `featured_list` |
| `media_gallery` | `layout_variant` | `asymmetric_grid`, `marquee` |
| `agenda` | `timeframe` | `today`, `this_week`, `this_month` |
| `documents` | `layout_variant` | `grid`, `list` |
| `faq` | `layout_orientation` | `vertical`, `horizontal` |
| `slider` | `aspect_ratio` | `21:9`, `16:10`, `4:3`, `16:9` |

Saat tema diperbarui (pull), Webuild menolak versi baru yang menghapus section katalog atau pilihan variant yang
sebelumnya ada. Nilai lama yang tersimpan di aplikasi tidak memblokir pull; nilai yang tidak dikenal dicatat sebagai
peringatan di log penerapan dan dirender dengan `default`.

## Rekomendasi Tata Letak (`layout_presets`)

Opsional. Tema dapat menyarankan susunan lengkap header, konten utama, dan footer. Admin akan melihatnya di menu
**Tata Letak → Rekomendasi Tema** dan ditawari setelah mengaktifkan tema. Rekomendasi diterapkan ke draft dan
mengganti seluruh tata letak hanya setelah admin klik Simpan.

```json
"layout_presets": [{
    "key": "layanan_publik", "name": "Layanan Publik", "description": "...", "thumbnail": "presets/layanan.png",
    "header": { "col_1": { "section_type": "header_logo", "configuration": {} }, "col_2": {...}, "col_3": {...} },
    "main": [{ "columns": [{ "col_span": 8, "section_type": "contents", "configuration": {} }, { "col_span": 4, ... }] }],
    "footer": { "col_1": {...}, "col_2": {...}, "col_3": {...} }
}]
```

`configuration` digabung di atas `default_configuration` komponen. `section_type` harus terdaftar di `sections`;
yang tidak dikenal dibuang. Kolom header/footer yang tidak diisi akan dikosongkan. `thumbnail` adalah path aset tema (opsional).

## Membuat Tema Baru dari Starter

1. Ubah `key`, `name`, dan `description` di `theme.json`, serta `name` dan namespace di `composer.json` dan `src/ThemeServiceProvider.php`.
2. Ganti semua `themes.starter.` dan `@themeAssets('starter')` / `resolveSection('starter'` di `views/` dengan key baru.
3. Sesuaikan warna default di `settings_schema`, lalu kembangkan tampilan di `resources/theme.css` dan `views/`.
4. Jalankan `npm run build` dan `php artisan theme:check --render` sebelum rilis.

## Data Demo

Ubah fixture di `demo/data.json` (10 contoh per koleksi). Workbench memakai file ini untuk data berita, artikel, galeri, agenda, dokumen, FAQ, slider, halaman (pilihan menu), pranala (`$links`), media sosial (profil dan tautan tambahan), serta struktur organisasi (`$organizationStructures`, `/f/organisasi`).
Jika tema belum memiliki fixture sendiri, workbench memakai data bawaan Theme Kit. `theme:check --render` merender halaman utama
aplikasi aktif. Jalankan juga dari aplikasi Webuild untuk memeriksa tema dengan data dan integrasi aplikasi sebenarnya.
