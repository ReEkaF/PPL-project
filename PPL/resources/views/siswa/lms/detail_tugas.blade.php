<x-siswa-layout>
    <div class="px-3 py-5 mx-4 my-6 bg-white rounded-lg shadow xl:p-6">
        {{-- Breadcrumb --}}
        @php
            $breadcrumbs = [
                ['label' => 'Dashboard', 'route' => route('siswa.dashboard')],
                ['label' => 'LMS', 'route' => route('siswa.dashboard.lms')],
                ['label' => $tugas->judul],
            ];
        @endphp

        <x-breadcrumb :breadcrumbs="$breadcrumbs" />

        @if (session()->has('success'))
            <x-alert-notification :color="'blue'">
                {{ session('success') }}
            </x-alert-notification>
        @endif

        {{-- Main Content --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Left Side - Assignment Details -->
            <div class="lg:col-span-2">
                <div class="p-3">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $tugas->judul }}</h1>
                        <div class="flex justify-between items-center mt-4">
                            <div class="text-sm text-gray-600">
                                <span>{{ $tugas->kelasMataPelajaran->mata_pelajaran }}</span>
                                <span>Dibuat pada {{ $tugas->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="text-sm text-gray-600">
                                <span>Batas waktu:
                                    {{ \Carbon\Carbon::parse($tugas->deadline)->translatedFormat('l, d F Y h:i A') }}</span>
                            </div>
                        </div>
                        <hr class="h-px mt-4 bg-gray-200 border-0 dark:bg-gray-700">
                    </div>

                    <!-- Assignment Description -->
                    <div class="mt-6">
                        <div class="prose max-w-none">
                            {!! $tugas->deskripsi !!}
                        </div>
                    </div>

                    <!-- Attached Files -->
                    @if ($filetugas->count() > 0)
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900">Lampiran Tugas</h3>
                            <div class="mt-2 space-y-2">
                                @foreach ($filetugas as $file)
                                    <div class="flex items-center p-3 space-x-3 bg-gray-50 rounded-lg">
                                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <div class="flex-1">
                                            <a href="{{ asset('storage/' . $file->file_path) }}"
                                                class="text-sm font-medium text-blue-600 hover:text-blue-800"
                                                target="_blank">
                                                {{ $file->original_name }}
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Side - Submission Area -->
            <div class="lg:col-span-1">
                <div class="p-6 border rounded-lg">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg md:text-base font-medium text-gray-900">Tugas Anda</h2>
                        <span class="px-2 py-1 text-xs font-medium {{ $status_color }} rounded-md">
                            {{ $status_text }}
                        </span>
                    </div>

                    <div class="mt-4">
                        <!-- Existing Files -->
                        @if ($pengumpulan && $pengumpulan->pengumpulanTugasFile->count() > 0)
                            @foreach ($pengumpulan->pengumpulanTugasFile as $file)
                                <div class="p-3 mb-2 bg-white border rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2 min-w-0 flex-1">
                                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                                class="flex items-center space-x-2 min-w-0 flex-1">
                                                <svg class="w-5 h-5 flex-shrink-0 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                <span
                                                    class="text-sm text-gray-600 truncate block">{{ $file->original_name }}</span>
                                            </a>
                                        </div>
                                        <a href="{{ route('siswa.dashboard.lms.tugas.file.delete', $file->id_pengumpulan_tugas_file) }}"
                                            class="flex-shrink-0 ml-2 text-gray-400 hover:text-red-500"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus file ini?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <!-- Batalkan Penyerahan -->
                        @if ($pengumpulan)
                            <form
                                action="{{ route('siswa.dashboard.lms.tugas.batal', $pengumpulan->id_pengumpulan_tugas) }}"
                                method="POST" class="mt-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    onclick="return confirm('Apakah Anda yakin ingin membatalkan penyerahan tugas ini?')">
                                    Batalkan Penyerahan
                                </button>
                            </form>
                        @else
                            <!-- Submit Tugas Form -->
                            <form action="{{ route('siswa.dashboard.lms.submit.tugas', $tugas->id_tugas) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="p-3 mt-4 bg-white border-2 border-gray-300 border-dashed rounded-lg">
                                    <input type="file" id="files" name="files[]" class="sr-only" multiple
                                        accept=".pdf,.doc,.docx,.ppt,.pptx">
                                    <div class="text-center">
                                        <label for="files" class="cursor-pointer">
                                            <div
                                                class="flex items-center justify-center space-x-1 text-blue-600 hover:text-blue-500">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                                <span>Unggah Tugas</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div id="file-list" class="mt-2"></div>
                                </div>
                                <button type="submit"
                                    class="w-full px-4 py-2 mt-4 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Kumpulkan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                <!-- Nilai Box -->

                @if ($pengumpulan && $pengumpulan->nilai)
                    <div class="mt-3 p-1  rounded-lg">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm text-gray-900 font-medium ">Nilai</h3>
                            <h1 class="text-sm font-bold text-gray-900 py-1 px-2 bg-gray-100 rounded-lg">
                                {{ $pengumpulan->nilai }}/100</h1>
                        </div>
                    </div>
                    @if ($pengumpulan->komentar)
                        @if ($pengumpulan->komentar)
                            <div class="mt-4">
                                <h3 class="text-sm font-medium text-gray-900">Komentar</h3>
                                <div class="mt-2 border px-2 py-3 rounded-lg">
                                    <p>{{ $pengumpulan->komentar }}</p>
                                </div>
                            </div>
                        @endif

                    @endif
                @else
                    <p class="mt-3 py-4 px-2 border rounded-lg font-semibold text-center text-sm text-gray-700">Belum
                        dinilai</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedFiles = [];
            const fileInput = document.getElementById('files');
            const fileList = document.getElementById('file-list');
            const maxFileSize = 10 * 1024 * 1024; // 10MB

            fileInput.addEventListener('change', function(e) {
                const newFiles = Array.from(this.files).filter(file => {
                    if (file.size > maxFileSize) {
                        alert(`File ${file.name} terlalu besar. Maksimal ukuran file adalah 10MB.`);
                        return false;
                    }

                    const validTypes = [
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-powerpoint',
                        'application/vnd.openxmlformats-officedocument.presentationml.presentation'
                    ];

                    if (!validTypes.includes(file.type)) {
                        alert(
                            `File ${file.name} tidak didukung.Format yang didukung: PDF, DOC, DOCX, PPT, PPTX.`
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
                        <div class="flex items-center justify-between p-3 mt-2 bg-white border rounded-lg">
                            <div class="flex items-center space-x-2 min-w-0 flex-1">
                                <svg class="w-5 h-5 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-sm text-gray-600 truncate block">${file.name}</span>
                            </div>
                            <button type="button" onclick="removeFile(${index})" class="flex-shrink-0 ml-2 text-gray-400 hover:text-red-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>`;
                    fileList.insertAdjacentHTML('beforeend', fileItem);
                });
            }

            window.removeFile = function(index) {
                selectedFiles.splice(index, 1);
                updateFileList();
            };



        });
    </script>

</x-siswa-layout>
