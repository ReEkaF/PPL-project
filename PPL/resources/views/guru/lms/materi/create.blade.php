<x-app-guru-layout>
    <div class="px-3 py-5 mx-4 my-6 bg-white rounded-lg shadow xl:p-6">
        {{-- Breadcrumb --}}
        @php
            $kelas = $kelas_mata_pelajaran->mataPelajaran->nama_matpel . " " . $kelas_mata_pelajaran->kelas->nama_kelas;
            $breadcrumbs = [
                ['label' => 'Dashboard', 'route' => route('guru.dashboard')],
                ['label' => 'LMS', 'route' => route('guru.dashboard.lms')],
                ['label' => 'Materi', 'route' => route('guru.dashboard.lms.materi')],
                ['label' => 'Tambah Materi', 'route' => route('guru.dashboard.lms.materi.create_view')],
                ['label' => $kelas],
            ];
        @endphp
        <x-breadcrumb :breadcrumbs="$breadcrumbs" />

        {{-- Main Content --}}
        <div class="px-3 mt-8">
            <form action="{{ route('guru.dashboard.lms.materi.store', $id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_kelas_mata_pelajaran" value="{{ $id }}">
                @if ($materi_old)
                    <input type="hidden" name="id_materi" value="{{ $materi_old->id_materi }}">
                @endif

                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <!-- Main Content Column (full width on mobile, 2/3 on desktop) -->
                    <div class="space-y-6 md:col-span-2">
                        <!-- Judul -->
                        <div class="flex flex-col gap-3">
                            <label for="judul_materi" class="text-sm text-gray-700">Judul Materi</label>
                            <input type="text" name="judul_materi" id="judul_materi" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300" value="{{ $materi_old ? $materi_old->judul_materi : old('judul_materi') }}">
                            @error('judul_materi')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="flex flex-col gap-3">
                            <label for="deskripsi" class="text-sm text-gray-700">Deskripsi Materi (Optional)</label>
                            <input type="hidden" name="deskripsi" id="deskripsi" value="{{ $materi_old ? $materi_old->deskripsi : old('deskripsi') }}">
                            <trix-toolbar id="my_toolbar"></trix-toolbar>
                            <trix-editor toolbar="my_toolbar" input="deskripsi"></trix-editor>
                        </div>

                        <!-- Existing Files Draft -->
                        @if ($materi_old)
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">File Materi Sebelumnya</label>
                                <div class="space-y-2">
                                    @if ($materi_old->fileMateri->isEmpty())
                                        <p class="text-sm text-gray-500">Tidak ada file materi sebelumnya.</p>
                                    @endif
                                    @foreach ($materi_old->fileMateri as $file)
                                        <div class="flex items-center justify-between p-2 bg-gray-100 rounded-md">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                <span>{{ $file->original_name }}</span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" name="removed_files[]" value="{{ $file->id_file_materi }}"
                                                    id="file_{{ $file->id_file_materi }}"
                                                    class="text-indigo-600 border-gray-300 rounded">
                                                <label for="file_{{ $file->id_file_materi }}"
                                                    class="text-sm text-red-500">Hapus</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- File Upload -->
                        <div class="flex flex-col gap-3">
                            <label class="block text-sm font-medium text-gray-700">File Materi</label>
                            @error('file_materi')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                            @error('file_materi.*')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                            <div
                                class="flex justify-center px-4 py-4 mt-1 border-2 border-gray-300 border-dashed rounded-md md:px-6 md:pt-5 md:pb-6">
                                <div class="space-y-1 text-center">
                                    <div class="flex flex-col items-center">
                                        <label for="files"class="relative font-medium text-indigo-600 bg-white rounded-md cursor-pointer hover:text-indigo-500 focus-within:underline">
                                            <span>Upload files</span>
                                        </label>
                                        <input id="files" name="file_materi[]" type="file" class="sr-only" multiple>
                                        <p class="mt-4 text-xs text-gray-500">PDF, DOC, DOCX, PPT, PPTX up to 10MB each</p>
                                    </div>
                                    <div id="file-list" class="mt-4 text-sm text-gray-500"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column (full width on mobile, 1/3 on desktop) -->
                    <div class="space-y-6">
                        <!-- Topik -->
                        <div class="flex flex-col gap-3">
                            <label for="topik_id" class="text-gray-700">Topik</label>
                            <select name="topik_id" id="topik_id" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300">
                                <option selected disabled>Pilih Topik</option>
                                @foreach ($topik as $item)
                                    @php
                                        $selected = $materi_old ? $materi_old->topik_id : old('topik_id');
                                        echo $selected;
                                    @endphp
                                    <option value="{{ $item->id_topik }}" {{ $selected == $item->id_topik ? 'selected' : '' }}>{{ $item->judul_topik }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col gap-y-3">
                            <button type="button"  onclick="openModal()"
                                class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-500 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Tambah Topik
                            </button>

                            <div class="flex flex-wrap">
                                <button type="button" id="post" name="post" class="flex-1 px-6 py-2 font-thin text-gray-400 bg-gray-300 cursor-default rounded-l-md">Posting</button>
                                <button type="button" class="flex px-2 pt-2 text-sm bg-green-500 hover:bg-green-600 rounded-r-md w-25" id="topik-menu-button-2" aria-expanded="false" data-dropdown-toggle="dropdown-3">
                                    <span class="sr-only">Open dropdown topik</span>
                                    <svg class="w-6 h-6 text-slate-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Dropdown Submit Modal --}}
                <div class="z-10 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow" id="dropdown-3">
                    <ul class="py-1" role="none">
                        <li>
                            <button type="submit" name="post" class="block px-4 py-2 text-sm text-gray-700 w-ful hover:bg-gray-100">Posting</button>
                        </li>
                        <li>
                            <button type="submit" name="draft" class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Draft</button>
                        </li>
                        <li>
                            <div class="border-t border-gray-100"></div>
                        </li>
                        <li>
                            <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="z-10 block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" type="button">Hapus</button>
                        </li>
                    </ul>
                </div>
            </form>

            {{-- Delete Button Modal --}}
            <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-800 bg-opacity-50">
               <div class="relative w-full max-w-md max-h-full p-4">
                   <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                       <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                           <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                               <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                           </svg>
                           <span class="sr-only">Close modal</span>
                       </button>
                       <div class="p-4 text-center md:p-5">
                           <svg class="w-12 h-12 mx-auto mb-4 text-gray-400 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                               <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                           </svg>
                           <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Apakah kamu yakin ingin menghapus?</h3>
                           @if ($materi_old)
                               <form action="{{ route('guru.dashboard.lms.materi.destroy', ['id' => $materi_old->id_materi]) }}" method="post" class="inline-flex">
                                   @method('delete')
                                   @csrf
                                   <button type="submit" name="delete" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                       Hapus
                                   </button>
                               </form>
                           @else
                               <a href="{{ route('guru.dashboard.lms.materi.create_view') }}" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                   Hapus
                               </a>
                           @endif
                           <button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
                       </div>
                   </div>
               </div>
           </div>

            {{-- Add Topik Modal --}}
            <div id="topicModal" class="fixed inset-0 z-50 hidden">
                <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeModal()"></div>
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="w-full max-w-md mx-auto bg-white rounded-lg shadow-xl" onclick="event.stopPropagation()">
                        <form action="{{ route('guru.dashboard.lms.topik.store', $kelas_mata_pelajaran->id_kelas_mata_pelajaran) }}" method="POST">
                            @csrf
                            <div class="px-6 py-4 border-b">
                                <h3 class="text-lg font-medium text-gray-900">
                                    Tambahkan topik
                                </h3>
                            </div>
                            <div class="px-6 py-4">
                                <div class="relative">
                                    <input type="hidden" name="mata_pelajaran_id" value="{{ $mata_pelajaran->id_matpel }}">
                                    <input type="hidden" name="kelas_mata_pelajaran_id" value="{{ $id }}">
                                    <input type="hidden" name="dari_materi" value="1">
                                    <input type="text" name="topic" id="topicInput" maxlength="200"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Topik" oninput="updateCharCount(this)" required>
                                </div>
                                <div class="mt-1 text-sm text-right text-gray-500">
                                    <span id="charCount">0</span>/200
                                </div>
                                @error('topic')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex justify-end px-6 py-4 space-x-2 border-t">
                                <button type="button" onclick="closeModal()"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                    Tambahkan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-guru-layout>

<script>
    // Modal Topik
    const openModal = function () {
        document.getElementById('topicModal').classList.remove('hidden');
        document.getElementById('topicInput').focus();
    }
    const closeModal = function () {
        const modal = document.getElementById('topicModal');
        const input = document.getElementById('topicInput');
        const charCount = document.getElementById('charCount');

        modal.classList.add('hidden');
        input.value = '';
        charCount.textContent = '0';
    }
    const updateCharCount = function (input) {
        document.getElementById('charCount').textContent = input.value.length;
    }

    // Input Judul Check
    const judulInput = $('#judul_materi');
    const postButton = $('button#post');

    const cekJudul = function (judulInput, postButton) {
        if (judulInput.val().trim() !== '') {
            postButton.attr('type', 'submit');
            postButton.removeClass('cursor-default bg-gray-300 text-gray-400');
            postButton.addClass('bg-green-500 hover:bg-green-600 text-white');
        } else {
            postButton.attr('type', 'button');
            postButton.addClass('cursor-default bg-gray-300 text-gray-400');
            postButton.removeClass('bg-green-500 hover:bg-green-600 text-white');
        }
    }

    cekJudul(judulInput, postButton);

    judulInput.on('input', function () {
        cekJudul(judulInput, postButton);
    });

    const getFileDetails = async function (filePath) {
        try {
            const response = await fetch(`/storage/${filePath}`);
            if (!response.ok) throw new Error('Network response was not ok');

            const blob = await response.blob();
            const fileSize = blob.size;
            const fileType = blob.type;

            return { fileSize, fileType };
        } catch (error) {
            console.error('Error fetching file details:', error);
            return null;
        }
    };

    document.addEventListener('DOMContentLoaded', async function() {
        let selectedFiles = [];

        const fileInput = document.getElementById('files');
        const fileList = document.getElementById('file-list');

        const updateFileList = function () {
            fileList.innerHTML = ''; // Bersihkan daftar file sebelumnya
            selectedFiles.forEach((file, index) => {
                const fileItem = `
                    <div class="flex items-center justify-between gap-4 underline">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-sm text-gray-600">${file.name}</span>
                        </div>
                        <button type="button" onclick="removeFile(${index})" class="text-red-500 hover:text-red-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                `;
                fileList.insertAdjacentHTML('beforeend', fileItem);
            });

            // Buat FormData
            const form = document.querySelector('form');
            const formData = new FormData(form);
            // Tambahkan semua file dari selectedFiles ke FormData
            selectedFiles.forEach((file) => {
                formData.append('file_materi[]', file);
            });
        }

        fileInput.addEventListener('change', function(e) {
            const newFiles = Array.from(this.files);
            selectedFiles = [...selectedFiles, ...newFiles]; // Gabungkan file baru dengan file sebelumnya
            updateFileList();
        });

        window.removeFile = function(index) {
            selectedFiles.splice(index, 1); // Hapus file dari array
            updateFileList(); // Perbarui tampilan
        };

        updateFileList();
    });
</script>
