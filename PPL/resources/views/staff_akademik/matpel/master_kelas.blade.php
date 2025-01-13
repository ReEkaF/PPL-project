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
                        <!-- Ikon Sukses -->
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
                        <!-- Ikon Update -->
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
                        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Kelas</h1>
                    </div>
                    <div class="items-center justify-between block sm:flex">
                        <!-- Search Form -->
                        <form class="sm:pr-3" action="{{ route('staff_akademik.kelas.index') }}" method="GET">
                            <label for="search" class="sr-only">Cari Kelas</label>
                            <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                                <input type="text" name="search" id="search" value="{{ request()->get('search') }}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Cari kelas">
                            </div>
                        </form>
                        <!-- Tombol Tambah Kelas dengan Modal -->
                        <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                        Tambah Kelas
                        </button>
                    </div>
                </div>
            </div>
        
            <!-- Tabel Kelas -->
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">No</th>
                                <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Nama Kelas</th>
                                <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:bg-gray-800 dark:divide-gray-700">
                            @forelse($kelas as $index => $kel)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="p-4 text-sm text-gray-500 dark:text-gray-400">{{ $index + 1 + ($kelas->currentPage() - 1) * $kelas->perPage() }}</td>
                                    <td class="p-4 text-sm text-gray-900 dark:text-white">{{ $kel->nama_kelas }}</td>
                                    <td class="p-4 space-x-2 whitespace-nowrap">
                                        <!-- Tombol Update dengan Styling Baru -->
                                        <button type="button" onclick="openEditModal('{{ $kel->id_kelas }}', '{{ $kel->nama_kelas }}')" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                                            </svg>
                                            Update
                                        </button>
                                    
                                        <!-- Tombol Delete dengan Styling Baru -->
                                        <form method="POST" action="{{ route('staff_akademik.kelas.destroy', $kel->id_kelas) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                Delete item
                                            </button>
                                        </form>
                                    </td>                                
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-4 text-center text-gray-500 dark:text-gray-400">Tidak ada data kelas ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $kelas->links() }}
                    </div>
                </div>
            </div>
        
            <!-- Modal Tambah Kelas -->
            <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full p-4 h-full bg-black bg-opacity-50">
                <div class="relative w-full max-w-md bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 rounded-lg text-sm w-8 h-8 dark:hover:bg-gray-600" data-modal-toggle="crud-modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <form method="POST" action="{{ route('staff_akademik.kelas.store') }}" class="p-6">
                        @csrf
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Kelas</h3>
                        <div class="mt-4">
                            <label for="create_nama_kelas" class="block text-sm font-medium text-gray-700 dark:text-white">Nama Kelas</label>
                            <input type="text" name="nama_kelas" id="create_nama_kelas" class="block w-full mt-1 bg-gray-50 border border-gray-300 rounded-md dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white focus:ring-primary-500 focus:border-primary-500" required>
                        </div>
                        <button type="submit" class="w-full px-5 py-2 mt-4 font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">Tambah Kelas</button>
                    </form>
                </div>
            </div>
    
            <!-- Modal Edit Kelas (Dinamis) -->
            <div id="edit-modal" class="hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full p-4 h-full bg-black bg-opacity-50">
                <div class="relative w-full max-w-md bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Tombol untuk Menutup Modal -->
                    <button type="button" onclick="closeEditModal()" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 rounded-lg text-sm w-8 h-8 dark:hover:bg-gray-600">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
    
                    <!-- Form Edit Kelas -->
                    <form method="POST" id="edit-form" class="p-6">
                        @csrf
                        @method('PUT')
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Kelas</h3>
                        <div class="mt-4">
                            <label for="edit_nama_kelas" class="block text-sm font-medium text-gray-700 dark:text-white">Nama Kelas</label>
                            <input type="text" name="nama_kelas" id="edit_nama_kelas" class="block w-full mt-1 bg-gray-50 border border-gray-300 rounded-md dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white focus:ring-primary-500 focus:border-primary-500" required>
                        </div>
                        <button type="submit" class="w-full px-5 py-2 mt-4 font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">Update Kelas</button>
                    </form>
                </div>
            </div>
    
        </main>
    
        <script>
            // Fungsi untuk membuka modal edit dan mengisi data dinamis
            function openEditModal(id, name) {
                // Update form action URL
                const editForm = document.getElementById('edit-form');
                editForm.action = `/staff_akademik/kelas/${id}`;
        
                // Update input values
                document.getElementById('edit_nama_kelas').value = name;
        
                // Show the modal
                const editModal = document.getElementById('edit-modal');
                editModal.classList.remove('hidden');
            }
        
            // Fungsi untuk menutup modal edit
            function closeEditModal() {
                const editModal = document.getElementById('edit-modal');
                editModal.classList.add('hidden');
            }
        
            // Menutup modal ketika area luar modal diklik
            window.onclick = function(event) {
                const editModal = document.getElementById('edit-modal');
                if (event.target === editModal) {
                    closeEditModal();
                }

            function closeToast() {
                const toast = document.getElementById("notification-container");
                toast.style.display = 'none';
            }

            setTimeout(closeToast, 4000);

            }
        </script>
    </x-staffakademik-layout>