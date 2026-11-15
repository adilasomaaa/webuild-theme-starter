# 02 · Inventaris Komponen & Variant

Dokumen ini adalah **daftar tunggal** semua komponen yang harus didesain dan dikodekan pada tema
Webuild. Desainer memakainya untuk membuat komponen di Figma, developer memakainya untuk membuat
view. Isinya disusun dari katalog widget webuild-app (`config/layout_sections.php`, form admin di
`resources/js/pages/admin/themes/components/sections/`) dan kontrak Theme Kit
(`DefaultThemeContract`).

> Jika dokumen ini berbeda dengan form admin webuild-app, form admin yang benar. Laporkan
> perbedaannya agar dokumen ini diperbarui.

## Daftar isi
1. [Cara membaca](#1-cara-membaca)
2. [Area & tata letak kolom](#2-area--tata-letak-kolom)
3. [Header](#3-header)
4. [Main (beranda & layout builder)](#4-main-beranda--layout-builder)
5. [Footer](#5-footer)
6. [Page builder (halaman kustom)](#6-page-builder-halaman-kustom)
7. [Halaman wajib](#7-halaman-wajib)
8. [Menambah variant atau komponen](#8-menambah-variant-atau-komponen)
9. [Bukan section / sudah dihapus](#9-bukan-section--sudah-dihapus)

---

## 1. Cara membaca

Ada dua jenis variant, dan perbedaannya menentukan apa yang boleh dilakukan tema:

| Jenis | Arti | Tema boleh menambah pilihan? |
| --- | --- | --- |
| **Variant dasar** ⭐ | Daftar pilihan berasal dari kontrak Theme Kit. Pilihan tambahan dari tema **otomatis tampil** di admin webuild-app sebagai "Variant tambahan dari tema", lengkap dengan `label` dan `description`. | ✅ Ya, lewat `theme.json → component_variants` |
| **Variant tetap** | Pilihan ditulis langsung di form admin webuild-app. | ❌ Tidak bisa sendiri. Pilihan baru tidak akan muncul di admin sampai webuild-app diubah. Ajukan sebagai usulan (lihat bagian 8) |

Semua pilihan pada kedua jenis **wajib didukung** oleh tema. Admin bisa memilih yang mana saja.

Kolom lain di tabel:
- **Maks. kolom:** jumlah kolom terbanyak yang boleh dimiliki sebuah baris yang memuat komponen ini.
  `1` berarti komponen selalu selebar penuh (12/12), dan `3` berarti boleh berada di kolom 4/12.
- **Fitur:** komponen hanya tersedia jika aplikasi instansi mengaktifkan fitur tersebut. Jika fitur
  mati, section tidak dirender.
- **Footer:** ✅ jika komponen juga boleh ditempatkan di kolom footer. Komponen seperti ini harus
  didesain juga untuk kolom footer yang sempit dan berlatar footer.

## 2. Area & tata letak kolom

| Area | Struktur |
| --- | --- |
| Header | 3 kolom: `header_col_1`, `header_col_2`, `header_col_3` |
| Main | Daftar baris. Setiap baris memakai salah satu pembagian kolom di bawah |
| Footer | 3 kolom: `footer_col_1`, `footer_col_2`, `footer_col_3`, ditambah bilah bawah milik tema (lihat bagian 5) |

Pembagian kolom yang tersedia di webuild-app (grid 12 kolom):

| Pembagian | Lebar tiap kolom |
| --- | --- |
| `12` | penuh |
| `6 / 6` | setengah, setengah |
| `4 / 8` | sepertiga, dua pertiga |
| `8 / 4` | dua pertiga, sepertiga |
| `4 / 4 / 4` | tiga kolom sama |

Di dalam kolom, view menerima `$config['col_span']` (mis. `4`, `6`, `8`, `12`). Komponen dengan
**Maks. kolom ≥ 2** wajib terlihat rapi di kolom 6/12, dan yang **≥ 3** wajib rapi di kolom 4/12.

## 3. Header

| Komponen | Isi | Variant |
| --- | --- | --- |
| `header_logo` | Logo dan/atau nama situs | ⭐ `mode`: `logo_name` · `logo_only` · `name_only` |
| `header_menu` | Menu navigasi utama + submenu (dari `$menus`). Wajib punya versi menu ponsel | — |
| `header_search` | Kolom/tombol pencarian. Pengaturan: `placeholder`, `button_text` | — |
| `header_button` | Tombol aksi. Pengaturan: `button_text`, `button_url`, `target` (`_self`/`_blank`) | ⭐ `button_variant`: `primary` · `secondary` · `outline`<br>Tetap: `button_size`: `sm` · `md`; `icon`: `none` · `arrow-right` · `external-link` · `phone` · `mail` · `user` · `sparkles` |
| `empty` | Kolom kosong (spasi) | — |

## 4. Main (beranda & layout builder)

### Banner

| Komponen | Isi | Maks. kolom | Fitur | Footer | Variant & pilihan |
| --- | --- | --- | --- | --- | --- |
| `hero` | Judul, highlight, subjudul, tombol, kotak pencarian | 1 | — | — | Tetap: `background_type`: `solid` · `gradient` · `image`; `background_gradient`: `ocean` · `sunset` · `forest` · `violet` · `slate`; `text_align`: `left` · `center` · `right`; `text_size`: `small` · `normal` · `large`; `section_height`: `auto` · `tall` · `fullscreen`; `hover_effect`: `none` · `blur`; `overlay_opacity` 0–100; `show_search_bar`, `show_buttons` |
| `slider` | Banner gambar bergulir (`$sliders`) | 1 | `slider` | — | ⭐ `aspect_ratio`: `21:9` · `16:10` · `4:3` · `16:9`<br>Tetap: `text_align`: `left` · `center` · `right`; `text_valign`: `top` · `center` · `bottom`; `text_size`: `small` · `normal` · `large`; `full_section`, `autoplay`, `interval` |

### Konten & dokumen

| Komponen | Isi | Maks. kolom | Fitur | Footer | Variant & pilihan |
| --- | --- | --- | --- | --- | --- |
| `contents` | Daftar berita/artikel | 2 | — | ✅ | ⭐ `layout_variant`: `grid` · `list` · `featured_list`. Nama tambahan yang sudah dikenali admin: `headline` (utama + terpopuler), `latest_list` (terbaru + agenda), `by_category` (blok per kanal)<br>Tetap: `content_type`: `all` · `news` · `article` · `page`; `sort_by`: `latest` · `popular`; `limit`, `category_id`, `columns` |
| `single_highlight` | Satu konten yang disorot | 2 | — | — | Tetap: `background_style`: `white` · `primary`; `content_type`: `article` · `page` · `document` · `media` · `video` |
| `maklumat_pelayanan` | Maklumat pelayanan + dokumen resmi | 2 | — | — | Tetap: `background_style`: `white` · `primary` |
| `documents` | Daftar dokumen unduhan | 2 | `dokumen` | ✅ | ⭐ `layout_variant`: `grid` · `list`<br>Tetap: `category_id`, `limit`, `columns` |
| `content_reference` | Konten pilihan (khusus page builder, lihat bagian 6) | — | — | — | — |
| `document_reference` | Dokumen pilihan (khusus page builder, lihat bagian 6) | — | — | — | — |

### Media

| Komponen | Isi | Maks. kolom | Fitur | Footer | Variant & pilihan |
| --- | --- | --- | --- | --- | --- |
| `profile_video` | Sematan video YouTube/Vimeo | 2 | — | — | Tetap: `layout_orientation`: `vertical` (bertumpuk) · `horizontal` (berdampingan); `aspect_ratio`: `16:9` · `4:3` · `21:9` · `1:1` |
| `media_gallery` | Galeri foto & video | 1 | `media` | — | ⭐ `layout_variant`: `asymmetric_grid` · `marquee`<br>Tetap: `media_type`: `all` · `photo` · `video`; `layout_direction` (arah marquee); `show_filter_tabs` |
| `image` | Satu gambar | 3 | — | — | Tetap: `layout_orientation`: `vertical` · `horizontal`; `aspect_ratio`: `auto` · `16:9` · `4:3` · `1:1`; `alignment`: `left` · `center` · `right`; `caption`, `link_url` |
| `audio` | Pemutar audio | 3 | — | ✅ | Tetap: `layout_style`: `card` · `minimal`; `autoplay`, `loop`; cover, artis |

### Komponen umum

| Komponen | Isi | Maks. kolom | Fitur | Footer | Variant & pilihan |
| --- | --- | --- | --- | --- | --- |
| `rich_text` | HTML dari editor | 3 | — | — | — (pakai `prose-content`) |
| `html_embed` | HTML/iframe bebas | 2 | — | — | — |
| `card_info` | Satu kartu: badge, judul, deskripsi, gambar, tombol | 3 | — | — | — |
| `card_grid` | Banyak kartu dalam grid | 1 | — | ✅ | Tetap: `card_style`: `icon`; `columns`; ikon kartu: `calendar` · `ticket` · `location` · `phone` · `weather` · `building` · `chart` · `money` · `shopping-cart` · `service` · `info` · `megaphone` · `alert` · `contact` · `document` · `users` · `shield` · `link` |

### Fitur & layanan

| Komponen | Isi | Maks. kolom | Fitur | Footer | Variant & pilihan |
| --- | --- | --- | --- | --- | --- |
| `agenda` | Agenda kegiatan pejabat | 2 | `agenda` | ✅ | ⭐ `timeframe`: `today` · `this_week` · `this_month`<br>Tetap: `limit`, `columns`, tombol |
| `faq` | Tanya jawab | 2 | `faq` | — | ⭐ `layout_orientation`: `vertical` · `horizontal`<br>Tetap: `collapse_all_default`, `allow_multiple`, `show_toggle_all`, `category`, `limit` |
| `pranala` | Tautan mitra & layanan terkait | 2 | `pranala` | ✅ | Tetap: `variant`: `strip` · `card` · `grid` · `list`; `text_align`: `left` · `center` · `right`; `columns`, `limit` |
| `organization_structure` | Bagan struktur organisasi | 1 | `organization_structure` | — | Tetap: `variant`: `flow` (satu-satunya saat ini); `show_holders`, `show_contact`, `show_draft_positions` |
| `registered_applications` | Direktori aplikasi terdaftar | 1 | `application_directory` | — | Tetap: `autoplay`, `interval`, `limit` |
| `geo_map` | Daftar peta digital | 1 | `pemetaan` | — | Tetap: `base_map_filter`: `all` · `osm` · `satellite` · `terrain`; `sort_by`: `latest` · `title_asc`; `columns`, `show_view_all` |
| `booking_methods` | Alur reservasi kunjungan | 2 | `jadwal_reservasi` | — | Tetap: `layout_orientation`: `vertical` · `horizontal` |
| `booking_tracking` | Form lacak kode booking | 3 | `jadwal_reservasi` | ✅ | Tetap: `layout_orientation`: `vertical` · `horizontal` |
| `guestbook_widget` | Ajakan isi buku tamu + QR | 3 | `buku_tamu` | ✅ | Tetap: `show_qr` |

### Kontak & navigasi

| Komponen | Isi | Maks. kolom | Fitur | Footer | Variant & pilihan |
| --- | --- | --- | --- | --- | --- |
| `contact` | Alamat, telepon, email instansi (`$profile`) | 3 | — | ✅ | — |
| `maps_embed` | Peta Google Maps | 2 | — | ✅ | Tetap: `layout_orientation`: `vertical` · `horizontal` |
| `social_media` | Tautan media sosial | 3 | — | ✅ | Tetap: platform `instagram` · `facebook` · `twitter` · `youtube` · `tiktok` · `whatsapp` · `telegram` · `linkedin` · `other`; `columns`, `include_organization_profile` |

## 5. Footer

Setiap kolom footer (`footer_col_1..3`) dapat diisi **satu widget** dari daftar berikut. Semuanya
harus didesain untuk kolom footer: lebar sekitar sepertiga layar desktop, satu kolom di ponsel,
dengan warna mengikuti latar footer. View menerima `$inFooter = true`.

| Widget | Catatan di footer |
| --- | --- |
| `quick_links` | **Khusus footer.** Judul + daftar tautan (`links`: label, url, target) |
| `contact` | Alamat & kontak instansi |
| `social_media` | Ikon media sosial |
| `maps_embed` | Peta kecil |
| `contents` | Daftar berita ringkas (pakai kartu `compact`) |
| `documents` | Daftar dokumen ringkas |
| `agenda` | Agenda ringkas |
| `pranala` | Tautan terkait |
| `card_grid` | Kartu-kartu kecil |
| `audio` | Pemutar audio (gaya `minimal` lebih cocok) |
| `booking_tracking` | Form lacak booking |
| `guestbook_widget` | Ajakan buku tamu |

**Bilah bawah footer** (`sections/footer/footer`) adalah milik tema: hak cipta, tautan kebijakan
privasi, syarat layanan, dan kontak. Di starter, pengaturannya ada di
`theme.json → component_settings.footer` (`copyright_text`, `privacy_url`, `terms_url`,
`contact_url`). Section ini diwajibkan oleh kontrak Theme Kit, tetapi tidak ada di katalog widget
webuild-app.

## 6. Page builder (halaman kustom)

Admin dapat menyusun halaman sendiri dari komponen berikut, dengan pembagian kolom yang sama seperti
bagian 2. Komponen ini harus terlihat baik di dalam isi halaman (bukan di beranda) dan di kolom sempit.

| Komponen | Variant & pilihan |
| --- | --- |
| `rich_text` | — |
| `image` | sama dengan bagian 4 |
| `content_reference` | Tetap: `mode`: `majemuk` (beberapa konten) · `individual` (satu konten); `display_mode`: `card`; `layout_direction`: `vertical` · `horizontal`; `columns`: `1` · `auto` |
| `document_reference` | Dokumen yang dipilih admin |
| `card_info` | — |
| `card_grid` | sama dengan bagian 4 |
| `audio` | sama dengan bagian 4 |
| `html_embed` | — |
| `maps_embed` | `layout_orientation`: `vertical` · `horizontal` |

## 7. Halaman wajib

Setiap tema wajib menyediakan semua halaman berikut (`views/pages/{grup}/{nama}.blade.php`). Variabel
setiap halaman tercantum di komentar header file starter.

| Grup | Halaman |
| --- | --- |
| `home` | `home` (beranda) |
| `page` | `page` (halaman statis / page builder) |
| `content` | `content` (detail berita/artikel), `categories` |
| `catalog` | `catalog`, `catalog-show`, `catalog-category` |
| `dynamic_content` | `dynamic-content`, `dynamic-content-show`, `dynamic-category` |
| `document` | `document` |
| `agenda` | `agenda`, `agenda-show` |
| `booking` | `booking`, `booking_track`, `booking_print` |
| `faq` | `faq` |
| `guestbook` | `guestbook` |
| `pranala` | `pranala`, `links` (halaman daftar tautan) |
| `applications` | `applications` |
| `organization_structure` | `organization-structure`, `organization-structure-detail` |
| `geo_map` | `geo-map`, `geo-map-list` |
| `search` | `search` |
| `ar_preview` | `ar-preview` |

Ditambah indeks fitur di `views/features/`: `content`, `document`, `media`.

## 8. Menambah variant atau komponen

**Variant dasar ⭐** (`header_logo`, `header_button`, `contents`, `media_gallery`, `agenda`,
`documents`, `faq`, `slider`): tambahkan pilihan di `theme.json → component_variants` dengan `label`
dan `description`. Admin langsung melihatnya sebagai "Variant tambahan dari tema". Catat di
`CHANGELOG.md` bagian **New variants**.

**Variant tetap** (semua yang lain, mis. `profile_video.layout_orientation`, `pranala.variant`):
tema tidak bisa menambah pilihan sendiri. Tandai sebagai **usulan** di Figma dan di `CHANGELOG.md`
(bagian **Proposals**), beserta deskripsi dan alasannya. Pilihan tersebut baru bisa dipakai setelah
form webuild-app diperbarui.

**Komponen baru:** daftarkan di `theme.json → sections` dan `component_definitions`, lalu buat
view-nya (lihat skill `webuild-theme`, `references/variants-and-components.md`). Admin memakai form
generik yang dibentuk dari `component_settings`. Catat di bagian **New components**.

## 9. Bukan section / sudah dihapus

| Nama | Status |
| --- | --- |
| `running_text` | Dihapus dari katalog. Jangan didesain |
| `page_content` | Dihapus dari katalog |
| `comments` | Bukan section. Ini bagian dari halaman detail konten (`components/comments`) |
| `links` | Nama lama `pranala` di data tersimpan. Daftar tautan di footer adalah `quick_links`, sedangkan halaman daftar tautan adalah `pages/pranala/links` |
| `gallery_media`, `contact_info` | Nama lama `media_gallery` dan `contact` |
| `news`, `articles` | Nama lama `contents` |
| `geo_maps` | Nama lama `geo_map` |

Nama lama masih bisa muncul di data instansi yang sudah ada, dan Theme Kit menerjemahkannya secara
otomatis. Tema tidak perlu membuat view untuk nama-nama lama ini.
