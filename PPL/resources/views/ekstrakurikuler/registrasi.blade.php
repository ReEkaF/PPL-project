<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-lg">
        
                <h3 class="text-lg font-semibold mb-4">Halo, {{ $siswa->nama_siswa }}</h3>
                <p class="text-gray-600 mb-6">Pendaftaran ekstrakurikuler sudah dibuka. Silahkan lakukan pendaftaran!</p>
                
                <div class="flex justify-center space-x-4 mb-6">
                    <button id="btnDataPribadi" onclick="showDataPribadi()" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Data Pribadi</button>
                    <button id="btnBerkasPendukung" onclick="showBerkasPendukung()" class="px-4 py-2 bg-blue-200 text-gray-700 rounded-lg">Berkas Pendukung</button>
                </div>

                <!-- Bagian Desain 1: Data Pribadi -->
                <div id="dataPribadiSection">
                <form method="POST" action="{{ route('ekstrakurikuler.registrasi.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="nama_lengkap" class="block text-gray-700">Nama Lengkap:</label>
                        <input  value="{{ $siswa->nama_siswa }}" id="nama_lengkap" class="w-full px-4 py-2 border rounded-lg" placeholder="Nama Lengkap" readonly>
                    </div>

                    <div class="mb-4">
                        <label for="nisn" class="block text-gray-700">NISN:</label>
                        <input  value="{{ $siswa->nisn }}" id="nisn" class="w-full px-4 py-2 border rounded-lg" placeholder="NISN" readonly>
                    </div>

                    <div class="mb-4">
                        <label for="no_hp" class="block text-gray-700">No HP:</label>
                        <input type="text" id="no_hp" class="w-full px-4 py-2 border rounded-lg" placeholder="No HP">
                    </div>

                    <div class="mb-4">
                        <label for="riwayat_penyakit" class="block text-gray-700">Riwayat Penyakit:</label>
                        <input type="text" id="riwayat_penyakit" name="riwayat_penyakit" class="w-full px-4 py-2 border rounded-lg" placeholder="Riwayat Penyakit">
                    </div>

                    <div class="mb-4">
                        <label for="no_hp_orangtua" class="block text-gray-700">No HP Orang Tua:</label>
                        <input type="text" id="no_hp_orangtua" name = "no_hp_orangtua" class="w-full px-4 py-2 border rounded-lg" placeholder="No HP Orang Tua">
                    </div>

                    <div class="mb-4">
                        <label for="alasan_ekskul" class="block text-gray-700">Alasan Memilih Ekstrakurikuler:</label>
                        <input type="text" id="alasan_ekskul" name = "alasan_ekskul" class="w-full px-4 py-2 border rounded-lg" placeholder="Alasan Memilih Ekstrakurikuler">
                    </div>

                    <div class="mb-4">
                        <label for="pilih_ekskul" class="block text-gray-700">Pilih Ekstrakurikuler 1:</label>
                        <select id="pilih_ekskul" name="pilih_ekskul[]" class="w-full px-4 py-2 border rounded-lg">
                            <option disabled selected>Pilih Ekstrakurikuler</option>
                            @forelse ($ekstrakurikulerList as $ekstra)
                                <option value="{{ $ekstra->id_ekstrakurikuler }}">
                                    {{ $ekstra->nama_ekstrakurikuler }} 
                                </option>
                                @empty
                                    <option disabled>Tidak ada ekstrakurikuler yang dibuka saat ini</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="mb-5">
                        <label for="pilih_ekskul" class="block text-gray-700">Pilih Ekstrakurikuler 2:</label>
                        <select id="pilih_ekskul" name="pilih_ekskul[]" class="w-full px-4 py-2 border rounded-lg">
                            <option disabled selected>Pilih Ekstrakurikuler</option>
                            @forelse ($ekstrakurikulerList as $ekstra)
                                <option value="{{ $ekstra->id_ekstrakurikuler }}">
                                    {{ $ekstra->nama_ekstrakurikuler }} 
                                </option>
                                @empty
                                    <option disabled>Tidak ada ekstrakurikuler yang dibuka saat ini</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="mb-6">
                        <label for="pilih_ekskul" class="block text-gray-700">Pilih Ekstrakurikuler 3:</label>
                        <select id="pilih_ekskul" name="pilih_ekskul[]" class="w-full px-4 py-2 border rounded-lg">
                            <option disabled selected>Pilih Ekstrakurikuler</option>
                            @forelse ($ekstrakurikulerList as $ekstra)
                                <option value="{{ $ekstra->id_ekstrakurikuler }}">
                                    {{ $ekstra->nama_ekstrakurikuler }} 
                                </option>
                                @empty
                                    <option disabled>Tidak ada ekstrakurikuler yang dibuka saat ini</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="text-right">
                        <button type="button" onclick="lanjutKeBerkasPendukung()" class="px-6 py-2 bg-blue-500 text-white rounded-lg">Lanjut</button>
                    </div>
                
                    </div>

                    <!-- Bagian Desain 2: Berkas Pendukung -->
                    <div id="berkasPendukungSection" class="hidden">
                            <div class="mb-8">
                                <label class="block text-gray-700 font-semibold mb-2">Isi Berkas Surat Izin Orang Tua Disini:</label>
                                <div class="border-dashed border-2 border-gray-300 rounded-lg p-6 text-center">
                                    <input type="file" id="surat_izin_orang_tua" name = "surat_izin_orang_tua"class="">
                                    <label for="surat_izin_orang_tua" class="cursor-pointer">
                                        <div class="text-blue-500 text-xl mb-2">
                                            <i class="fas fa-upload"></i>
                                        </div>
                                        <p class="text-gray-400">(Max. File size: 25 MB)</p>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-8">
                                <label class="block text-gray-700 font-semibold mb-2">Isi Berkas Surat Keterangan Dari Dokter Disini:</label>
                                <div class="border-dashed border-2 border-gray-300 rounded-lg p-6 text-center">
                                    <input type="file" id="surat_keterangan_dokter" name = "surat_keterangan_dokter" class="">
                                    <label for="surat_keterangan_dokter" class="cursor-pointer">
                                        <div class="text-blue-500 text-xl mb-2">
                                            <i class="fas fa-upload"></i>
                                        </div>
                                        <p class="text-gray-400">(Max. File size: 25 MB)</p>
                                    </label>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg">Submit</button>
                            </div>
                            @if(session('success'))
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        alert("{{ session('success') }}");
                                        window.location.href = "{{ route('beranda.home') }}";
                                    });
                                </script>
                            @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk Mengganti Tampilan -->
    <script>
    function showDataPribadi() {
        // Tampilkan section Data Pribadi dan sembunyikan Berkas Pendukung
        document.getElementById('dataPribadiSection').classList.remove('hidden');
        document.getElementById('berkasPendukungSection').classList.add('hidden');
        
        // Tambahkan style active pada tombol Data Pribadi
        document.getElementById('btnDataPribadi').classList.add('bg-blue-500', 'text-white');
        document.getElementById('btnDataPribadi').classList.remove('bg-blue-200', 'text-gray-700');
        
        // Hapus style active pada tombol Berkas Pendukung
        document.getElementById('btnBerkasPendukung').classList.add('bg-blue-200', 'text-gray-700');
        document.getElementById('btnBerkasPendukung').classList.remove('bg-blue-500', 'text-white');
    }

    function showBerkasPendukung() {
        // Tampilkan section Berkas Pendukung dan sembunyikan Data Pribadi
        document.getElementById('dataPribadiSection').classList.add('hidden');
        document.getElementById('berkasPendukungSection').classList.remove('hidden');
        
        // Tambahkan style active pada tombol Berkas Pendukung
        document.getElementById('btnBerkasPendukung').classList.add('bg-blue-500', 'text-white');
        document.getElementById('btnBerkasPendukung').classList.remove('bg-blue-200', 'text-gray-700');
        
        // Hapus style active pada tombol Data Pribadi
        document.getElementById('btnDataPribadi').classList.add('bg-blue-200', 'text-gray-700');
        document.getElementById('btnDataPribadi').classList.remove('bg-blue-500', 'text-white');
    }

    function lanjutKeBerkasPendukung() {
        // Memanggil fungsi showBerkasPendukung untuk menampilkan bagian Berkas Pendukung
        showBerkasPendukung();
    }
</script>
</x-guest-layout>