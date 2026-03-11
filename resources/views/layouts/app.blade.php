{{-- Views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pendataan Rumah Mudik')</title>

    {{-- Tailwind CSS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Leaflet CSS sudah di-bundle via app.js (NPM) --}}
    {{-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/> --}}

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .leaflet-container { border-radius: 0.75rem; }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen">

    @yield('content')

    {{-- Leaflet JS sudah di-bundle via app.js (NPM) --}}
    {{-- <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script> --}}

    @stack('scripts')
</body>
</html>