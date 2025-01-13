<x-siswa-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Informasi Ekstrakurikuler') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 relative">
                @if ($ekstra && $ekstra->ekstrakurikuler)
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Ekstrakurikuler
                        <span class="text-sm text-gray-500">({{ $ekstra->ekstrakurikuler->nama_ekstrakurikuler }})</span>
                        <!-- Tombol untuk membuka/tutup registrasi -->
                        <form id="statusForm" method="post" action="{{ route('dashboard.status') }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" id="statusInput"
                                value="{{ $rilStatus == 'tidak buka' ? 'buka' : 'tidak buka' }}">
                            <button type="button" id="toggleButton" onclick="handleToggle(event)"
                                class="absolute top-6 right-6 bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                {{ $rilStatus == 'tidak buka' ? 'Buka Registrasi' : 'Tutup Registrasi' }}
                            </button>
                        </form>
                    @else
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Ekstrakurikuler
                            <span class="text-sm text-gray-500">(Belum terdaftar)</span>
                    @endif
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="confirmationModal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <!-- Modal Header -->
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Konfirmasi</h3>

            <!-- Modal Body -->
            <p class="text-gray-700 mb-6">Apakah Anda yakin ingin mengubah status registrasi?</p>

            <!-- Modal Actions -->
            <div class="flex justify-end space-x-4">
                <!-- Tombol Tutup -->
                <button onclick="closeModal()"
                    class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 focus:outline-none">
                    Tidak
                </button>

                <!-- Tombol Buka/Tutup -->
                <button onclick="confirmAction()"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none">
                    Ya
                </button>
            </div>
        </div>
    </div>



    @if ($ekstra && $ekstra->ekstrakurikuler)
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Tampilkan Pesan Sukses -->
                @if (session('success'))
                    <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                
                
                <!-- Tombol Modal Posting Baru -->
                <div class="flex justify-end mb-4">
                    <button onclick="toggleCreateModal()"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-700">
                        Posting
                    </button>
                </div>

                <!-- Modal Form Input Postingan Baru -->
                <div id="createModal"
                    class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center">
                    <div class="bg-white rounded-lg shadow-lg p-6 w-1/2">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Buat Postingan Baru</h3>
                        <form action="{{ route('dashboard.store') }}" method="POST" enctype="multipart/form-data"
                            class="space-y-6">
                            @csrf
                            <div>
                                <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                                <input type="text" name="judul" id="judul" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar</label>
                                <input type="file" name="gambar" id="gambar" accept="image/*" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <input id="deskripsi" type="hidden" name="deskripsi">
                                <trix-editor input="deskripsi"
                                    class="border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 rounded-md"></trix-editor>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Simpan
                                </button>
                                <button type="button" onclick="toggleCreateModal()"
                                    class="inline-flex items-center px-4 py-2 ml-4 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                    Tutup
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


                <!-- Daftar Postingan -->
                <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Postingan</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($postings as $index => $posting)
                        <div class="border p-4 rounded-lg shadow-sm bg-white">
                            <!-- Judul Postingan -->
                            <h4 class="text-lg font-semibold text-gray-800 mb-2">{{ Str::limit($posting->judul, 50) }}
                            </h4>

                            <!-- Tanggal Upload -->
                            <span class="text-xs text-gray-500 block mb-2">
                                Diupload pada: {{ \Carbon\Carbon::parse($posting->tgl_uploud)->format('d M Y H:i') }}
                            </span>

                            <!-- Nama Pengurus -->
                            <span class="text-sm text-gray-600 block mb-4">
                                Pengurus: {{ $uplouders[$index]->nama_siswa }}
                            </span>

                            <!-- Tombol Aksi -->
                            <div class="flex justify-between items-center">
                                <!-- Tombol Edit -->
                                <button data-modal-target="edit-{{ $index }}"
                                    data-modal-toggle="edit-{{ $index }}"
                                    class="text-blue-500 hover:text-blue-700 font-medium">
                                    Edit
                                </button>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('dashboard.destroy', $posting->id_posting) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                        <!-- Main modal -->
                        <div id="edit-{{ $index }}" tabindex="-1" aria-hidden="true"
                            class="hidden fixed inset-0 z-50 flex justify-center items-center bg-gray-800 bg-opacity-50 overflow-y-auto h-full w-full">
                            <div class="relative bg-white rounded-lg shadow-lg w-full max-w-2xl">
                                <!-- Modal Header -->
                                <div class="flex items-center justify-between p-4 border-b rounded-t bg-indigo-600">
                                    <h3 class="text-lg font-medium text-white">
                                        Edit Postingan Ekstrakurikuler
                                    </h3>
                                    <button type="button"
                                        class="text-gray-200 bg-transparent hover:bg-indigo-700 hover:text-white rounded-lg text-sm w-8 h-8 flex items-center justify-center"
                                        data-modal-hide="edit-{{ $index }}">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        <span class="sr-only">Close</span>
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <div class="p-6 space-y-4">
                                    <form
                                        action="{{ route('dashboard.update', ['id_posting' => $posting->id_posting]) }}"
                                        id="editForm" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <!-- Judul -->
                                        <div>
                                            <label for="editJudul"
                                                class="block text-sm font-medium text-gray-700">Judul</label>
                                            <input type="text" name="judul" id="editJudul"
                                                value="{{ $posting->judul }}" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        </div>

                                        <!-- Gambar -->
                                        <div>
                                            <label for="editGambar"
                                                class="block text-sm font-medium text-gray-700">Gambar</label>
                                            <input type="file" name="gambar" id="editGambar" accept="image/*"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                            <img id="currentImage"
                                                class="mt-4 max-w-full rounded-lg border border-gray-200 shadow" />
                                        </div>

                                        <!-- Deskripsi -->
                                        <div>
                                            <label for="editDeskripsi"
                                                class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                            <input id="editDeskripsi" type="hidden" name="deskripsi"
                                                value="{{ $posting->deskripsi }}">
                                            <trix-editor input="editDeskripsi"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></trix-editor>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex justify-end space-x-4">
                                            <button type="submit"
                                                class="inline-flex items-center px-5 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                Simpan
                                            </button>
                                            <button type="button" onclick="toggleEditModal({{ $index }})"
                                                class="inline-flex items-center px-5 py-2 bg-gray-400 text-white text-sm font-medium rounded-md shadow hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                                Tutup
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Belum ada postingan untuk ekstrakurikuler ini.</p>
                    @endforelse
                </div>
                @endif
                <script>
                    function toggleCreateModal() {
                        const modal = document.getElementById('createModal');
                        modal.classList.toggle('hidden');
                    }

                    function toggleEditModal() {
                        const modal = document.getElementById('editModal');
                        modal.classList.toggle('hidden');
                    }

                    function openEditModal(id) {
                        fetch(`/dashboard/${id}`)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('editJudul').value = data.judul;
                                document.getElementById('editDeskripsi').value = data.deskripsi;
                                document.getElementById('currentImage').src = `/storage/${data.gambar}`;
                                document.getElementById('editForm').action = `/dashboard/${id}`;
                                toggleEditModal();
                            })
                            .catch(error => console.error('Error:', error));
                    }


                    // Fungsi untuk menampilkan modal
                    function handleToggle(event) {
                        event.preventDefault();
                        const modal = document.getElementById('confirmationModal');
                        modal.classList.remove('hidden'); // Tampilkan modal
                    }
                    // Fungsi untuk menutup modal
                    function closeModal() {
                        const modal = document.getElementById('confirmationModal');
                        modal.classList.add('hidden'); // Sembunyikan modal
                    }

                    // Fungsi untuk mengubah status registrasi
                    let isRegistrationOpen = {{ $rilStatus == 'buka' ? 'true' : 'false' }};
                    const form = document.getElementById('statusForm');
                    isRegistrationOpen = !isRegistrationOpen;

                    // Perbarui teks tombol utama
                    const toggleButton = document.getElementById('toggleButton');
                    if (isRegistrationOpen) {
                        toggleButton.textContent = 'Buka Registrasi';
                        toggleButton.classList.remove('bg-red-600', 'hover:bg-red-700');
                        toggleButton.classList.add('bg-blue-600', 'hover:bg-blue-700');
                    } else {
                        toggleButton.textContent = 'Tutup Registrasi';
                        toggleButton.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                        toggleButton.classList.add('bg-red-600', 'hover:bg-red-700');
                    }

                    function confirmAction() {
                        // Sembunyikan modal setelah konfirmasi
                        form.submit();
                        closeModal();
                    }
                </script>
</x-siswa-layout>
