<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PostingEkstrakurikuler extends Model
{
    use HasUuids;

    protected $table = 'posting_ekstrakurikuler';
    protected $primaryKey = 'id_posting';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_posting',
        'id_ekstrakurikuler',
        'id_pengurus',
        'judul',
        'deskripsi',
        'gambar',
        'tgl_upload',
    ];

    public function ekstrakurikuler()
     {
         return $this->belongsTo(Ekstrakurikuler::class, 'id_ekstrakurikuler', 'id_ekstrakurikuler');
     }
 
     /**
      * Relationship with PengurusEkstra
      */
     public function pengurus()
     {
         return $this->belongsTo(PengurusEkstra::class, 'id_pengurus', 'id_pengurus_ekstra');
     }
}
