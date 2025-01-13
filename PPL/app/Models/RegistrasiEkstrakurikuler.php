<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
class RegistrasiEkstrakurikuler extends Model
{
    use HasUuids,Notifiable;


    protected $primaryKey = 'id_registrasi';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


     protected $table = 'registrasi_ekstrakurikuler';

     protected $fillable = [
         'id_registrasi',
         'id_siswa',
         'id_ekstrakurikuler',
         'riwayat_penyakit',
         'alasan',
         'no_ortu',
         'status',
         'tgl_registrasi',
     ];

     /**
      * Relationship with Siswa
      */
     public function siswa()
     {
         return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
     }

     /**
      * Relationship with Ekstrakurikuler
      */
     public function ekstrakurikuler()
     {
         return $this->belongsTo(Ekstrakurikuler::class, 'id_ekstrakurikuler', 'id_ekstrakurikuler');
     }
     public function berkas()
     {
         return $this->hasMany(Berkas::class);
     }

}
