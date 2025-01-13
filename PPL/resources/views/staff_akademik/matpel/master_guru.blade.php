<x-staffakademik-layout>
    <!doctype html>
    <html lang="en" class="dark">
      <head>
        <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Get started with a free and open-source admin dashboard layout built with Tailwind CSS and Flowbite featuring charts, widgets, CRUD layouts, authentication pages, and more">
    <meta name="author" content="Themesberg">
    <meta name="generator" content="Hugo 0.58.2">
    
    <title>Tailwind CSS Products Page - Flowbite</title>
    
    <link rel="canonical" href="https://flowbite-admin-dashboard.vercel.app/crud/products/">
    
    
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://flowbite-admin-dashboard.vercel.app//app.css">
    <link rel="apple-touch-icon" sizes="180x180" href="https://flowbite-admin-dashboard.vercel.app/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://flowbite-admin-dashboard.vercel.app/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://flowbite-admin-dashboard.vercel.app/favicon-16x16.png">
    <link rel="icon" type="image/png" href="https://flowbite-admin-dashboard.vercel.app/favicon.ico">
    <link rel="manifest" href="https://flowbite-admin-dashboard.vercel.app/site.webmanifest">
    <link rel="mask-icon" href="https://flowbite-admin-dashboard.vercel.app/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <!-- Twitter -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@">
    <meta name="twitter:creator" content="@">
    <meta name="twitter:title" content="Tailwind CSS Products Page - Flowbite">
    <meta name="twitter:description" content="Get started with a free and open-source admin dashboard layout built with Tailwind CSS and Flowbite featuring charts, widgets, CRUD layouts, authentication pages, and more">
    <meta name="twitter:image" content="https://flowbite-admin-dashboard.vercel.app/images/og-image.png">
    
    <!-- Facebook -->
    <meta property="og:url" content="https://flowbite-admin-dashboard.vercel.app/crud/products/">
    <meta property="og:title" content="Tailwind CSS Products Page - Flowbite">
    <meta property="og:description" content="Get started with a free and open-source admin dashboard layout built with Tailwind CSS and Flowbite featuring charts, widgets, CRUD layouts, authentication pages, and more">
    <meta property="og:type" content="article">
    <meta property="og:image" content="https://flowbite-admin-dashboard.vercel.app/images/og-image.png">
    <meta property="og:image:type" content="image/png">

    <script>
        
        // if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        //     document.documentElement.classList.add('dark');
        // } else {
        //     document.documentElement.classList.remove('dark')
        // }
    </script> 
        <main>
            <div id="notification-container" class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50"> 
                <!-- Notifikasi Sukses (Tambah Data) -->
                @if(session('success'))
                <div id="toast-success" class="flex items-center w-full max-w-xs p-4 mb-4 text-white bg-blue-600 rounded-lg shadow dark:bg-blue-700">
                    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 bg-blue-800 rounded-lg">
                        <svg class="w-5 h-5 text-white" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        </svg>
                        <span class="sr-only">Success</span>
                    </div>
                    <div class="ms-3 text-sm font-normal">{{ session('success') }}</div>
                    <button type="button" onclick="closeToast()" class="ms-auto -mx-1.5 -my-1.5 bg-transparent text-white hover:text-gray-300 rounded-lg p-1.5">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                @endif
                 
                <!-- Notifikasi Update -->
                @if(session('update'))
                <div id="toast-update" class="flex items-center w-full max-w-xs p-4 mb-4 text-white bg-green-600 rounded-lg shadow dark:bg-green-700">
                    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 bg-green-800 rounded-lg">
                        <svg class="w-5 h-5 text-white" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 1 1 1.414 1.414Z"/>
                        </svg>
                        <span class="sr-only">Update</span>
                    </div>
                    <div class="ms-3 text-sm font-normal">{{ session('update') }}</div>
                    <button type="button" onclick="closeToast()" class="ms-auto -mx-1.5 -my-1.5 bg-transparent text-white hover:text-gray-300 rounded-lg p-1.5">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                @endif
                 
                <!-- Notifikasi Bahaya (Hapus Data) -->
                @if(session('danger'))
                <div id="toast-danger" class="flex items-center w-full max-w-xs p-4 mb-4 text-white bg-red-600 rounded-lg shadow dark:bg-red-700">
                    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 bg-red-800 rounded-lg">
                        <svg class="w-5 h-5 text-white" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                        </svg>
                        <span class="sr-only">Danger</span>
                    </div>
                    <div class="ms-3 text-sm font-normal">{{ session('danger') }}</div>
                    <button type="button" onclick="closeToast()" class="ms-auto -mx-1.5 -my-1.5 bg-transparent text-white hover:text-gray-300 rounded-lg p-1.5">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                @endif
            </div>
            
            <div class="p-4 bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <div class="w-full mb-1">
                    <div class="mb-4">
                        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Penugasan Guru Mata Pelajaran</h1>
                    </div>
                    <div class="items-center justify-between block sm:flex">
                        <form class="sm:pr-3" action="{{ route('staff_akademik.guru_mata_pelajaran.index') }}" method="GET">
                            <label for="search" class="sr-only">Cari Penugasan</label>
                            <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                                <input type="text" name="search" id="search" value="{{ request()->get('search') }}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Cari penugasan">
                            </div>
                        </form>
                        <button type="button" onclick="document.getElementById('crud-modal').classList.remove('hidden')" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Tambah Penugasan
                        </button>
                    </div>
                </div>
            </div>
        
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">No</th>
                                <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Nama Guru</th>
                                <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Mata Pelajaran</th>
                                <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:bg-gray-800 dark:divide-gray-700">
                            @forelse($guruMataPelajaran as $index => $penugasan)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="p-4 text-sm text-gray-500 dark:text-gray-400">{{ $index + 1 + ($guruMataPelajaran->currentPage() - 1) * $guruMataPelajaran->perPage() }}</td>
                                    <td class="p-4 text-sm text-gray-900 dark:text-white">{{ $penugasan->guru->nama_guru }}</td>
                                    <td class="p-4 text-sm text-gray-900 dark:text-white">{{ $penugasan->mataPelajaran->nama_matpel }}</td>
                                    <td class="p-4 space-x-2 whitespace-nowrap">
                                        <!-- Button untuk membuka modal edit -->
                                        <button type="button" onclick="document.getElementById('edit-modal-{{ $penugasan->id_guru_mata_pelajaran }}').classList.remove('hidden')" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                            Update
                                        </button>

                                        <!-- Modal Edit -->
                                        <div id="edit-modal-{{ $penugasan->id_guru_mata_pelajaran }}" class="hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full p-4 h-full bg-black bg-opacity-50">
                                            <div class="relative w-full max-w-md bg-white rounded-lg shadow dark:bg-gray-700">
                                                <button type="button" onclick="document.getElementById('edit-modal-{{ $penugasan->id_guru_mata_pelajaran }}').classList.add('hidden')" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 rounded-lg text-sm w-8 h-8 dark:hover:bg-gray-600">
                                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414 1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                                <form method="POST" action="{{ route('staff_akademik.guru_mata_pelajaran.update', $penugasan->id_guru_mata_pelajaran) }}" class="p-6">
                                                    @csrf
                                                    @method('PUT')
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Penugasan</h3>
                                                    <div class="mt-4">
                                                        <label for="edit_guru_id_{{ $penugasan->id_guru_mata_pelajaran }}" class="block text-sm font-medium text-gray-700 dark:text-white">Pilih Guru</label>
                                                        <select name="guru_id" id="edit_guru_id_{{ $penugasan->id_guru_mata_pelajaran }}" class="block w-full mt-1 bg-gray-50 border border-gray-300 rounded-md dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                                            @foreach($gurus as $guru)
                                                                <option value="{{ $guru->id_guru }}" {{ $guru->id_guru == $penugasan->guru_id ? 'selected' : '' }}>{{ $guru->nama_guru }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mt-4">
                                                        <label for="edit_matpel_id_{{ $penugasan->id_guru_mata_pelajaran }}" class="block text-sm font-medium text-gray-700 dark:text-white">Pilih Mata Pelajaran</label>
                                                        <select name="matpel_id" id="edit_matpel_id_{{ $penugasan->id_guru_mata_pelajaran }}" class="block w-full mt-1 bg-gray-50 border border-gray-300 rounded-md dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                                            @foreach($mataPelajaran as $matpel)
                                                                <option value="{{ $matpel->id_matpel }}" {{ $matpel->id_matpel == $penugasan->matpel_id ? 'selected' : '' }}>{{ $matpel->nama_matpel }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="w-full px-5 py-2 mt-4 font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">Update Penugasan</button>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Tombol Hapus -->
                                        <form method="POST" action="{{ route('staff_akademik.guru_mata_pelajaran.destroy', $penugasan->id_guru_mata_pelajaran) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                                                Delete
                                            </button>
                                        </form>
                                    </td>                                 
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-center text-gray-500 dark:text-gray-400">Tidak ada data penugasan ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $guruMataPelajaran->links() }}
                    </div>
                </div>
            </div>

            <!-- Modal Tambah -->
            <div id="crud-modal" class="hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full p-4 h-full bg-black bg-opacity-50">
                <div class="relative w-full max-w-md bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button" onclick="document.getElementById('crud-modal').classList.add('hidden')" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 rounded-lg text-sm w-8 h-8 dark:hover:bg-gray-600">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414 1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <form method="POST" action="{{ route('staff_akademik.guru_mata_pelajaran.store') }}" class="p-6">
                        @csrf
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Penugasan</h3>
                        <div class="mt-4">
                            <label for="guru_id" class="block text-sm font-medium text-gray-700 dark:text-white">Pilih Guru</label>
                            <select name="guru_id" id="guru_id" class="block w-full mt-1 bg-gray-50 border border-gray-300 rounded-md dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                @foreach($gurus as $guru)
                                    <option value="{{ $guru->id_guru }}">{{ $guru->nama_guru }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <label for="matpel_id" class="block text-sm font-medium text-gray-700 dark:text-white">Pilih Mata Pelajaran</label>
                            <select name="matpel_id" id="matpel_id" class="block w-full mt-1 bg-gray-50 border border-gray-300 rounded-md dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                @foreach($mataPelajaran as $matpel)
                                    <option value="{{ $matpel->id_matpel }}">{{ $matpel->nama_matpel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="w-full px-5 py-2 mt-4 font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">Tambah Penugasan</button>
                    </form>
                </div>
            </div>
        </main>
        <script>
            
             // Mengatur agar notifikasi otomatis tertutup setelah 3 detik
        setTimeout(function() {
            const successToast = document.getElementById("toast-success");
            const updateToast = document.getElementById("toast-update");
            const dangerToast = document.getElementById("toast-danger");

            if (successToast) successToast.style.display = 'none';
            if (updateToast) updateToast.style.display = 'none';
            if (dangerToast) dangerToast.style.display = 'none';
        }, 3000); // 5000 ms = 5 seconds
            
        </script>
    </x-staffakademik-layout>
