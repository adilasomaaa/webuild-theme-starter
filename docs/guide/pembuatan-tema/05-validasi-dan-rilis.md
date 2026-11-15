# 05 · Validasi dan Rilis

## 1. Pemeriksaan otomatis

```bash
npm run build
php artisan theme:check --render
```

`theme:check` memeriksa:
- struktur folder,
- isi `theme.json` (field wajib, `api_version`, `sections`, variant dasar, `component_settings`,
  `component_definitions`, path aset),
- keberadaan semua halaman dan section wajib,
- format `demo/data.json`.

Opsi `--render` juga merender halaman utama untuk mendeteksi error Blade. Tema tidak boleh dirilis
selama masih ada ❌. Setiap peringatan ⚠️ harus dibaca dan diputuskan.

## 2. Pemeriksaan manual di workbench

Jalankan `php artisan serve`, lalu gunakan customizer (tombol gerigi):

- [ ] Beranda dengan semua section aktif, lalu dengan sebagian besar section dinonaktifkan.
- [ ] Setiap variant setiap komponen, termasuk variant tambahan.
- [ ] Komponen di kolom `6/6`, `4/8`, dan `4/4/4`, serta widget di setiap kolom footer.
- [ ] Setiap halaman daftar dengan data kosong.
- [ ] Tiga warna uji: `#facc15` (terang), `#0f172a` (gelap), `#e11d48` (saturasi tinggi).
- [ ] Lebar 375px, 768px, dan 1280px, tanpa scroll horizontal.
- [ ] Navigasi dengan keyboard: fokus terlihat, menu ponsel bisa dibuka dan ditutup.

## 3. Pemeriksaan desain

Bandingkan hasil dengan Figma per komponen. Agen AI dengan skill `webuild-theme` juga bisa diminta
menjalankan pemeriksaan anti-slop dan tipografi pada file yang berubah:

```
Jalankan verifikasi skill webuild-theme pada semua file yang berubah sejak rilis terakhir.
```

## 4. Versi dan changelog

1. Naikkan `theme.json → version` (semver): patch untuk perbaikan, minor untuk variant atau
   komponen baru, major untuk perubahan tampilan besar.
2. Jangan menaikkan `api_version` melebihi yang didukung Theme Kit yang terpasang (lihat
   `php artisan theme:check`).
3. Pindahkan `[Unreleased]` di `CHANGELOG.md` ke versi baru. Pastikan bagian **New variants**,
   **New components**, dan **Proposals** lengkap.
4. Commit `dist/` hasil build dan buat tag versi:

   ```bash
   git tag v1.1.0 && git push --tags
   ```

**Jangan menghapus** section atau pilihan variant yang sudah dirilis. Theme Kit menolak pembaruan
tema yang mengurangi katalog, karena instansi yang sudah memakainya akan rusak.

## 5. Pemasangan ke webuild-app

Dijalankan oleh pengelola webuild-app dari server aplikasi:

```bash
php artisan theme:install /path/ke/tema            # pemasangan pertama
php artisan theme:update kabupaten-hijau /path/ke/tema --channel=main
php artisan theme:list                             # status dan versi tema
php artisan theme:history kabupaten-hijau          # riwayat rilis
php artisan theme:rollback kabupaten-hijau         # kembali ke rilis sebelumnya
```

Setelah terpasang, cek di admin webuild-app bahwa:
- variant tambahan muncul di form komponen sebagai "Variant tambahan dari tema",
- preset tata letak bisa dipilih,
- warna dari pengaturan tema diterapkan di seluruh halaman.
