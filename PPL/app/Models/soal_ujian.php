<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
class soal_ujian extends Model
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
    protected $primaryKey = 'id_soal_ujian';

    protected $table = 'soal_ujian';

    protected $fillable = [
        'ujian_id',
        'judul_ujian',
        'teks_soal',
        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'kunci_jawaban',
    ];

    /**
     * Relationship with Ujian
     */
    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'ujian_id', 'id_ujian');
    }
    public function jawabanujian()
    {
        return $this->hasMany(jawaban_ujian::class,'soal_id', 'id_soal_ujian');
    }
}
