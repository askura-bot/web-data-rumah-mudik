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
- ✅ Dropdown pemilihan kecamatan 
- ✅ Upload foto rumah (opsional)
- ✅ Validasi NIK 16 digit

### Admin
- ✅ Login dengan password saja
- ✅ Tabel dengan pagination
- ✅ Filter berdasarkan kecamatan
- ✅ Cari berdasarkan NIK
- ✅ Peta sebaran semua titik rumah
- ✅ Halaman detail per rumah

---
