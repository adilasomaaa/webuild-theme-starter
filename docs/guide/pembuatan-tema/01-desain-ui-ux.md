# 01 · Desain UI/UX

Tahap ini menghasilkan file Figma yang siap dikodekan: fondasi visual, semua komponen beserta
variant-nya, dan rekomendasi tata letak. Urutannya:

1. Riset referensi website
2. Fondasi visual (token)
3. Desain per komponen
4. Halaman dalam
5. Rekomendasi tata letak
6. Serah terima

Gunakan [02-inventaris-komponen.md](02-inventaris-komponen.md) sebagai daftar periksa di setiap tahap.

---

## 1. Riset referensi website

Tujuannya mengumpulkan arah visual dan pola yang terbukti berhasil, bukan menyalin satu situs.

1. Kumpulkan **3–5 situs referensi**: portal pemerintah yang baik (dalam dan luar negeri), ditambah
   1–2 situs non-pemerintah yang kuat di bidang tipografi atau keterbacaan.
2. Untuk setiap referensi, catat dalam satu frame Figma (halaman **Referensi**):
   - tangkapan layar desktop dan ponsel,
   - apa yang diambil (tipografi, ritme jarak, cara menampilkan berita, navigasi),
   - komponen inventaris mana yang terwakili (mis. "pola daftar berita → `contents`, variant `list`").
3. Petakan referensi ke inventaris. Komponen yang tidak punya referensi tetap harus didesain, jadi
   turunkan dari sistem yang sama.
4. Tulis **arah desain** dalam 3–5 kalimat. Contoh: "Formal dan tenang, tipografi besar, latar putih
   dengan aksen warna instansi, foto kegiatan sebagai elemen utama."

Hindari: menjiplak tata letak atau aset satu situs, dan memilih referensi hanya karena terlihat "modern".
Pertimbangkan pengguna nyata: warga dari berbagai usia, kebanyakan memakai ponsel.

## 2. Fondasi visual (token)

Buat halaman **Fondasi** di Figma. Gunakan **Figma Variables** agar nilainya bisa langsung
dipetakan ke kode.

| Token | Isi | Dipetakan ke |
| --- | --- | --- |
| Warna identitas | `primary`, `secondary`, `accent` | `theme.json → settings_schema` (bisa diubah admin) |
| Warna netral | skala abu-abu untuk teks, border, latar | kelas `slate-*` |
| Warna status | sukses, peringatan, gagal, info | warna status di flash/booking |
| Tipografi | font, skala ukuran, ketebalan, line-height | `--font-sans`, tabel tipografi skill |
| Jarak | skala 4px | kelas `section`, `gap-*`, `p-*` |
| Radius & bayangan | kartu, gambar, tombol, badge | kelas `card`, `btn` |

**Uji fleksibilitas warna sejak awal.** Buat collection warna identitas dengan beberapa **mode**:
default tema, terang (`#facc15`), gelap (`#0f172a`), dan saturasi tinggi (`#e11d48`). Ganti mode di
setiap frame komponen. Jika teks tidak terbaca di salah satu mode, perbaiki desainnya sekarang,
bukan saat coding.

Acuan tipografi (sesuaikan nilainya, tetapi pertahankan perannya):

| Peran | Ukuran (ponsel → desktop) | Ketebalan | Line height |
| --- | --- | --- | --- |
| Judul hero (H1) | 36 → 48 | Bold | Tight |
| Judul halaman (H1) | 30 → 36 | Bold | Tight |
| Judul section (H2) | 24 → 30 | Bold | Normal |
| Judul kartu (H3) | 18 | Semibold | Snug |
| Teks isi | 16 | Regular | Relaxed (≈1.6) |
| Meta / keterangan | 14 / 12 | Regular | Normal |

Gunakan hanya empat ketebalan: Regular, Medium, Semibold, Bold. Satu H1 per halaman.

## 3. Desain per komponen

Buat halaman **Komponen** di Figma. Setiap komponen di inventaris menjadi satu **Figma Component**
dengan aturan berikut:

1. **Nama** sama persis dengan key inventaris: `contents`, `profile_video`, `quick_links`.
2. **Variant property** memakai nama key dan nilai yang sama dengan inventaris. Contoh untuk
   `contents`: property `layout_variant` dengan nilai `grid` / `list` / `featured_list`; untuk
   `profile_video`: property `layout_orientation` dengan nilai `vertical` / `horizontal`. Developer
   bisa langsung mencocokkan desain dengan kode.
3. **Semua pilihan didesain**, baik variant dasar ⭐ maupun variant tetap.
4. **Breakpoint:** ponsel (375), tablet (768), desktop (1280).
5. **Keadaan data:** data penuh, data kosong (empty state), satu item saja, judul sangat panjang,
   dan tanpa gambar.
6. **Penempatan:** komponen dengan *Maks. kolom* ≥ 2 diberi versi kolom 6/12, ≥ 3 versi kolom
   4/12, dan komponen bertanda *Footer* ✅ diberi versi kolom footer.
7. **Isi contoh** memakai isi realistis yang sesuai field data (judul berita, tanggal, kategori),
   bukan lorem ipsum. Jangan menambahkan elemen yang tidak punya field data (angka statistik,
   rating, testimoni). Jika desain membutuhkannya, tandai sebagai **usulan** (lihat bagian 6).

Urutan pengerjaan yang disarankan: header (semua komponen header + menu ponsel) → footer (bilah
bawah + 12 widget kolom) → komponen beranda per kategori → komponen page builder.

### Anti-slop

Hindari pola yang membuat tampilan terasa generik atau tidak tepercaya:

- gradien ungu-biru dekoratif, teks bergradien, blob blur,
- glassmorphism di mana-mana,
- emoji sebagai ikon,
- angka, statistik, testimoni, atau logo mitra karangan,
- semua elemen rata tengah,
- kartu di dalam kartu,
- radius dan bayangan acak,
- animasi di setiap elemen,
- copy generik seperti "Solusi inovatif untuk masa depan digital",
- teks abu-abu pucat untuk isi,
- banyak tombol berwarna yang bersaing.

Daftar lengkap beserta penggantinya ada di skill `webuild-theme` (`references/anti-slop.md`).

## 4. Halaman dalam

Buat halaman **Halaman** di Figma untuk setiap grup di
[inventaris bagian 7](02-inventaris-komponen.md#7-halaman-wajib). Minimal desain pola berikut, lalu
turunkan ke halaman lain:

| Pola | Contoh halaman |
| --- | --- |
| Kepala halaman (judul, breadcrumb) | semua halaman dalam |
| Halaman daftar + filter + pagination | berita, dokumen, agenda, katalog |
| Halaman detail + sidebar | detail berita (dengan komentar), detail agenda, detail katalog |
| Formulir | buku tamu, booking, lacak booking |
| Halaman cetak | `booking_print` |
| Hasil pencarian & halaman kosong | pencarian, daftar tanpa data |

## 5. Rekomendasi tata letak

Setelah semua komponen jadi, susun **1–3 beranda contoh** dengan menggabungkan komponen. Setiap
susunan menjadi **preset tata letak** yang bisa dipilih admin di webuild-app.

Aturan menyusun:
- Gunakan pembagian kolom yang tersedia: `12`, `6/6`, `4/8`, `8/4`, `4/4/4`.
- Patuhi *Maks. kolom* setiap komponen. Contoh: `hero` dan `media_gallery` selalu selebar penuh,
  sedangkan `agenda` dan `faq` boleh berdampingan di `6/6`.
- Header: tentukan isi `col_1..3`. Footer: tentukan widget `col_1..3`.
- Beri setiap preset **nama**, **deskripsi singkat** untuk siapa preset ini, dan **thumbnail**
  (ekspor frame beranda).

Contoh:

| Preset | Untuk | Susunan main |
| --- | --- | --- |
| Layanan Publik | Dinas yang menonjolkan layanan | `hero` (12) → `maklumat_pelayanan` (12) → `contents: featured_list` (12) → `documents` (12) → `agenda` + `faq` (6/6) → `pranala` (12) |
| Portal Berita | Instansi dengan publikasi tinggi | `slider` (12) → `contents: grid` (8) + `agenda` (4) → `media_gallery` (12) → `social_media` (12) |

Developer menuliskan preset ini di `theme.json → layout_presets`
(lihat [04-pengembangan-tema.md](04-pengembangan-tema.md#5-preset-tata-letak)).

## 6. Serah terima ke developer

Sebelum diserahkan, pastikan:

- [ ] Halaman Figma: **Referensi**, **Fondasi**, **Komponen**, **Halaman**, **Tata Letak**.
- [ ] Semua komponen di inventaris ada, dengan nama dan variant property yang sesuai.
- [ ] Setiap komponen memiliki versi ponsel, desktop, data kosong, dan penempatan sempit/footer
      jika berlaku.
- [ ] Mode warna uji (terang, gelap, saturasi tinggi) sudah dicek.
- [ ] Preset tata letak memiliki nama, deskripsi, dan thumbnail.
- [ ] **Usulan** ditandai jelas (mis. label `[USULAN]` pada frame), masing-masing dengan deskripsi
      dan alasan:
  - variant tambahan untuk variant dasar ⭐ (bisa langsung dikodekan),
  - pilihan baru untuk variant tetap (perlu perubahan webuild-app),
  - komponen baru,
  - field data baru yang dibutuhkan desain.
