<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Nilai_mapel extends Model
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
    protected $table = 'nilai_matpel';
    protected $fillable = [
        'id_nilai_matpel',
        'matpel_id',
        'nilai_rata_rata_matpel',
        'pesan',
    ];

    public function mataPelajaran()
    {
        return $this->belongsTo(mata_pelajaran::class, 'matpel_id', 'id_matpel');
    }
    public function rapor()
    {
        return $this->belongsTo(rapor::class, 'rapor_id', 'id_rapor');
    }
}

