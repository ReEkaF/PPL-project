<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class kategori_buku extends Model
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
    protected $table = 'kategori_buku';
    protected $fillable = [
        'id_kategori_buku',
        'nama_kategori'
    ];
    public $timestamps = false;
    protected $primaryKey = 'id_kategori_buku';
    public function buku()
    {
        return $this->hasMany(Buku::class,  'id_kategori_buku', 'id_kategori_buku');
    }
}
