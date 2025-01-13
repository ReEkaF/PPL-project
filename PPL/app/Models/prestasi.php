<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Prestasi extends Model
{
    use HasUuids;

    protected $table = 'prestasi';
    protected $primaryKey = 'id_prestasi';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    // Kolom yang dapat diisi massal
    protected $fillable = [
        'siswa_id', 'id_prestasi', 'nama_prestasi', 'bukti_prestasi', 'deskripsi_prestasi', 'status_prestasi'
    ];
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id_siswa');
    }
}
