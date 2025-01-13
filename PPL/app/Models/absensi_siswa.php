<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
class absensi_siswa extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id_absensi_siswa';
     /**
     * The "booting" function of model
     *
     * @return void
     */
    protected static function boot() {
        parent::boot(); // Pastikan memanggil parent::boot()
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


    protected $table = 'absensi_siswa';
    protected $fillable = [
        'siswa_id',
        'pertemuan_id',
        'status_absensi',
    ];
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id_siswa');
    }
    public function pertemuan()
    {
        return $this->belongsTo(Pertemuan::class, 'pertemuan_id', 'id_pertemuan');
    }

}
