<nav class="bg-white shadow">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <a href="{{ route('beranda.home') }}">
                <img src="{{ asset('images/beranda/logo.png') }}" alt="Logo" class="h-16">
            </a>
        </div>

        <nav class="space-x-8">
            <a href="{{ route('beranda.home') }}" class="text-gray-700 hover:text-blue-600">Home</a>
            <a href="{{ route('beranda.perpustakaanPublik') }}" class="text-gray-700 hover:text-blue-600">Perpustakaan</a>
            <a href="{{ route('beranda.tenagaPengajarPublik') }}" class="text-gray-700 hover:text-blue-600">Tenaga Pengajar</a>
            <a href="{{ route('ekstrakurikuler.dashboardEkstra') }}" class="text-gray-700 hover:text-blue-600">Ekstrakurikuler</a>
            <a href="{{ route('beranda.prestasiPublik') }}" class="text-gray-700 hover:text-blue-600">Prestasi</a>
        </nav>
        @if(session()->has('username'))
            <div class="relative">
                <button id="dropdownUserAvatar" data-dropdown-toggle="dropdownUserMenu" class="flex items-center space-x-2 text-gray-700 font-semibold focus:outline-none">
                    <svg class="w-10 h-8 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                    <span class="font-lg">{{ session('username')}}</span>
                </button>
                <div id="dropdownUserMenu" class="hidden z-10 w-44 bg-white rounded-lg shadow divide-y divide-gray-100">
                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownUserAvatar">
                        <li>
                            @if(auth()->guard('web-siswa')->check())
                                <a href="{{ route('siswa.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a>
                            @elseif(auth()->guard('web-guru')->check())
                                <a href="{{ route('guru.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a>
                            @endif
                        </li>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left text-red-700 block px-4 py-2 hover:bg-gray-100">Log out</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        @else
            <a href="{{ route("login") }}" class="inline-block px-6 py-2 text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-md rounded-lg text-md text-center transition">Login</a>
        @endif
    </div>
</nav>
