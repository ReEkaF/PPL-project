<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class HistoriInventaris extends Model
{
    use HasUuids, Notifiable;

    protected $table = 'histori_inventaris';
    
    protected $primaryKey = 'id_histori';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'id_histori',
        'id_inventaris',
        'keterangan',
        'jumlah',
        'histori_keluar',
        'histori_masuk',
    ];

    /**
     * Relationship with InventarisEkstrakurikuler
     */
    public function inventarisEkstrakurikuler()
    {
        return $this->belongsTo(InventarisEkstrakurikuler::class, 'id_inventaris', 'id_inventaris');
    }
}
