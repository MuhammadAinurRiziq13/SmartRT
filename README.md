Berikut adalah README **yang sudah diperbarui** dengan penambahan langkah `php artisan storage:link` agar file seperti **foto struk pengeluaran** bisa diakses publik:

---

<p align="center"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></p>

# Aplikasi Administrasi RT - Laravel

Aplikasi ini digunakan untuk membantu pengelolaan rumah, penghuni, iuran bulanan, dan laporan keuangan RT. Dibangun menggunakan Laravel sebagai backend dan React sebagai frontend.

---

## 🚀 Panduan Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/nama-repo.git
cd nama-repo
```

### 2. Install Dependensi Laravel

```bash
composer install
```

### 3. Salin dan Konfigurasi File Environment

```bash
cp .env.example .env
```

Edit `.env` dan sesuaikan konfigurasi berikut:

```env
DB_DATABASE=rt_admin
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Key

```bash
php artisan key:generate
```

### 5. Migrasi dan Seeder Database

```bash
php artisan migrate --seed
```

### 6. Buat Symbolic Link untuk Storage

```bash
php artisan storage:link
```


### 7. Jalankan Server Lokal

```bash
php artisan serve
```

Akses aplikasi di `http://127.0.0.1:8000`

---

## 🧪 Data Login Default

| Role     | Email          | Password   |
| -------- | -------------- | ---------- |
| Admin RT | `admin@rt.com` | `password` |

---

## 🛠️ Fitur Utama

* Manajemen rumah dan penghuni
* Riwayat hunian (occupancy history)
* Pencatatan iuran bulanan (security & cleaning)
* Pencatatan pengeluaran
* Laporan keuangan per bulan dan tahunan

---

## ⚙️ Tools yang Digunakan

* Laravel 12+
* MySQL / MariaDB
* Faker untuk seeding data dummy
* Service-Repository pattern

---

## 📄 Lisensi

Aplikasi ini dikembangkan berdasarkan Laravel dan mengikuti lisensi [MIT](https://opensource.org/licenses/MIT).

---

Jika ingin ditambahkan **contoh endpoint API** atau **alur penggunaan aplikasi**, tinggal beri tahu.
