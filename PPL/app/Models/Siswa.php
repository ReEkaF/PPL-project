<?php

namespace App\Models;


use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Siswa extends Authenticatable
{
    use Notifiable, HasUuids, HasFactory;
    protected $primaryKey = 'id_siswa';
    public $incrementing = false;
    public $timestamps = true;
    protected $keyType = 'string';


    protected $table = 'siswa';
    protected $fillable = [
        'id_siswa',
        'kelas_id',
        'nisn',
        'nama_siswa',
        'tgl_lahir_siswa',
        'jenis_kelamin_siswa',
        'alamat_siswa',
        'foto_siswa',
        'nomor_wa_siswa',
        'role_siswa',
        'username',
        'password',
        'email',
        'google_id',
        'google_token',
    ];
    public function pengurusEkstra()
    {
        return $this->hasMany(PengurusEkstra::class, 'id_siswa', 'id_siswa');
    }

    public function rapor()
    {
        return $this->hasMany(Rapor::class);
    }
    public function absensisiswa()
    {
        return $this->hasMany(absensi_siswa::class, 'siswa_id', 'id_siswa');
    }
    public function notifikasisistem()
    {
        return $this->hasMany(notifikasi_sistem::class);
    }
    public function pengumpulantugas()
    {
        return $this->hasMany(pengumpulan_tugas::class, 'siswa_id', 'id_siswa');
    }
    public function pengumpulanujian()
    {
        return $this->hasMany(pengumpulan_ujian::class );
    }
    public function penilaianekstra()
    {
        return $this->hasMany(PenilaianEkstrakurikuler::class);
    }
    public function laporanekstra()
    {
        return $this->hasMany(LaporanPenilaianEkstrakurikuler::class);
    }
    public function prestasi()
    {
        return $this->hasMany(prestasi::class );
    }
    public function registrasiekstra()
    {
        return $this->hasMany(RegistrasiEkstrakurikuler::class);
    }
    public function kelassiswa()
    {
        return $this->hasMany(KelasSiswa::class, 'id_siswa', 'id_siswa');
    }
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_siswas', 'id_siswa', 'id_kelas');
    }

    public function notifikasitugas()
    {
        return $this->hasMany(NotifikasiTugas::class, 'siswa_id', 'id_siswa');
    }
}
