<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class LaporanPenilaianEkstrakurikuler extends Model
{
    use HasUuids;

    protected $table = 'laporan_penilaian_ekstrakurikuler';
    protected $primaryKey = 'id_laporan';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_laporan',
        'id_siswa',
        'id_ekstrakurikuler',
        'isi_laporan',
    ];

    /**
     * Relationship with PengurusEkstra
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    /**
     * Relationship with Ekstrakurikuler
     */
    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'id_ekstrakurikuler', 'id_ekstrakurikuler');
    }
    public function penilaianekstra()
    {
        return $this->hasMany(PenilaianEkstrakurikuler::class,'id_laporan', 'id_laporan' );
    }
}
