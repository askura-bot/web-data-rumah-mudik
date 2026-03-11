{{-- Views/layouts/AdminLayout.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin — Patroli Mudik')</title>

    {{-- Tailwind CSS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    {{-- Leaflet CSS --}}
    {{-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/> --}}
    @stack('styles')
</head>
<body>
    @yield('content')
    {{-- Leaflet JS --}}
    {{-- <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script> --}}
    @stack('scripts')
</body>
</html>