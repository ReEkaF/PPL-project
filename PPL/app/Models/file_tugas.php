<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
class file_tugas extends Model
{
    use Notifiable;
    public $timestamps = false;
    protected $primaryKey = 'id_file_tugas';

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
    protected $table = 'file_tugas';
    protected $fillable = [
        'tugas_id',
        'file_path',
        'file_type',
        'upload_at',
    ];
    
    
    public function tugas()
{
    return $this->belongsTo(Tugas::class, 'tugas_id', 'id_tugas');
}

}