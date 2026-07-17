# Courier Management API

[![Laravel Version](https://img.shields.io/badge/laravel->=11.x-red.svg)](https://laravel.com)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

Sebuah layanan RESTful API yang andal, ringan, dan berkinerja tinggi yang dibangun menggunakan Laravel untuk mengelola master data logistik kurir/driver. Mikro-modul ini menyediakan fitur pengurutan lanjutan, pencarian kata kunci multi-kata (parsial), penyaringan tingkat kemampuan multi-level, dan validasi data standar industri.

Didesain khusus sebagai modul backend tanpa kepala (Headless/No UI), sistem ini menggunakan SQLite untuk operasi yang sangat cepat dan penerapan tanpa konfigurasi yang rumit.

---

## 🛠️ Fitur Arsitektur Utama

- **Arsitektur Backend Terpisah**: Representasi API Resource yang bersih, sepenuhnya independen dari pustaka Frontend mana pun.
- **Mesin Pencarian & Filter Canggih**:
  - **Pencarian Multi-Kata Dinamis**: Memecah fragmen query secara cerdas (misal: ?search=budi+agung) untuk mencocokkan variasi teks yang panjang (misal: Budiono Hadi Agung).
  - **Filter Larik Kategoris**: Memungkinkan evaluasi komposit tingkatan kurir secara bersamaan (misal: ?level=2,3).
  - **Pengurutan Fleksibel**: Beralih dengan mulus antara pengurutan alfabetis (name) dan jejak audit kronologis (created_at).
- **Cakupan Pengujian Fitur Lengkap**: Rangkaian pengujian terotomatisasi yang mengevaluasi jalur eksekusi positif, kasus ekstrem (edge cases), dan batas validasi permintaan.

---

## 🏗️ Cetak Biru Teknis & Skema

Lapisan data memetakan node kurir logistik dengan batasan inti berikut:

| Kolom | Tipe Data | Atribut / Batasan | Deskripsi |
| :--- | :--- | :--- | :--- |
| id | BigInteger | Primary Key, Auto-Increment | Identifikasi unik kurir. |
| name | String | Wajib, Maks: 255 | Nama resmi kurir. |
| phone_number | String | Wajib, Unik, Maks: 20 | Nomor kontak unik kurir. |
| vehicle_type | String | Wajib, Maks: 50 | Kategori kendaraan (misal: Motorcycle, Van). |
| level | TinyInteger | Wajib, Default: 1, Rentang: 1-5 | Klasifikasi tingkatan operasional kurir. |
| is_active | Boolean | Default: true | Penanda status ketersediaan operasional. |
| timestamps | Datetime | Bawaan Laravel | Melacak waktu data dibuat & diperbarui (created_at, updated_at). |

---

## 🚀 Panduan Memulai (Pengembangan Lokal)

### Prasyarat
Pastikan lingkungan server Anda memenuhi standar berikut:
- PHP >= 8.2 (dengan ekstensi JSON, SQLite, dan PDO aktif)
- Composer Package Manager

### 1. Intalasi & Konfigurasi Lingkungan
Klon repositori resmi langsung dari GitHub:
git clone https://github.com/machrusali/courier-api.git
cd courier-api

Salin konfigurasi lingkungan:
cp .env.example .env

Pastikan berkas .env Anda berisi spesifikasi driver SQLite berikut:
DB_CONNECTION=sqlite

### 2. Pemasangan Dependensi & Migrasi Database
Instal dependensi package, buat berkas database lokal SQLite, dan jalankan migrasi skema tabel:
composer install
touch database/database.sqlite
php artisan migrate

### 3. Menjalankan Aplikasi
Jalankan server HTTP lokal:
php artisan serve

Koleksi endpoint API sekarang aktif dan siap menerima permintaan di http://127.0.0.1:8000/api.

---

## 📌 Panduan Referensi API

Setiap permintaan wajib menyertakan header Accept: application/json.

### 🔹 1. Ambil Koleksi Data (Fetch Collection)
- Metode HTTP: GET
- Jalur URI: /api/couriers
- Parameter Query yang Didukung:
  - sort: Menentukan strategi urutan (name [Default] atau created_at).
  - search: Pencarian teks. Memecah istilah secara dinamis (misal: ?search=budi+agung).
  - level: Memfilter beberapa level sekaligus menggunakan pemisah koma (misal: ?level=2,3).

### 🔹 2. Tambah Data (Create Instance)
- Metode HTTP: POST
- Jalur URI: /api/couriers
- Format JSON Payload:
{
    "name": "Budiono Hadi Agung",
    "phone_number": "081234567890",
    "vehicle_type": "Motorcycle",
    "level": 3
}

### 🔹 3. Ambil Detail Data (Retrieve Instance)
- Metode HTTP: GET
- Jalur URI: /api/couriers/{id}

### 🔹 4. Perbarui Data (Update State)
- Metode HTTP: PUT / PATCH
- Jalur URI: /api/couriers/{id}

### 🔹 5. Hapus Data (Terminate Instance)
- Metode HTTP: DELETE
- Jalur URI: /api/couriers/{id}

---

## 🧪 Rangkaian Pengujian Otomatis (Automated Testing)

Sistem ini menerapkan pengujian terisolasi untuk menjaga integritas kode. Untuk menjalankan seluruh rangkaian uji fitur pada controller dan filter, jalankan perintah:

php artisan test

---

## 📸 Bukti Hasil Running Test (All Green)

Seluruh unit dan fitur pada API ini telah diuji secara otomatis dan lulus pengujian 100%. 

Kamu dapat melihat gambar bukti pengujian melalui tautan berikut:
👉 **[Lihat Screenshot Hasil Pengujian (test-done.png)](./screenshots/test-done.png)**