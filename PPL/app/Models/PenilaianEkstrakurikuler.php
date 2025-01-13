<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PenilaianEkstrakurikuler extends Model
{
    use HasUuids;

    protected $table = 'penilaian_ekstrakurikuler';
    protected $primaryKey = 'id_penilaian_ekstrakurikuler';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_penilaian_ekstrakurikuler',
        'id_ekstrakurikuler',
        'id_siswa',
        'id_tahun_ajaran',
        'id_laporan',
        'penilaian',
        'tgl_penilaian',
    ];

    /**
     * Relationship with Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    /**
     * Relationship with TahunAjaran
     */
    public function tahunAjaran()
    {
        return $this->belongsTo(tahun_ajaran::class, 'id_tahun_ajaran', 'id_tahun_ajaran');
    }

    /**
     * Relationship with LaporanPenilaianEkstrakurikuler
     */
    public function laporan()
    {
        return $this->belongsTo(LaporanPenilaianEkstrakurikuler::class, 'id_laporan', 'id_laporan');
    }

    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'id_ekstrakurikuler', 'id_ekstrakurikuler');
    }
}
