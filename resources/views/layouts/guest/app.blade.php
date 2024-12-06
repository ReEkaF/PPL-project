<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SMPN 2 Kamal</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    @include('layouts.guest.navigation')
    <main>
        {{ $slot }}
    </main>
    @include('layouts.guest.footer')
    <script src="https://unpkg.com/flowbite@1.6.4/dist/flowbite.min.js"></script>
</body>

</html>
