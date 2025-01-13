<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class topik extends Model
{
    use Notifiable, HasUuids;


    protected $table = 'topik';
    protected $primaryKey = 'id_topik';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'mata_pelajaran_id',
        'judul_topik',
        'kelas_mata_pelajaran_id',
    ];

    /**
     * Relationship with MataPelajaran model
     */
    public function mataPelajaran()
    {
        return $this->belongsTo(mata_pelajaran::class, 'mata_pelajaran_id', 'id_matpel');
    }

    /**
     * Relationship with KelasMataPelajaran model
     */
    public function kelasMataPelajaran()
    {
        return $this->belongsTo(kelas_mata_pelajaran::class, 'kelas_mata_pelajaran_id', 'id_kelas_mata_pelajaran');
    }
    public function materi()
    {
        return $this->hasMany(materi::class, 'topik_id', 'id_topik');
    }
    public function tugas()
    {
        return $this->hasMany(tugas::class, 'topik_id', 'id_topik');
    }
    public function ujian()
    {
        return $this->hasMany(ujian::class);
    }
}
