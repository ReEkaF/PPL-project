<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class materi extends Model
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
    protected $table = 'materi';
    protected $primaryKey = 'id_materi';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'judul_materi',
        'deskripsi',
        'topik_id',
        'kelas_mata_pelajaran_id',
        'status',
    ];
    public function topik()
    {
        return $this->belongsTo(Topik::class, 'topik_id', 'id_topik');
    }

    public function kelasMataPelajaran()
    {
        return $this->belongsTo(kelas_mata_pelajaran::class, 'kelas_mata_pelajaran_id', 'id_kelas_mata_pelajaran');
    }
    public function fileMateri()
    {
        return $this->hasMany(file_materi::class, 'materi_id', 'id_materi');
    }
    public function notifikasiSistem()
    {
        return $this->hasMany(notifikasi_sistem::class, 'materi_id', 'id_materi');
    }
}
