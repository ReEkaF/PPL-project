<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\PengumpulanTugasFile;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class pengumpulan_tugas extends Model
{
    use Notifiable, HasUuids;

    protected $table = 'pengumpulan_tugas';
    protected $primaryKey = 'id_pengumpulan_tugas';
    protected $keyType = 'string';
    public $incrementing = false;



    protected $fillable = [
        'tugas_id',
        'siswa_id',
        'file_path',
        'tanggal_pengumpulan',
        'status',
        'nilai',
        'komentar',
    ];

    /**
     * Relationship with Tugas
     */
    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id', 'id_tugas');
    }

    /**
     * Relationship with Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id_siswa');
    }

    public function pengumpulanTugasFile()
    {
        return $this->hasMany(PengumpulanTugasFile::class, 'pengumpulan_tugas_id', 'id_pengumpulan_tugas');
    }
}
