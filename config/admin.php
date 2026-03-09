<?php

// Tambahkan baris ini di dalam array return pada config/app.php Laravel Anda:
// File ini hanya menunjukkan bagian yang perlu ditambahkan, bukan file lengkap.

return [
    // ... konfigurasi lainnya ...

    /*
    |--------------------------------------------------------------------------
    | Admin Password
    |--------------------------------------------------------------------------
    | Password untuk akses halaman admin. Simpan di .env dengan key ADMIN_PASSWORD
    */
    'admin_password' => env('ADMIN_PASSWORD', 'admin123'),

    // ... konfigurasi lainnya ...
];
