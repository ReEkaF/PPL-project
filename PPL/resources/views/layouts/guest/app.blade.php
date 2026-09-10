<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'SMPN 2 Kamal - Sistem Sekolah Terintegrasi' }}</title>
    <meta name="description" content="Portal Resmi dan Sistem Sekolah Terintegrasi SMPN 2 Kamal - Bangkalan, Jawa Timur.">

    <link rel="icon" href="{{ asset('images/logo.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex flex-col bg-slate-50 text-slate-800 font-sans antialiased selection:bg-brand-100 selection:text-brand-900">
    @include('layouts.guest.navigation')

    <main class="flex-1">
        {{ $slot }}
    </main>

    @include('layouts.guest.footer')
</body>

</html>