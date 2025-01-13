<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class mata_pelajaran extends Model
{
    use Notifiable, HasUuids;


    protected $table = 'mata_pelajaran';
    public $timestamps = false;
    protected $primaryKey = 'id_matpel';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_matpel',
        'nama_matpel',
        'deskripsi_matpel',
    ];
    public function kelasMataPelajaran()
    {
        return $this->hasMany(kelas_mata_pelajaran::class, 'mata_pelajaran_id', 'id_matpel');
    }
    // public function nilaimapel()
    // {
    //     return $this->hasMany(Nilai_mapel::class,'matpel_id', 'id_matpel');
    // }
    public function gurumatapeljaran()
    {
        return $this->hasMany(guru_mata_pelajaran::class, 'matpel_id', 'id_matpel');
    }
    public function topik()
    {
        return $this->hasMany(topik::class, 'mata_pelajaran_id', 'id_matpel');
    }
}
