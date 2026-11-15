# Panduan Pembuatan Tema Webuild

Panduan ini menjelaskan cara membuat tema portal publik Webuild, mulai dari mencari referensi
desain sampai tema terpasang di webuild-app. Halaman ini berisi alur dan pembagian peran, sedangkan
detail setiap tahap ada di file masing-masing.

## Alur

```
 DESAIN (desainer UI/UX)                       PENGEMBANGAN (developer)
 ─────────────────────────                     ─────────────────────────
 1. Riset referensi website                    4. Siapkan repo: template starter,
 2. Fondasi visual + komponen di Figma            Theme Kit, skill AI
    (sesuai inventaris komponen)               5. Kodekan: token → layout → komponen
 3. Rekomendasi tata letak                        → halaman → preset tata letak
    (gabungan komponen → preset)               6. Validasi & rilis
          │                                               ▲
          └──────────── serah terima Figma ──────────────┘
                  (komponen, variant, preset, usulan)
```

Inventaris komponen menjadi acuan bersama kedua peran. Desainer membuat komponen sesuai daftar
itu, dan developer mengodekan daftar yang sama.

## Isi panduan

| File | Untuk | Isi |
| --- | --- | --- |
| [01-desain-ui-ux.md](01-desain-ui-ux.md) | Desainer | Riset referensi, fondasi visual di Figma, desain per komponen, rekomendasi tata letak, serah terima |
| [02-inventaris-komponen.md](02-inventaris-komponen.md) | Desainer & developer | Semua komponen, variant, pengaturan, area, dan halaman wajib |
| [03-persiapan-pengembangan.md](03-persiapan-pengembangan.md) | Developer | Membuat repo dari starter, memasang Theme Kit, memasang skill untuk Claude Code / Codex / Antigravity |
| [04-pengembangan-tema.md](04-pengembangan-tema.md) | Developer | Urutan pengerjaan, menerjemahkan Figma ke kode, variant, preset tata letak |
| [05-validasi-dan-rilis.md](05-validasi-dan-rilis.md) | Developer | Pemeriksaan otomatis dan manual, versi, pemasangan ke webuild-app |

## Prinsip yang berlaku di semua tahap

1. **Webuild-app memiliki data dan pengaturan, sedangkan tema hanya memiliki tampilan.** Desain dan
   kode tidak boleh mengarang data (statistik, testimoni, daftar layanan) yang tidak dikirim
   webuild-app. Isi mockup hanyalah contoh.
2. **Semua komponen dan halaman wajib ada.** Komponen yang tidak dipakai di desain beranda tetap
   harus didesain dan dikodekan, karena admin instansi bisa memasangnya kapan saja.
3. **Warna milik admin.** Desain dibangun di atas token warna (`primary`, `secondary`, `accent`)
   dan harus tetap terbaca dengan warna apa pun yang dipilih admin.
4. **Satu sistem.** Tipografi, jarak, radius, dan tombol seragam di seluruh komponen.
5. **Untuk warga.** Pengunjung portal pemerintah datang dari ponsel untuk mencari informasi resmi.
   Keterbacaan dan kecepatan lebih penting daripada dekorasi.

## Repositori terkait

| Repo | Fungsi |
| --- | --- |
| [webuild-theme-starter](https://github.com/adilasomaaa/webuild-theme-starter) | Template tema (repo ini) |
| [webuild/theme-kit](https://packagist.org/packages/webuild/theme-kit) | Kontrak, validator `theme:check`, dan workbench ([GitHub](https://github.com/adilasomaaa/webuild-theme-kit)) |
| [webuild-skills](https://github.com/adilasomaaa/webuild-skills) | Skill `webuild-theme` untuk agen AI (Claude Code, Codex, Antigravity, dan lainnya) |
