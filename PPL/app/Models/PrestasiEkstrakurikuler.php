<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PrestasiEkstrakurikuler extends Model
{
    use HasUuids;

    protected $table = 'prestasi_ektrakurikuler';
    protected $primaryKey = 'id_prestasi';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

     protected $fillable = [
        'id_prestasi',
        'id_ekstrakurikuler',
        'judul',
        'deskripsi',
        'gambar',
     ];
 
     /**
      * Relationship with Ekstrakurikuler
      */
     public function ekstrakurikuler()
     {
         return $this->belongsTo(Ekstrakurikuler::class, 'id_ekstrakurikuler', 'id_ekstrakurikuler');
     }
}
