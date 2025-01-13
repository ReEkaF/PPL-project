<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Siswa</title>
    @if(!isset($is_pdf) || !$is_pdf)
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    @else
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }
            table, th, td {
                border: 1px solid black;
            }
            th, td {
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
        </style>
    @endif
</head>
<body>
    <div class="@if(!isset($is_pdf) || !$is_pdf) container mx-auto p-6 @endif">
        <h1 class="text-2xl font-bold text-center mb-6">Jadwal Siswa</h1>
        <p class="text-center text-lg mb-4">
            Selamat datang, <span class="font-semibold">{{ $siswa->nama_siswa }}</span>
        </p>

        @if (isset($message) && $message)
            <div class="@if(!isset($is_pdf) || !$is_pdf) bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 text-center @endif">
                <p>{{ $message }}</p>
            </div>
        @elseif ($jadwal->isEmpty())
            <div class="@if(!isset($is_pdf) || !$is_pdf) bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 text-center @endif">
                <p>Tidak ada jadwal tersedia untuk kelas Anda.</p>
            </div>
        @else
            @if(!isset($is_pdf) || !$is_pdf)
                <div class="flex justify-between items-center mb-4">
                    <button onclick="window.print()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Print Jadwal
                    </button>
                    <a href="{{ route('siswa.jadwal.print') }}" target="_blank" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 ml-2">
                        Download PDF
                    </a>
                </div>
            @endif

            <div class="@if(!isset($is_pdf) || !$is_pdf) overflow-x-auto shadow-md rounded-lg @endif">
                <table class="table-auto border-collapse border border-gray-200 w-full text-sm">
                    <thead class="@if(!isset($is_pdf) || !$is_pdf) bg-gray-100 @endif">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">Hari</th>
                            <th class="border border-gray-300 px-4 py-2">Waktu Mulai</th>
                            <th class="border border-gray-300 px-4 py-2">Waktu Selesai</th>
                            <th class="border border-gray-300 px-4 py-2">Mata Pelajaran</th>
                            <th class="border border-gray-300 px-4 py-2">Guru</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwal as $item)
                            <tr class="@if(!isset($is_pdf) || !$is_pdf) hover:bg-gray-50 @endif">
                                <td class="border border-gray-300 px-4 py-2">{{ $item->nama_hari }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ date('H:i', strtotime($item->waktu_mulai)) }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ date('H:i', strtotime($item->waktu_selesai)) }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $item->nama_matpel }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $item->nama_guru }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</body>
</html>
