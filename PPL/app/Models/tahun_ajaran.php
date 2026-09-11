<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class tahun_ajaran extends Model
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
    protected $table = 'tahun_ajaran';

    public $timestamps = false;

    protected $primaryKey = 'id_tahun_ajaran';

    protected $fillable = [
        'id_tahun_ajaran',
        'tahun_mulai',
        'tahun_selesai',
        'semester',
        'aktif',
    ];

    public function rapor()
    {
        return $this->hasMany(Rapor::class, 'tahun_ajaran_id', 'id_tahun_ajaran');
    }

    public function kelasmatapelajaran()
    {
        return $this->hasMany(kelas_mata_pelajaran::class, 'tahun_ajaran_id', 'id_tahun_ajaran');
    }

    public function penilaianekstra()
    {
        return $this->hasMany(PenilaianEkstrakurikuler::class, 'id_tahun_ajaran', 'id_tahun_ajaran');
    }

    public function kelassiswa()
    {
        return $this->hasMany(KelasSiswa::class, 'tahun_ajaran', 'id_tahun_ajaran');
    }
}
