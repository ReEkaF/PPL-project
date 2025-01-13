<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class tugas extends Model
{
    use Notifiable, HasUuids;


    protected $table = 'tugas';
    protected $primaryKey = 'id_tugas';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'judul',
        'deskripsi',
        'topik_id',
        'deadline',
        'kelas_mata_pelajaran_id',
    ];

    /**
     * Relationship with Topik model
     */
    public function topik()
    {
        return $this->belongsTo(Topik::class, 'topik_id', 'id_topik');
    }

    /**
     * Relationship with KelasMataPelajaran model
     */
    public function kelasMataPelajaran()
    {
        return $this->belongsTo(kelas_mata_pelajaran::class, 'kelas_mata_pelajaran_id', 'id_kelas_mata_pelajaran');
    }
    public function pengumpulantugas()
    {
        return $this->hasMany(pengumpulan_tugas::class, 'tugas_id', 'id_tugas');
    }
    public function filetugas()
    {
        return $this->hasMany(file_tugas::class, 'tugas_id', 'id_tugas');
    }
    protected $casts = [
        'deadline' => 'datetime',
    ];
}
