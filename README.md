# Courier Management API (Laravel + SQLite)

Repositori ini dibuat untuk memenuhi persyaratan **Test Programming: Modul Master Data Kurir (Courier)**. Project ini dibangun menggunakan framework Laravel dengan database SQLite serta mengimplementasikan API CRUD, filtrasi lanjutan, pencarian multi-kata, pengurutan kustom, pencatatan otomatis, dan *Automated Feature Testing*.

Project ini murni berbasis API (Backend Only) dan tidak menyediakan komponen UI (HTML/CSS/JS) sesuai dengan instruksi pada dokumen brief.

---

## 🛠️ Fitur & Spesifikasi Sesuai Brief

1. **Master Data Kurir (Couriers Table)**:
   - `name`: Nama Kurir (String)
   - `phone_number`: Nomor Telepon Unik (String)
   - `vehicle_type`: Tipe Kendaraan (String)
   - `level`: Tingkatan Kurir 1 s/d 5 (TinyInteger)
   - `is_active`: Status Aktif (Boolean)
   - `timestamps`: Tanggal Dibuat & Diperbarui (`created_at`, `updated_at`)

2. **Fitur Endpoint Index (`GET /api/couriers`)**:
   - **Pagination**: Otomatis membagi hasil dalam beberapa halaman (Default: 10 data per halaman).
   - **Default Sort**: Hasil diurutkan berdasarkan Nama Kurir (`name`) secara ascending.
   - **Override Sort**: Frontend dapat meminta urutan berdasarkan tanggal didaftarkan menggunakan parameter `?sort=created_at`.
   - **Multi-word Search Matching**: Pencarian pintar menggunakan parameter `?search=budi+agung` yang dapat mencocokkan nama panjang seperti `Budiono Hadi Agung`.
   - **Multi-level Filtering**: Memfilter kurir berdasarkan tingkatan tertentu menggunakan parameter koma, contoh: `?level=2,3`.

3. **Validasi & Integritas Data**:
   - Validasi ketat pada `store` dan `update`.
   - Validasi level wajib berada di rentang angka 1-5.
   - Validasi keunikan `phone_number` untuk mencegah duplikasi data di database.

4. **Automated Testing**:
   - Dilengkapi dengan *Feature Tests* (`tests/Feature/CourierApiTest.php`) untuk memastikan seluruh alur CRUD, skenario kegagalan validasi, pencarian, pengurutan, serta penghapusan data berfungsi 100% dan terisolasi dengan baik.

---

## 🚀 Cara Menjalankan Project Local

Pastikan komputer Anda sudah terinstal **PHP (>= 8.2)** dan **Composer**. Karena project ini menggunakan **SQLite**, Anda tidak memerlukan server MySQL/PostgreSQL tambahan.

### 1. Clone Repositori
```bash
git clone [https://github.com/USERNAME_ANDA/NAMA_REPO_ANDA.git](https://github.com/USERNAME_ANDA/NAMA_REPO_ANDA.git)
cd NAMA_REPO_ANDA