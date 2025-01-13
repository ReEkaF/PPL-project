<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Berkas extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id_berkas';

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


    protected $table = 'berkas';
    protected $fillable = [
        'id_registrasi',
        'surat_izin_ortu',
        'surat_riwayat_penyakit',
    ];
    public function registrasiEkstrakurikuler()
    {
        return $this->belongsTo(RegistrasiEkstrakurikuler::class, 'id_registrasi', 'id_registrasi');
    }

}
