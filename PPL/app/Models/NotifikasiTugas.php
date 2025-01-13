<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class NotifikasiTugas extends Model
{
    use HasUuids;

    protected $table = 'notifikasi_tugas';
    protected $primaryKey = 'id_notifikasi_tugas';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_notifikasi_tugas',
        'tugas_id',
        'siswa_id',
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id', 'id_tugas');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id_siswa');
    }
}
