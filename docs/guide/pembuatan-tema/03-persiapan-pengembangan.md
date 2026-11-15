# 03 · Persiapan Pengembangan

Ada tiga langkah persiapan: membuat repo tema dari starter, memasang Theme Kit, dan memasang
skill untuk agen AI.

## Prasyarat

| Alat | Versi |
| --- | --- |
| PHP | 8.2 atau lebih baru |
| Composer | 2.x |
| Node.js | 22.20 atau lebih baru (dibutuhkan Vite dan `npx skills`) |
| Git | terbaru |

## 1. Buat repo tema dari starter

Buka [webuild-theme-starter](https://github.com/adilasomaaa/webuild-theme-starter) lalu klik
**Use this template → Create a new repository**. Pilih *Private* jika tema milik instansi.

Atau lewat GitHub CLI:

```bash
gh repo create tema-kabupaten-hijau --template adilasomaaa/webuild-theme-starter --private --clone
cd tema-kabupaten-hijau
```

> **Template atau fork?** Gunakan template. Fork dari repo publik akan selalu publik, membawa
> seluruh riwayat starter, dan dimaksudkan untuk mengirim perubahan balik ke starter. Pakai fork
> hanya jika Anda ingin berkontribusi pada starter itu sendiri.

## 2. Pasang Theme Kit dan jalankan workbench

Theme Kit ([`webuild/theme-kit`](https://packagist.org/packages/webuild/theme-kit)) sudah
tercantum sebagai dependensi di `composer.json` starter, jadi cukup jalankan:

```bash
composer install     # mengunduh webuild/theme-kit dari Packagist
npm install
npm run build
php artisan serve    # buka http://localhost:8000
```

Theme Kit menyediakan:
- **kontrak tema**: daftar halaman, section, dan variant dasar yang wajib ada,
- **validator** `php artisan theme:check --render`,
- **workbench**: aplikasi Laravel mini dengan data contoh dan customizer (tombol gerigi di kanan
  bawah) untuk mencoba susunan section, variant, menu, dan warna seperti di webuild-app.

Memperbarui Theme Kit:

```bash
composer update webuild/theme-kit
```

Baca `CHANGELOG` Theme Kit sebelum memperbarui versi minor atau major, karena kontrak bisa bertambah.

### Ganti key tema

Starter memakai key `starter`. Ganti dengan key tema Anda (slug huruf kecil, mis.
`kabupaten-hijau`) di semua tempat:

```bash
grep -rln "starter" theme.json composer.json src views resources
```

Yang perlu diganti: `theme.json → key/name`, `themes.starter.` di view, `@themeAssets('starter')`,
`resolveSection('starter', ...)`, `src/ThemeServiceProvider.php`, serta `name` dan namespace PSR-4
di `composer.json`. Lalu jalankan `composer dump-autoload` dan `php artisan theme:check`.

Agen AI yang sudah memasang skill `webuild-theme` bisa mengerjakan ini dengan perintah
"ganti key tema menjadi kabupaten-hijau".

## 3. Pasang skill untuk agen AI

Skill `webuild-theme` berisi aturan kontrak, sistem desain, anti-slop, dan alur kerja tema. Pasang
dengan CLI [`skills`](https://github.com/vercel-labs/skills), yang mendukung Claude Code, Codex,
Antigravity, Cursor, Gemini CLI, dan puluhan agen lain.

Jalankan dari root repo tema:

```bash
# Interaktif: pilih agen yang dipakai
npx skills add adilasomaaa/webuild-skills

# Langsung untuk agen tertentu, tanpa pertanyaan
npx skills add adilasomaaa/webuild-skills -a claude-code -a codex -a antigravity -y
```

Lokasi pemasangan (tingkat proyek):

| Agen | `-a` | Folder di repo tema |
| --- | --- | --- |
| Claude Code | `claude-code` | `.claude/skills/webuild-theme/` |
| Codex | `codex` | `.agents/skills/webuild-theme/` |
| Antigravity | `antigravity` | `.agents/skills/webuild-theme/` |
| Cursor | `cursor` | `.agents/skills/webuild-theme/` |
| Gemini CLI | `gemini-cli` | `.agents/skills/webuild-theme/` |

Pilihan yang berguna:
- `-g`: pasang untuk pengguna (semua proyek), bukan hanya repo ini.
- `--copy`: salin file, bukan symlink. Gunakan ini jika folder skill akan di-commit agar seluruh
  tim memakai versi yang sama.
- `npx skills update`: perbarui skill ke versi terbaru.

Khusus Claude Code, skill juga tersedia sebagai plugin:

```
/plugin marketplace add adilasomaaa/webuild-skills
/plugin install webuild-theme@webuild-skills
```

`AGENTS.md` di root repo dibaca otomatis oleh Codex, Cursor, dan agen lain, sedangkan `CLAUDE.md`
meneruskannya ke Claude Code. File ini berisi aturan inti dan merujuk ke skill untuk detailnya.

## Selanjutnya

Lanjut ke [04-pengembangan-tema.md](04-pengembangan-tema.md).
