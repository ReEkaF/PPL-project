<x-app-guru-layout>
    <div class="px-3 py-5 mx-4 my-6 bg-white rounded-lg shadow xl:p">
        {{-- Breadcrumb --}}
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'route' => route('guru.dashboard')],
                ['label' => 'LMS', 'route' => route('guru.dashboard.lms')],
                ['label' => 'Buat tugas ' . $mataPelajaran->nama_matpel . ' ' . $kelas->nama_kelas],
            ];
        @endphp

        <x-breadcrumb :breadcrumbs="$breadcrumbs" />
        @if (session()->has('success'))
            <x-alert-notification :color="'blue'">
                {{ session('success') }}
            </x-alert-notification>
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <x-alert-notification :color="'red'">
                    {{ $error }}
                </x-alert-notification>
            @endforeach
        @endif

        <form action="{{ route('guru.dashboard.lms.tugas.store', $id) }}" method="POST" enctype="multipart/form-data"
            class="mt-6">
            @csrf
            <input type="hidden" name="kelas_mata_pelajaran_id" value="{{ $id }}">

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <!-- Main Content Column (full width on mobile, 2/3 on desktop) -->
                <div class="space-y-6 md:col-span-2">
                    <!-- Judul -->
                    <div>
                        <label for="judul" class="block text-sm font-medium text-gray-700">Judul Tugas</label>
                        <input type="text" name="judul_tugas" id="judul" autofocus
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi
                            Tugas</label>
                        <input id="deskripsi" type="hidden" name="deskripsi">
                        <trix-editor input="deskripsi" id="deskripsi" rows="4"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></trix-editor>
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">File Tugas</label>
                        <div
                            class="flex justify-center px-4 py-4 mt-1 border-2 border-gray-300 border-dashed rounded-md md:px-6 md:pt-5 md:pb-6">
                            <div class="space-y-1 text-center">
                                <div class="flex flex-col items-center">
                                    <label for="files"
                                        class="relative font-medium text-indigo-600 bg-white rounded-md cursor-pointer hover:text-indigo-500 focus-within:underline">
                                        <span>Upload files</span>
                                        <input id="files" name="files[]" type="file" class="sr-only" multiple
                                            accept=".pdf,.doc,.docx,.ppt,.pptx">
                                    </label>
                                    <p class="mt-4 text-xs text-gray-500">PDF, DOC, DOCX, PPT, PPTX up to 10MB each</p>
                                </div>
                                <div id="file-list" class="mt-4 text-sm text-gray-500"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column (full width on mobile, 1/3 on desktop) -->
                <div class="space-y-6">
                    <!-- Tenggat -->
                    <div>
                        <label for="tenggat" class="block text-sm font-medium text-gray-700">Tenggat</label>
                        <input type="datetime-local" name="tenggat" id="tenggat"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Topik -->
                    <div>
                        <label for="topik_id" class="block text-sm font-medium text-gray-700">Topik</label>
                        <select name="topik_id" id="topik_id"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Pilih Topik</option>
                            @foreach ($topiks as $topik)
                                <option value="{{ $topik->id_topik }}">{{ $topik->judul_topik }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col gap-y-3">
                        <button type="button" onclick="openModal()"
                            class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-500 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Tambah Topik
                        </button>
                        <button type="submit"
                            class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Tugaskan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- modal tambah topik --}}
    <div id="topicModal" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeModal()"></div>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="w-full max-w-md mx-auto bg-white rounded-lg shadow-xl" onclick="event.stopPropagation()">
                <form action="{{ route('guru.dashboard.lms.topik.store', $id) }}" method="POST">
                    @csrf
                    <div class="px-6 py-4 border-b">
                        <h3 class="text-lg font-medium text-gray-900">
                            Tambahkan topik
                        </h3>
                    </div>
                    <div class="px-6 py-4">
                        <div class="relative">
                            <input type="hidden" name="mata_pelajaran_id" value="{{ $mataPelajaran->id_matpel }}">
                            <input type="hidden" name="kelas_mata_pelajaran_id" value="{{ $id }}">
                            <input type="hidden" name="dari_tugas" value="1">
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedFiles = [];
            const fileInput = document.getElementById('files');
            const fileList = document.getElementById('file-list');
            const maxFileSize = 10 * 1024 * 1024; // 10MB in bytes

            fileInput.addEventListener('change', function(e) {
                const newFiles = Array.from(this.files).filter(file => {
                    if (file.size > maxFileSize) {
                        alert(`File ${file.name} terlalu besar. Maksimal ukuran file adalah 10MB.`);
                        return false;
                    }

                    const validTypes = ['application/pdf', 'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-powerpoint',
                        'application/vnd.openxmlformats-officedocument.presentationml.presentation'
                    ];
                    if (!validTypes.includes(file.type)) {
                        alert(
                            `File ${file.name} tidak didukung. Format yang didukung: PDF, DOC, DOCX, PPT, PPTX.`
                        );
                        return false;
                    }
                    return true;
                });

                selectedFiles = [...selectedFiles, ...newFiles];
                updateFileList();
            });

            function updateFileList() {
                fileList.innerHTML = '';
                selectedFiles.forEach((file, index) => {
                    const fileItem = `
                <div class="flex gap-4 items-center justify-between underline">
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
            }

            window.removeFile = function(index) {
                selectedFiles.splice(index, 1);
                updateFileList();
            };
        });



        // Modal Topik
        function openModal() {
            document.getElementById('topicModal').classList.remove('hidden');
            document.getElementById('topicInput').focus();
        }

        function closeModal() {
            const modal = document.getElementById('topicModal');
            const input = document.getElementById('topicInput');
            const charCount = document.getElementById('charCount');

            modal.classList.add('hidden');
            input.value = '';
            charCount.textContent = '0';
        }

        function updateCharCount(input) {
            document.getElementById('charCount').textContent = input.value.length;
        }
    </script>
</x-app-guru-layout>
