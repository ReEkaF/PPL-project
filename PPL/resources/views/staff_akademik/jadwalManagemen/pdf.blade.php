<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Kelas</title>
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
    </style>
</head>
<body>
    <h2>Jadwal Kelas</h2>
    <table>
        <thead>
            <tr>
                <th>Kelas</th>
                <th>Hari</th>
                <th>Waktu Mulai</th>
                <th>Waktu Selesai</th>
                <th>Mata Pelajaran</th>
                <th>Guru</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item->nama_kelas }}</td>
                    <td>{{ $item->nama_hari }}</td>
                    <td>{{ $item->waktu_mulai }}</td>
                    <td>{{ $item->waktu_selesai }}</td>
                    <td>{{ $item->nama_matpel }}</td>
                    <td>{{ $item->nama_guru }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>