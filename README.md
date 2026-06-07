<p align="center">
  <img src="public/img/logo.svg" height="150" alt="LPK Seishin Logo">
</p>

<h1 align="center">LPK Seishin - Management System</h1>

<p align="center">
  <a href="https://php.net"><img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP"></a>
  <a href="https://laravel.com"><img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel"></a>
  <a href="https://tailwindcss.com"><img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="TailwindCSS"></a>
  <a href="https://alpinejs.dev/"><img src="https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white" alt="AlpineJS"></a>
</p>

<p align="center">
  Sistem Informasi Manajemen untuk <strong>LPK Seishin</strong> yang dibangun menggunakan framework Laravel, dilengkapi dengan penyimpanan AWS S3.
</p>

---

## ✨ Fitur Utama

- 🔐 **Autentikasi Aman** - Dibangun dengan Laravel Breeze untuk keamanan maksimal.
- ☁️ **Cloud Storage** - Penyimpanan berkas dan media menggunakan layanan handal AWS S3.
- 📊 **Tabel Data Interaktif** - Dikelola dengan Yajra DataTables untuk performa pencarian dan pengurutan data berskala besar yang instan.
- 🎨 **Antarmuka Modern** - Desain responsif, indah, dan interaktif menggunakan Tailwind CSS & Alpine.js.

## 🛠️ Tech Stack

- **Backend:** Laravel 12.x, PHP 8.2+
- **Frontend:** Tailwind CSS, Alpine.js, Vite
- **Database:** SQLite / MySQL / PostgreSQL
- **Integrasi Pihak Ketiga:** AWS SDK PHP

---

## 🚀 Cara Instalasi (Getting Started)

Ikuti langkah-langkah di bawah ini untuk mengunduh dan menjalankan proyek ini di lingkungan lokal Anda.

### Persyaratan Sistem (Prerequisites)

Pastikan Anda telah menginstal perangkat lunak berikut sebelum memulai:
- [PHP](https://www.php.net/downloads) (Versi >= 8.2)
- [Composer](https://getcomposer.org/download/)
- [Node.js & NPM](https://nodejs.org/en/download/)
- Database Server (MySQL/PostgreSQL) *atau gunakan SQLite untuk pengembangan lokal yang lebih mudah*

### Langkah-langkah Instalasi

**1. Clone Repository**
Unduh proyek ke komputer lokal Anda menggunakan git.
```bash
git clone https://github.com/username/lpkseishin.git
cd lpkseishin
```
*(Ganti tautan di atas dengan tautan repository Github asli Anda)*

**2. Install Dependensi PHP (Composer)**
Instal paket-paket backend yang dibutuhkan oleh Laravel.
```bash
composer install
```

**3. Install Dependensi Frontend (NPM)**
Instal paket-paket frontend yang dibutuhkan untuk antarmuka pengguna.
```bash
npm install
```

**4. Konfigurasi Environment**
Salin file konfigurasi bawaan dan sesuaikan dengan kredensial milik Anda.
```bash
cp .env.example .env
```
*(Buka file `.env` di text editor (seperti VS Code) dan sesuaikan konfigurasi Database dan AWS S3)*

**5. Generate Application Key**
Buat kunci aplikasi unik yang digunakan Laravel untuk enkripsi sesi dan data lainnya.
```bash
php artisan key:generate
```

**6. Jalankan Migrasi Database**
Siapkan struktur tabel database yang dibutuhkan oleh aplikasi.
```bash
php artisan migrate
```

**7. Build Aset Frontend**
Kompilasi CSS dan JavaScript.
```bash
# Biarkan berjalan di background untuk pengembangan (development mode)
npm run dev

# ATAU kompilasi untuk production
npm run build
```

**8. Jalankan Local Server**
Buka terminal baru dan nyalakan server lokal Laravel.
```bash
php artisan serve
```

Aplikasi sekarang sudah berjalan! Silakan buka browser Anda dan akses `http://localhost:8000`. 🎉

---

## 🔒 Konfigurasi Tambahan

### Pengaturan AWS S3
Tambahkan kredensial AWS Anda di file `.env` untuk mengaktifkan fitur upload ke cloud:
```env
AWS_ACCESS_KEY_ID=kunci_akses_anda
AWS_SECRET_ACCESS_KEY=kunci_rahasia_anda
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=nama_bucket_anda
```

---

<p align="center">
  Dibuat dengan ❤️ untuk operasional LPK Seishin yang lebih baik.
</p>
