<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Ekstrakurikuler extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id_ekstrakurikuler';

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


     protected $table = 'ekstrakurikuler';

     protected $fillable = [
         'guru_id',
         'nama_ekstrakurikuler',
         'deskripsi',
         'gambar',
         'status'
     ];
     /**
     * Relationship with PembinaEkstra
     */
    public function pembinaEkstra()
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'id_guru');
    }

    /**
     * Relationship with RegistrasiEkstrakurikuler
     */
    public function nilaiekstra()
    {
        return $this->hasMany(Nilai_ekstra::class);
    }
    public function pengurusekstra()
    {
        return $this->hasMany(PengurusEkstra::class);
    }
    public function inventarisekstra()
    {
        return $this->hasMany(InventarisEkstrakurikuler::class);
    }
    public function laporanpenilaianekstra()
    {
        return $this->hasMany(LaporanPenilaianEkstrakurikuler::class);
    }
    public function postinganekstra()
    {
        return $this->hasMany(PostingEkstrakurikuler::class);
    }
    public function prestasiekstra()
    {
        return $this->hasMany(PrestasiEkstrakurikuler::class);
    }
    public function registrasiekstra()
    {
        return $this->hasMany(RegistrasiEkstrakurikuler::class );
    }
    public function penilaianekstra()
    {
        return $this->hasMany(PenilaianEkstrakurikuler::class);
    }
}
