<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Guru</title>
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
</head>
<body>
    <div>
        <h1 style="text-align: center; font-size: 24px; font-weight: bold;">Jadwal Guru</h1>
        <p style="text-align: center; font-size: 18px;">Selamat datang, <span style="font-weight: bold;">{{ $guru->nama_guru }}</span></p>

        @if ($jadwal->isEmpty())
            <div style="background-color: #FFF3CD; color: #856404; padding: 10px; text-align: center;">
                <p>Tidak ada jadwal tersedia untuk Anda.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Hari</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Mata Pelajaran</th>
                        <th>Nama Kelas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jadwal as $item)
                        <tr>
                            <td>{{ $item->nama_hari }}</td>
                            <td>{{ date('H:i', strtotime($item->waktu_mulai)) }}</td>
                            <td>{{ date('H:i', strtotime($item->waktu_selesai)) }}</td>
                            <td>{{ $item->nama_matpel }}</td>
                            <td>{{ $item->nama_kelas }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
