<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Notifications\Notifiable;


class InventarisEkstrakurikuler extends Model
{

    use HasUuids, Notifiable;

    protected $table = 'inventaris_ekstrakurikuler';
    
    protected $primaryKey = 'id_inventaris';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'id_inventaris',
        'id_ekstrakurikuler',
        'nama_barang',
        'stok',
    ];

    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'id_ekstrakurikuler', 'id_ekstrakurikuler');
    }

    /**
     * Relationship with HistoriInventaris
    */
    public function historiInventaris()
    {
        return $this->hasMany(HistoriInventaris::class, 'id_inventaris', 'id_inventaris');
    }
}
