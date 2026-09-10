<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class file_tugas extends Model
{
    use HasUuids, Notifiable;

    protected $primaryKey = 'id_file_tugas';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'file_tugas';

    protected $fillable = [
        'tugas_id',
        'file_path',
        'file_type',
        'upload_at',
        'original_name',
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id', 'id_tugas');
    }
}
