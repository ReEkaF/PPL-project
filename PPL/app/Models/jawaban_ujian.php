<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class jawaban_ujian extends Model
{
    use HasUuids;

    protected $table = 'jawaban_ujian';

    public $incrementing  = false;
    protected $keyType = false;
    protected $primaryKey = 'id_jawaban_ujian';
    protected $fillable = [
        'id_jawaban_ujian',
        'pengumpulan_ujian_id',
        'soal_id',
        'jawaban_dipilih',
    ];
    public function pengumpulanUjian()
    {
        return $this->belongsTo(pengumpulan_ujian::class, 'pengumpulan_ujian_id', 'id_pengumpulan_ujian');
    }

    public function soalUjian()
    {
        return $this->belongsTo(soal_ujian::class, 'soal_id', 'id_soal_ujian');
    }


}
