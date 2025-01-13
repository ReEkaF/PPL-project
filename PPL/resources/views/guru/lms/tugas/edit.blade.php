<x-app-guru-layout>
    <div class="px-3 py-5 mx-4 my-6 bg-white rounded-lg shadow xl:p">
        {{-- Breadcrumb --}}
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'route' => route('guru.dashboard')],
                ['label' => 'LMS', 'route' => route('guru.dashboard.lms')],
                ['label' => 'Edit Tugas ' . $mataPelajaran->nama_matpel . ' ' . $kelas->nama_kelas],
            ];
        @endphp
        <x-breadcrumb :breadcrumbs="$breadcrumbs" />

        @if (session()->has('success'))
            <x-alert-notification :color="'blue'">
                {{ session('success') }}
            </x-alert-notification>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('guru.dashboard.lms.tugas.update', $tugas->id_tugas) }}" method="POST"
            enctype="multipart/form-data" class="mt-6">
            @csrf
            @method('PUT')
            <input type="hidden" name="kelas_mata_pelajaran_id" value="{{ $tugas->kelas_mata_pelajaran_id }}">

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="space-y-6 md:col-span-2">
                    <!-- Judul -->
                    <div>
                        <label for="judul" class="block text-sm font-medium text-gray-700">Judul Tugas</label>
                        <input type="text" name="judul_tugas" id="judul" autofocus
                            value="{{ old('judul_tugas', $tugas->judul) }}"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Materi
                            (Optional)</label>
                        <input id="deskripsi" type="hidden" name="deskripsi" value="{{ old('deskripsi', $tugas->deskripsi) }}">
                        <trix-editor input="deskripsi" id="deskripsi" rows="4"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></trix-editor>
                        {{-- <textarea name="deskripsi" id="deskripsi" rows="4"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('deskripsi', $tugas->deskripsi) }}</textarea> --}}
                    </div>

                    <!-- Existing Files -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">File Tugas Sebelumnya</label>
                        <div class="space-y-2">
                            @if ($tugas->filetugas->isEmpty())
                                <p class="text-sm text-gray-500">Tidak ada file tugas sebelumnya.</p>
                            @endif
                            @foreach ($tugas->filetugas as $file)
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
                                        <input type="checkbox" name="removed_files[]" value="{{ $file->id_file_tugas }}"
                                            id="file_{{ $file->id_file_tugas }}"
                                            class="text-indigo-600 border-gray-300 rounded">
                                        <label for="file_{{ $file->id_file_tugas }}"
                                            class="text-sm text-red-500">Hapus</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
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

                <div class="space-y-6">
                    <!-- Tenggat -->
                    <div>
                        <label for="tenggat" class="block text-sm font-medium text-gray-700">Tenggat</label>
                        <input type="datetime-local" name="tenggat" id="tenggat"
                            value="{{ old('tenggat', \Carbon\Carbon::parse($tugas->deadline)->format('Y-m-d\TH:i')) }}"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required>
                    </div>

                    <!-- Topik -->
                    <div>
                        <label for="topik_id" class="block text-sm font-medium text-gray-700">Topik</label>
                        <select name="topik_id" id="topik_id"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Pilih Topik</option>
                            @foreach ($topiks as $topik)
                                <option value="{{ $topik->id_topik }}"
                                    {{ old('topik_id', $tugas->topik_id) == $topik->id_topik ? 'selected' : '' }}>
                                    {{ $topik->judul_topik }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col gap-y-3">
                        <button type="submit"
                            class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Perbarui Tugas
                        </button>
                    </div>
                </div>
            </div>
        </form>
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
            }

            window.removeFile = function(index) {
                selectedFiles.splice(index, 1);
                updateFileList();
            };
        });
    </script>
</x-app-guru-layout>
