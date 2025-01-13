<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            font-size: 14px;
        }
        h2, h3 {
            text-align: center;
            margin-bottom: 20px;
        }
        p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        .header-text {
            display: flex;
            justify-content: center;
            text-align: center;
            padding: 5px 15px 5px 15px;
        }
        .image {
            width: 100px;
        }
        .header-text h1, .header-text h2, .header-text p {
            margin: 5px 0;
        }
        .header-text h1 {
            font-size: 18px;
            font-weight: bold;
        }
        .header-text h2 {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .header-text p {
            font-size: 14px;
        }
        .header-border {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <div class="header-border">
        <table border="0">
            <tr>
                <td><img src="{{ base_path() }}/public/images/tut-wuri-handayani.png" class="image"></td>
                <td class="header-text">
                    <h1>PEMERINTAH KABUPATEN BANGKALAN</h1>
                    <h2>DINAS PENDIDIKAN BANGKALAN</h2>
                    <h2>SMP NEGERI 2 KAMAL</h2>
                    <p>Jl. Raya Telang No.3, Perumahan Telang Inda, Telang, Kec. Kamal, Kabupaten Bangkalan, Jawa Timur 69162</p>
                </td>
                <td><img src="{{ base_path() }}/public/images/logo.png" class="image"></td>
            </tr>
        </table>
    </div>


    <h2>Laporan Penilaian Hasil Belajar</h2>
    <p><strong>Nama:</strong> {{ $nama_siswa }}</p>
    <p><strong>NISN:</strong> {{ $nisn }}</p>
    <p><strong>Kelas:</strong> {{ $kelas }}</p>
    <p><strong>Tahun Ajaran:</strong> {{ $tahun_ajaran }}</p>
    <p><strong>Semester:</strong> {{ $semester }}</p>

    <h3>Nilai Rata-Rata Mata Pelajaran</h3>
    <table>
        <thead>
            <tr>
                <th>Mata Pelajaran</th>
                <th>Nilai</th>
                <th>Predikat</th>
                <th>Pesan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nilai_matpel as $matpel)
                <tr>
                    <td>{{ $matpel->nama_matpel }}</td>
                    <td>{{ $matpel->nilai_rata_rata_matpel }}</td>
                    <td>{{ $matpel->predikat }}</td>
                    <td>{{ $matpel->pesan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Nilai Rata-Rata Ekstrakurikuler</h3>
    <table>
        <thead>
            <tr>
                <th>Ekstrakurikuler</th>
                <th>Nilai</th>
                <th>Predikat</th>
                <th>Pesan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nilai_ekstra as $ekstra)
                <tr>
                    <td>{{ $ekstra->nama_ekstrakurikuler }}</td>
                    <td>{{ $ekstra->nilai_rata_rata_ekstra }}</td>
                    <td>{{ $ekstra->predikat }}</td>
                    <td>{{ $ekstra->pesan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
