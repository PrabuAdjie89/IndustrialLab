# Sistem Informasi Laboratorium Teknik Industri UMS

Sistem Informasi Laboratorium Teknik Industri Universitas Muhammadiyah Surakarta merupakan aplikasi berbasis web yang dikembangkan untuk membantu proses pengelolaan data laboratorium, meliputi inventaris barang, peminjaman barang, peminjaman ruangan, dokumentasi, serta pengelolaan laporan.

Aplikasi ini dikembangkan menggunakan framework Laravel sebagai backend dan menggunakan database MySQL sebagai media penyimpanan data.

---

# Teknologi yang Digunakan

## Backend
- Laravel Framework 10.49.1
- PHP 8.1.25

## Database
- MySQL

## Frontend
- Blade Template
- Bootstrap
- JavaScript

## Tools
- Composer
- Node.js & NPM
- XAMPP
- Git

---

# Package Laravel yang Digunakan

| Package | Fungsi |
|---|---|
| barryvdh/laravel-dompdf | Export laporan ke format PDF |
| maatwebsite/excel | Export laporan ke format Excel |
| simplesoftwareio/simple-qrcode | Generate QR Code barang |
| realrashid/sweet-alert | Alert dan konfirmasi aksi |
| laravel/sanctum | Authentication |
| laravel/socialite | Login menggunakan Google |
| laravel/ui | Authentication scaffolding |
| resend/resend-laravel | Pengiriman email |

---

# Fitur Sistem

## Manajemen Pengguna
- Login pengguna
- Registrasi akun
- Verifikasi email
- Hak akses berdasarkan role pengguna

## Inventaris Laboratorium
- Pengelolaan data barang
- Pengelompokan kategori barang
- Data barang masuk
- Data barang keluar
- Upload dokumentasi barang
- Generate QR Code barang

## Peminjaman Barang
- Pengajuan peminjaman barang
- Pengelolaan status peminjaman
- Riwayat peminjaman barang

## Peminjaman Ruangan
- Pengelolaan jadwal penggunaan ruangan
- Pencatatan informasi peminjaman ruangan

## Laporan
- Export laporan Excel
- Export laporan PDF

---

# Persyaratan Sistem

Sebelum menjalankan aplikasi, pastikan perangkat telah memiliki:

- PHP >= 8.1
- Composer
- MySQL
- XAMPP
- Node.js dan NPM
- Web Browser

---

# Instalasi

## 1. Clone Repository

Clone repository menggunakan Git:

```bash
git clone https://github.com/PrabuAdjie89/IndustrialLab.git
```

Masuk ke folder project:

```bash
cd IndustrialLab
```

---

# 2. Install Dependency Laravel

Install seluruh package Laravel yang dibutuhkan menggunakan Composer:

```bash
composer install
```

Perintah ini akan menginstall seluruh dependency berdasarkan file `composer.json`.

---

# 3. Install Dependency Frontend

Install package frontend menggunakan NPM:

```bash
npm install
```

Kemudian jalankan proses build frontend:

```bash
npm run build
```

atau untuk mode development:

```bash
npm run dev
```

---

# 4. Konfigurasi Environment

Buat file `.env` dari file `.env.example`:

```bash
copy .env.example .env
```

atau pada Linux/Mac:

```bash
cp .env.example .env
```

Kemudian buka file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laboratory_app
DB_USERNAME=root
DB_PASSWORD=
```

---

# 5. Membuat Database

Buka XAMPP kemudian aktifkan:

- Apache
- MySQL

Buat database baru melalui phpMyAdmin:

```
laboratory_app
```

---

# 6. Generate Application Key

Jalankan perintah:

```bash
php artisan key:generate
```

---

# 7. Migrasi Database

Untuk membuat tabel database jalankan:

```bash
php artisan migrate --seed
```

Perintah ini akan membuat struktur tabel dan data awal sistem.

---

# 8. Konfigurasi Storage

Sistem menggunakan Laravel Storage untuk menyimpan file atau gambar.

Jalankan:

```bash
php artisan storage:link
```

Perintah ini membuat symbolic link dari:

```
storage/app/public
```

ke:

```
public/storage
```

sehingga file dapat diakses melalui browser.

---

# 9. Konfigurasi Email

Untuk menggunakan fitur pengiriman email, konfigurasi SMTP pada file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.googlemail.com
MAIL_PORT=587
MAIL_USERNAME=email_pengirim
MAIL_PASSWORD=password_aplikasi
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=email_pengirim
MAIL_FROM_NAME="${APP_NAME}"
```

Sesuaikan konfigurasi email dengan akun SMTP yang digunakan.

---

# 10. Menjalankan Aplikasi

Jalankan server Laravel:

```bash
php artisan serve
```

Kemudian buka browser:

```
http://127.0.0.1:8000
```

---

# Akun Pengguna

Akun pengguna dapat dibuat melalui halaman registrasi atau menggunakan data awal dari database seeder.

Contoh role pengguna:

| Role | Akses |
|---|---|
| Kepala Laboratorium | Melihat dan mengelola informasi laboratorium |
| Ketua Program Studi | Melihat informasi dan laporan |
| Laboran | Mengelola inventaris dan peminjaman |
| Asisten Laboratorium | Mengelola kebutuhan operasional laboratorium |
| Mahasiswa | Melakukan peminjaman |

---

# Pengujian Sistem

Pengujian sistem dilakukan menggunakan:

## Blackbox Testing

Digunakan untuk memastikan setiap fungsi sistem berjalan sesuai dengan kebutuhan.

## Usability Testing

Pengujian dilakukan berdasarkan aspek:

- Usefulness
- Ease of Use
- Ease of Learning
- Satisfaction

---

# Struktur Database

Sistem menggunakan database relasional MySQL dengan beberapa tabel utama:

- Users
- Barang
- Kategori Barang
- Barang Masuk
- Barang Keluar
- Peminjaman Barang
- Peminjaman Ruangan
- Dan tabel pendukung lainnya

---

# Catatan

- File `.env` tidak disertakan dalam repository karena berisi konfigurasi database dan informasi sensitif.
- Gunakan file `.env.example` sebagai template konfigurasi.
- Folder `vendor` dan `node_modules` tidak disertakan karena dapat dibuat ulang menggunakan Composer dan NPM.

---

# Developer

**Prabu Adji Satria Wibawa**  
Program Studi Teknik Industri  
Universitas Muhammadiyah Surakarta