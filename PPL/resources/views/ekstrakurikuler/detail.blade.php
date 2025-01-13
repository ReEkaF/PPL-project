<x-guest-layout>
    <div class="max-w-4xl mx-auto py-12 px-4 lg:px-8 bg-white rounded-lg shadow-md">
        <h2 class="text-3xl font-bold text-primary-color mb-6">{{ $ekstrakurikuler->nama_ekstrakurikuler }}</h2>
        <img src="{{ asset('images/ekstra/'.$ekstrakurikuler->gambar) }}" alt="{{ $ekstrakurikuler->nama_ekstrakurikuler }}" class="w-full h-64 object-cover rounded-lg mb-6">
        
        <div class="text-gray-600 leading-relaxed">
            <p>{{ $ekstrakurikuler->deskripsi }}</p>
            <!-- Tambahkan informasi lainnya jika ada kolom lain di tabel, misal jadwal, kegiatan, dll -->
        </div>
    
    <!-- Tampilkan prestasi terkait -->
    <h3 class="text-3xl font-bold text-primary-color mb-6">Prestasi Ekstrakurikuler</h3>
    <div class="prestasi-list mt-8">
        @foreach($prestasiList as $prestasi)
            <div class="prestasi-item bg-white rounded-lg shadow-lg mb-8 overflow-hidden">
                <!-- Gambar Prestasi -->
                <img src="{{ asset('images/ekstra/'.$ekstrakurikuler->nama_ekstrakurikuler.'/'.$prestasi->gambar) }}" alt="{{ ($prestasi) ? $prestasi ->judul : prestasi }}" class="w-full h-64 object-cover">
                <!-- Informasi Prestasi -->
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $prestasi->judul }}</h2>
                    <div class="flex items-center text-gray-600 mb-4">
                        <span class="mr-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-primary-color" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.1 3.384a1 1 0 00.95.691h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.033a1 1 0 00-.364 1.118l1.1 3.384c.3.921-.755 1.688-1.54 1.118l-2.8-2.033a1 1 0 00-1.176 0l-2.8 2.033c-.784.57-1.838-.197-1.539-1.118l1.1-3.384a1 1 0 00-.364-1.118l-2.8-2.033c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.95-.691l1.1-3.384z" />
                            </svg>
                            
                        </span>
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-primary-color" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v11a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 00-1-1H6zm3 1v1h2V3H9zM5 6h10v11H5V6z" />
                            </svg>
    
                        </span>
                    </div>
    
                    <p class="text-gray-700 leading-relaxed">
                        {{ $prestasi->deskripsi }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
    
    
</x-guest-layout>
