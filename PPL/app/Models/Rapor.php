<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Rapor extends Model
{
    use Notifiable, HasUuids;
    protected $primaryKey = 'id_rapor';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $table = 'rapor';
    protected $fillable = [
        'siswa_id',
        'tahun_ajaran_id',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id_siswa');
    }
    public function tahunAjaran()
    {
        return $this->belongsTo(tahun_ajaran::class, 'tahun_ajaran_id', 'id_tahun_ajaran');
    }
    public function nilaiMatpel()
    {
        return $this->hasMany(Nilai_mapel::class, 'nilai_matpel_id', 'id_nilai_matpel');
    }
    public function nilaiEkstra()
    {
        return $this->hasMany(Nilai_ekstra::class, 'nilai_ekstra_id', 'id_nilai_ekstra' );
    }
}
