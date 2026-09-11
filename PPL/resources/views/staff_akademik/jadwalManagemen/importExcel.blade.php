<x-staffakademik-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Jadwal') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
        {{-- HEADER --}}
        <div class="mb-4 col-span-full xl:mb-2">
            <div class="p-4 mb-4 space-y-6 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('staff_akademik.dashboard') }}"
                            class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-500">
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('staff_akademik.jadwal') }}"
                                class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-500">Kelola Jadwal</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('staff_akademik.jadwal.import') }}"
                                class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-primary-500">Import Jadwal</a>
                        </div>
                    </li>
                </ol>
            </nav>

            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Import Jadwal Pembelajaran</h1>
            <p class="mb-3 text-xs text-slate-500">Unggah berkas spreadsheet Excel (.xlsx) untuk memasukkan jadwal kelas secara massal</p>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ asset('files/template_excel.xlsx') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-brand-50 text-brand-800 border border-brand-200/60 hover:bg-brand-100 transition-colors">
                    <i class="fa-solid fa-download text-[11px]"></i>
                    <span>Unduh Template Excel</span>
                </a>
                <!-- KEMBALI -->
                <a href="{{ route('staff_akademik.jadwal') }}"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-medium text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 rounded-lg transition-colors shadow-sm">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>

        {{-- KONTEN --}}
        <div class="col-span-full xl:col-auto">
            <div class="p-5 bg-white border border-slate-200 rounded-xl shadow-sm">
                {{-- FORM IMPORT --}}
                <form action="{{ route('staff_akademik.jadwal.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label for="fileInput" class="block text-xs font-medium text-slate-700 mb-1">Pilih Berkas Excel:</label>
                        <input type="file" name="file" id="fileInput" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-800 hover:file:bg-brand-100 cursor-pointer">
                    </div>
                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand-800 hover:bg-brand-900 text-white font-medium text-xs rounded-lg transition-colors shadow-sm">
                            <i class="fa-solid fa-file-import text-[11px]"></i>
                            <span>Import Jadwal</span>
                        </button>
                        {{-- Tombol untuk Preview --}}
                        <button type="button" onclick="previewExcel()" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 font-medium text-xs rounded-lg border border-slate-200 transition-colors shadow-sm">
                            <i class="fa-regular fa-eye text-[11px]"></i>
                            <span>Preview Excel</span>
                        </button>
                    </div>
                </form>

                {{-- Area Preview --}}
                <div id="excelPreview" class="hidden mt-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Preview Data Excel</h3>
                    <table class="min-w-full bg-white border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <thead>
                            <tr id="previewHeader" class="bg-gray-100 dark:bg-gray-700"></tr>
                        </thead>
                        <tbody id="previewBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        function previewExcel() {
            const fileInput = document.getElementById('fileInput');
            const excelPreview = document.getElementById('excelPreview');
            const previewHeader = document.getElementById('previewHeader');
            const previewBody = document.getElementById('previewBody');

            if (fileInput.files.length === 0) {
                alert('Silakan pilih file Excel terlebih dahulu.');
                return;
            }

            const file = fileInput.files[0];
            const reader = new FileReader();

            reader.onload = function (e) {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: 'array' });

                // Ambil sheet pertama
                const sheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[sheetName];
                const jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });

                // Bersihkan header dan body
                previewHeader.innerHTML = '';
                previewBody.innerHTML = '';

                if (jsonData.length > 0) {
                    // Tambahkan header
                    const headerRow = jsonData[0];
                    const headerHtml = headerRow.map(header => `<th class="border px-2 py-1">${header}</th>`).join('');
                    previewHeader.innerHTML = headerHtml;

                    // Tambahkan data
                    jsonData.slice(1).forEach(row => {
                        const rowHtml = row.map((cell, index) => {
                            // Konversi waktu jika kolom adalah Waktu Mulai atau Waktu Selesai
                            if (index === 2 || index === 3) { // Kolom ke-3 dan ke-4 adalah Waktu Mulai dan Waktu Selesai
                                return `<td class="border px-2 py-1">${convertExcelTimeToHMS(cell)}</td>`;
                            }
                            return `<td class="border px-2 py-1">${cell !== undefined ? cell : ''}</td>`;
                        }).join('');
                        const tr = document.createElement('tr');
                        tr.innerHTML = rowHtml;
                        previewBody.appendChild(tr);
                    });

                    // Tampilkan area preview
                    excelPreview.classList.remove('hidden');
                } else {
                    alert('File Excel kosong atau tidak dapat diproses.');
                }
            };

            reader.readAsArrayBuffer(file);
        }

        // Fungsi untuk mengkonversi waktu Excel ke format "HH:mm"
        function convertExcelTimeToHMS(excelTime) {
            const totalMinutes = Math.floor(excelTime * 24 * 60);
            const hours = Math.floor(totalMinutes / 60);
            const minutes = totalMinutes % 60;
            return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
        }
    </script>
    
</x-staffakademik-layout>