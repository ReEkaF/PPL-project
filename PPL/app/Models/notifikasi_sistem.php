<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class notifikasi_sistem extends Model
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
    protected $table = 'notifikasi_sistem';
    protected $primaryKey = 'id_notifikasi_sistem';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'materi_id',
        'siswa_id',
        'status',
        'tanggal_dibuat',
        'tanggal_dilihat',
    ];

    /**
     * Relationship with Materi
     */
    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id', 'id_materi');
    }

    /**
     * Relationship with Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id_siswa');
    }
}
