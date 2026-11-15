# 04 · Pengembangan Tema

Tahap ini menerjemahkan file Figma menjadi tema. Aturan inti ada di `AGENTS.md`. Detail sistem
desain dan alur kerja langkah demi langkah ada di skill `webuild-theme`.

## Urutan pengerjaan

1. **Token**: warna, font, radius, dan bayangan dari halaman Fondasi Figma.
2. **Layout**: `layouts/public`, header (semua komponen header + menu ponsel), footer (bilah bawah
   + widget kolom).
3. **Komponen beranda**: per kategori di [inventaris](02-inventaris-komponen.md), semua variant.
4. **Komponen page builder.**
5. **Halaman dalam**: kepala halaman, daftar, detail, formulir, cetak.
6. **Preset tata letak.**

Jalankan `npm run build` dan `php artisan theme:check --render` di akhir setiap langkah, jangan hanya
di akhir proyek.

## 1. Sebelum mengubah file apa pun

Untuk setiap komponen atau halaman:

1. Baca file view starter yang bersangkutan, termasuk **komentar header** di baris paling atas.
   Komentar itu adalah kontrak variabel: data, pengaturan (`$config`), dan variant.
2. Baca komponen yang di-`@include` dan satu file sejenis sebagai acuan pola.
3. Cocokkan dengan inventaris (variant dan pilihan) dan dengan frame Figma.
4. Cek bentuk datanya di `demo/data.json`.

Agen AI dengan skill `webuild-theme` diwajibkan melakukan langkah ini dan menuliskan ringkasannya
sebelum mengedit.

## 2. Dari Figma ke kode

| Di Figma | Di kode |
| --- | --- |
| Variable warna identitas | `theme.json → settings_schema` (`primary_color`, …), lalu token `bg-primary`, dst. |
| Warna tambahan yang perlu bisa diatur (mis. latar footer) | field `color` baru di `settings_schema` + token di `theme.css` |
| Font | `--font-sans` di `@theme` (`resources/theme.css`) |
| Radius, bayangan, gaya tombol & kartu | kelas di `@layer components` (`btn`, `card`, …) |
| Figma Component `contents`, property `layout_variant = list` | `views/sections/main/contents/contents.blade.php`, cabang `list` |
| Frame kolom 4/12 atau footer | perilaku view saat `$config['col_span']` kecil atau `$inFooter` |
| Isi contoh di mockup | variabel data dari header view. **Jangan disalin sebagai teks** |
| Frame bertanda `[USULAN]` | lihat bagian 4 |

Aturan yang paling sering dilanggar:
- **Warna:** jangan menulis `bg-blue-700` atau hex untuk warna identitas di view. Jika ingin tema
  bernuansa biru, ubah `default` di `settings_schema`.
- **Data:** jangan membuat array konten, statistik, atau gambar contoh di view. Jika data opsional
  kosong, sembunyikan elemennya.
- **Variabel baru:** jangan membaca key `$config` atau field yang tidak tercantum di header view
  atau `theme.json`.

## 3. Variant

- **Variant dasar ⭐:** semua pilihan dasar wajib ada. Pilihan tambahan ditulis di
  `theme.json → component_variants.<komponen>.options` dengan `label` dan `description`, lalu
  dirender di view dengan fallback ke default:

  ```json
  "magazine": { "label": "Majalah", "description": "Satu berita utama besar dan empat berita kecil." }
  ```

- **Variant tetap:** kodekan semua pilihan yang ada di inventaris (mis. `profile_video`:
  `vertical` dan `horizontal`). Nilai yang tidak dikenal harus kembali ke default.

Detail lengkap ada di skill `webuild-theme`, `references/variants-and-components.md`.

## 4. Usulan dari desain

| Jenis usulan | Tindakan developer |
| --- | --- |
| Variant tambahan untuk variant dasar ⭐ | Kodekan dan catat di `CHANGELOG.md` → **New variants** |
| Pilihan baru untuk variant tetap | Jangan dikodekan dulu. Catat di **Proposals** dan ajukan ke pengelola webuild-app |
| Komponen baru | `sections` + `component_definitions` + view, lalu catat di **New components** |
| Field data baru | Jangan dikarang. Catat di **Proposals** dan ajukan ke pengelola webuild-app |

## 5. Preset tata letak

Rekomendasi tata letak dari Figma ditulis di `theme.json → layout_presets`. Admin dapat memilih
preset ini saat menyusun beranda.

```json
"layout_presets": [
    {
        "key": "layanan_publik",
        "name": "Layanan Publik",
        "description": "Untuk dinas yang menonjolkan layanan, maklumat, dan dokumen publik.",
        "thumbnail": "assets/presets/layanan-publik.png",
        "header": {
            "col_1": { "section_type": "header_logo", "configuration": {} },
            "col_2": { "section_type": "header_menu", "configuration": {} },
            "col_3": { "section_type": "header_search", "configuration": {} }
        },
        "main": [
            { "columns": [ { "col_span": 12, "section_type": "hero", "configuration": { "section_height": "tall" } } ] },
            { "columns": [ { "col_span": 12, "section_type": "contents", "configuration": { "layout_variant": "featured_list" } } ] },
            { "columns": [
                { "col_span": 6, "section_type": "agenda", "configuration": {} },
                { "col_span": 6, "section_type": "faq", "configuration": {} }
            ] }
        ],
        "footer": {
            "col_1": { "section_type": "contact", "configuration": {} },
            "col_2": { "section_type": "quick_links", "configuration": { "title": "Tautan Cepat" } },
            "col_3": { "section_type": "maps_embed", "configuration": {} }
        }
    }
]
```

Catatan:
- `key` dan `name` wajib diisi. `thumbnail` opsional dan berupa path relatif dari root tema.
- Hanya komponen yang terdaftar di `theme.json → sections` **dan** di katalog Webuild yang dipakai.
  Komponen lain diabaikan diam-diam, jadi periksa ejaannya.
- `configuration` hanya berisi key yang ada di inventaris.
- `theme:check` belum memvalidasi `layout_presets`. Periksa hasilnya dengan memilih preset di admin
  webuild-app setelah tema terpasang.

## 6. Contoh perintah untuk agen AI

```
Pelajari dulu section documents dan pola contents, lalu terapkan desain Figma
"documents / layout_variant=list" (terlampir). Jangan menambah data baru.

Buat variant tambahan "magazine" untuk contents sesuai frame [USULAN] terlampir.

Header berantakan di ponsel 375px, tolong rapikan sesuai sistem desain.

Tuliskan layout_presets dari tiga beranda di halaman "Tata Letak" Figma ini.
```

## Selanjutnya

Lanjut ke [05-validasi-dan-rilis.md](05-validasi-dan-rilis.md).
