<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class KelasSiswa extends Model
{
    use HasUuids;

    protected $table = 'kelas_siswas';
    protected $primaryKey = 'id_kelas_siswa';
    public $incrementing = false;
    public $timestamps = true;
    protected $keyType = 'string';


    protected $fillable = [
        'id_kelas_siswa',
        'id_kelas',
        'id_siswa',
        'tahun_ajaran',
        'wali_kelas',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public function tahunajaran()
    {
        return $this->belongsTo(tahun_ajaran::class, 'tahun_ajaran', 'id_tahun_ajaran');
    }
    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas', 'id_guru');
    }
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas');
    }
}
