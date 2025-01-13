<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
class pengumpulan_ujian extends Model
{
    use Notifiable;

    /**
     * The "booting" function of model
     *
     * @return void
     */
    protected static function boot() {
        parent::boot();
        static::creating(function ($model) {
            if ( ! $model->getKey()) {
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
    protected $table = 'pengumpulan_ujian';
    protected $primaryKey = 'id_pengumpulan_ujian';

    protected $fillable = [
        'ujian_id',
        'siswa_id',
        'tanggal_pengumpulan',
        'nilai',
    ];

    /**
     * Relationship with Ujian
     */
    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'ujian_id', 'id_ujian');
    }

    /**
     * Relationship with Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id_siswa');
    }
    public function jawabanujian()
    {
        return $this->hasMany(jawaban_ujian::class );
    }
}
