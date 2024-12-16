<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- <link rel="stylesheet" href="{{ asset('build/assets/app-cAc1bIIl.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/app-BgO_RYd7.css') }}"> -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" /> --}}
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
    @font-face {
        font-family: 'Poppins';
        font-style: normal;
        font-weight: 400;
        src: url('../fonts/poppins-v15-latin-regular.eot');
        /* IE9 Compat Modes */
        src: local(''),
            url('../fonts/poppins-v15-latin-regular.eot?#iefix') format('embedded-opentype'),
            /* IE6-IE8 */
            url('../fonts/poppins-v15-latin-regular.woff2') format('woff2'),
            /* Super Modern Browsers */
            url('../fonts/poppins-v15-latin-regular.woff') format('woff'),
            /* Modern Browsers */
            url('../fonts/poppins-v15-latin-regular.ttf') format('truetype'),
            /* Safari, Android, iOS */
            url('../fonts/poppins-v15-latin-regular.svg#Poppins') format('svg');
        /* Legacy iOS */
    }

    .page-btn {
        width: 2rem;
        height: 2rem;
        background-color: #D9D9D9;
        color: rgb(0, 0, 0);
        font-family: "Poppins";
        font-weight: 800;
        line-height: 24px;
        margin: 0 0.3rem 0 0.3rem;
    }

    .active {
        color: #4285F4;

    }

    .invisible {
        display: none;
    }

    #page-numbers {
        @media (max-width: 640px) {
            display: none;
        }
    }
</style>

<body class="bg-gray-50 dark:bg-gray-800">
    @include('layouts.staff_perpus.navigation')
    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
        @include('layouts.staff_perpus.sidebar')
        <div class="fixed inset-0 z-10 hidden bg-gray-900/50 dark:bg-gray-900/90" id="sidebarBackdrop"></div>
        <div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
            <!-- Page Content -->
            <main>
                @include('staff_perpus.komponen.alert')
                {{ $slot }}
            </main>

            @include('layouts.staff_perpus.footer')
        </div>
    </div>
    <!-- <script src="{{asset('build/asset/app-CMQILbDN.js')}}"></script> -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://flowbite-admin-dashboard.vercel.app//app.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.2/datepicker.min.js"></script>
</body>

</html>
