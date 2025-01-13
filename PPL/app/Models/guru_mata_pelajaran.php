<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class guru_mata_pelajaran extends Model
{
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
    protected $table = 'guru_mata_pelajaran';
    public $timestamps = false;
    protected $primaryKey = 'id_guru_mata_pelajaran';
    protected $fillable = [
        'id_guru_mata_pelajaran',
        'guru_id',
        'matpel_id',
    ];
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'id_guru');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(mata_pelajaran::class, 'matpel_id', 'id_matpel');
    }
}
