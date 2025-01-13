<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use App\Models\pengumpulan_tugas;

class PengumpulanTugasFile extends Model
{
    use HasUuids;

    protected $table = 'pengumpulan_tugas_file';
    protected $primaryKey = 'id_pengumpulan_tugas_file';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'pengumpulan_tugas_id',
        'file_path',
        'file_type',
        'original_name'
    ];

    public function pengumpulanTugas()
    {
        return $this->belongsTo(pengumpulan_tugas::class, 'pengumpulan_tugas_id', 'id_pengumpulan_tugas');
    }
}
