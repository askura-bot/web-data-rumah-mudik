# 🏠 Pendataan Rumah Mudik

Sistem pendataan rumah yang ditinggal mudik berbasis Laravel + Tailwind CSS + Leaflet.js.

---

## 🗺️ Tentang Maps (GRATIS, Tanpa API Key!)

Project ini menggunakan:
| Komponen | Library | Biaya |
|---|---|---|
| Tampilan peta | **Leaflet.js** (open source) | Gratis |
| Tile/gambar peta | **OpenStreetMap** | Gratis |
| Koordinat → Alamat | **Nominatim API** (OpenStreetMap) | Gratis |
| GPS perangkat | Browser Geolocation API | Gratis |

**Tidak butuh Google Maps API Key** → tidak ada biaya sama sekali!

---

## ⚙️ Cara Setup

### 1. Clone & Install

```bash
git clone <repo-url> rumah-mudik
cd rumah-mudik
composer install
npm install
```

### 2. Konfigurasi .env

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:
```env
DB_DATABASE=rumah_mudik
DB_USERNAME=root
DB_PASSWORD=your_password
ADMIN_PASSWORD=password_rahasia_anda
```

### 3. Tambahkan config admin di `config/app.php`

Buka `config/app.php` dan tambahkan di dalam array return:
```php
'admin_password' => env('ADMIN_PASSWORD', 'admin123'),
```

### 4. Register Middleware

Buka `bootstrap/app.php` (Laravel 11) atau `app/Http/Kernel.php` (Laravel 10):

**Laravel 11** – tambahkan di `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin.auth' => \App\Http\Middleware\AdminAuth::class,
    ]);
})
```

**Laravel 10** – tambahkan di `$routeMiddleware` dalam `app/Http/Kernel.php`:
```php
'admin.auth' => \App\Http\Middleware\AdminAuth::class,
```

> **Catatan:** Di `routes/web.php` sudah menggunakan class langsung (`AdminAuth::class`), jadi alias opsional.

### 5. Migrasi & Seeder

```bash
php artisan migrate
php artisan db:seed --class=WilayahSeeder
```

Seeder sudah berisi data **7 kabupaten/kota di Jawa Tengah** (Kota Semarang, Kab. Semarang, Kab. Demak, Kab. Kendal, Kota Salatiga, Kab. Grobogan, Kab. Boyolali).

Untuk menambah kabupaten/kecamatan lain, edit file `database/seeders/WilayahSeeder.php`.

### 6. Storage Link (untuk foto rumah)

```bash
php artisan storage:link
```

### 7. Build Assets

```bash
npm run dev   # development
npm run build # production
```

### 8. Jalankan Server

```bash
php artisan serve
```

---

## 📁 Struktur File Penting

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── UserController.php      # Form user & API kecamatan
│   │   └── AdminController.php     # Dashboard admin
│   └── Middleware/
│       └── AdminAuth.php           # Proteksi halaman admin
├── Models/
│   ├── RumahMudik.php
│   ├── Kabupaten.php
│   └── Kecamatan.php

resources/views/
├── layouts/app.blade.php           # Layout utama
├── user/
│   ├── form.blade.php              # Form pendaftaran (+ peta Leaflet)
│   └── success.blade.php
└── admin/
    ├── login.blade.php
    ├── dashboard.blade.php         # Tabel + peta semua titik
    └── detail.blade.php            # Detail 1 rumah

database/
├── migrations/
│   ├── ..._create_rumah_mudik_table.php
│   └── ..._create_wilayah_tables.php
└── seeders/
    └── WilayahSeeder.php
```

---

## 🔐 Akses

| Role | URL | Credential |
|---|---|---|
| User | `/` | Tidak perlu login |
| Admin | `/admin/login` | Password dari `.env` `ADMIN_PASSWORD` |

---

## ✨ Fitur

### User
- ✅ Peta interaktif dengan GPS otomatis (Leaflet + OpenStreetMap)
- ✅ Geser marker untuk akurasi lokasi
- ✅ Alamat terisi otomatis via Nominatim (reverse geocoding)
- ✅ Dropdown kecamatan dinamis berdasarkan kabupaten
- ✅ Upload foto rumah (opsional)
- ✅ Validasi NIK 16 digit

### Admin
- ✅ Login dengan password saja
- ✅ Tabel dengan pagination
- ✅ Filter kabupaten + kecamatan
- ✅ Cari berdasarkan NIK
- ✅ Peta sebaran semua titik rumah
- ✅ Halaman detail per rumah

---

## 📦 Menambah Wilayah

Edit `database/seeders/WilayahSeeder.php`, tambahkan entri baru:

```php
'Kabupaten Baru' => [
    'Kecamatan A', 'Kecamatan B', 'Kecamatan C',
],
```

Lalu jalankan ulang seeder:
```bash
php artisan db:seed --class=WilayahSeeder
```

Atau langsung insert via `php artisan tinker`:
```php
$kab = App\Models\Kabupaten::create(['nama' => 'Kabupaten Baru']);
App\Models\Kecamatan::insert([
    ['kabupaten_id' => $kab->id, 'nama' => 'Kecamatan A', 'created_at' => now(), 'updated_at' => now()],
]);
```
