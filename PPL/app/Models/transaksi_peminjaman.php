<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class transaksi_peminjaman extends Model
{
    use Notifiable;

    /**
     * The "booting" function of model
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (! $model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table = 'transaksi_peminjaman';

    protected $fillable = [
        'id_transaksi_peminjaman',
        'id_buku',
        'kode_peminjam',
        'tgl_awal_peminjaman',
        'tgl_pengembalian',
        'denda',
        'status_pengembalian',
        'jenis_peminjam',
        'status_denda',
        'stok',
    ];
    public $timestamps = false;
    protected $primaryKey = 'id_transaksi_peminjaman';
    
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }
    public function isOverdue()
    {
        return Carbon::parse($this->tgl_pengembalian)->isPast();
    }
    // If you have a Peminjam model, define that relationship here
}
