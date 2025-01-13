<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class kelas extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kelas';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_kelas';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The type of the primary key.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_kelas',
        'nama_kelas',
    ];

    /**
     * The "booting" function of model
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * Relationship with kelas_mata_pelajaran
     */
    public function kelasmatapelajaran()
    {
        return $this->hasMany(Kelas_mata_pelajaran::class, 'kelas_id', 'id_kelas');
    }
    public function kelas_siswa()
    {
        return $this->hasMany(KelasSiswa::class, 'id_kelas', 'id_kelas');
    }
    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'kelas_siswas', 'id_kelas', 'id_siswa');
    }
     public function getJumlahSiswaAttribute()
    {
        return $this->siswa()->count();
    }
    public function waliKelas()
    {
        return $this->hasOne(KelasSiswa::class, 'id_kelas')->with('guru');
    }
}
