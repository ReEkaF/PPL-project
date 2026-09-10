<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Guru extends Authenticatable
{
    use HasFactory, HasUuids, Notifiable;

    protected $primaryKey = 'id_guru';

    public $incrementing = false;

    public $timestamps = true;

    protected $keyType = 'string';

    protected $table = 'guru';

    protected $fillable = [
        'id_guru',
        'nip',
        'nama_guru',
        'email',
        'google_id',
        'google_token',
        'foto_guru',
        'nomor_wa_guru',
        'username',
        'password',
        'alamat_guru',
        'role_guru',
    ];

    public function gurumatapelajaran()
    {
        return $this->hasMany(guru_mata_pelajaran::class, 'guru_id', 'id_guru');
    }

    public function kelasmatapelajaran()
    {
        return $this->hasMany(kelas_mata_pelajaran::class, 'id_laporan', 'id_laporan');
    }

    public function ekstrakurikuler()
    {
        return $this->hasMany(Ekstrakurikuler::class, 'guru_id', 'id_guru');
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_siswas', 'wali_kelas', 'id_kelas');
    }

    public function kelasSiswas()
    {
        return $this->hasMany(KelasSiswa::class, 'wali_kelas', 'id_guru');
    }

    public function kelasMataPelajaran2nd()
    {
        return $this->hasMany(KelasMataPelajaran::class, 'guru_id');
    }
}
