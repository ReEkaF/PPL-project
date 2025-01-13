<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Testing\Fluent\Concerns\Has;

class Staffakademik extends Authenticatable
{

    use Notifiable, HasFactory;
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
     *P
     * @var array
     */
    public $timestamps = false;
    protected $primaryKey = 'id_staff_akademik';

    protected $table = 'staffakademik';
    protected $fillable = [
        'id_staff_akademik',
        'username',
        'password',
        'email',
        'nama_staff_akademik', 
        'wa_staff_akademik', 
        'alamat_staff_akademik', 
        'google_id',
        'google_token',
    ];
    
}
