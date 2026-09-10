<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SST SMPN 2 Kamal') }} - Perpustakaan</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-800">
    @include('layouts.staff_perpus.navigation')
    <div class="flex pt-16 overflow-hidden bg-slate-50">
        @include('layouts.staff_perpus.sidebar')
        <div class="fixed inset-0 z-10 hidden bg-slate-900/50" id="sidebarBackdrop"></div>
        <div id="main-content" class="relative w-full h-full overflow-y-auto bg-slate-50 lg:ml-64 min-h-screen flex flex-col justify-between">
            <!-- Page Content -->
            <main class="p-4 md:p-6 flex-1">
                @include('staff_perpus.komponen.alert')
                {{ $slot }}
            </main>

            @include('layouts.staff_perpus.footer')
        </div>
    </div>
</body>

</html>
