<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
class Nilai_ekstra extends Model
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
    protected $table = 'nilai_ekstra';
    protected $fillable = [
        'ekstrakurikuler_id',
        'nilai_rata_rata_ekstra',
        'pesan',
    ];
    public function ekstrakurikuler()
    {
        return $this->belongsTo(ekstrakurikuler ::class, 'ekstrakurikuler_id', 'id_ekstrakurikuler');
    }
    public function rapor()
    {
        return $this->belongsTo(rapor::class, 'rapor_id', 'id_rapor');
    }

}
