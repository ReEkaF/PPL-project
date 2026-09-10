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
    protected static function boot()
    {
        parent::boot(); // Pastikan memanggil parent::boot()
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
    protected $table = 'ekstrakurikuler';

    protected $fillable = [
        'guru_id',
        'nama_ekstrakurikuler',
        'deskripsi',
        'gambar',
        'status',
        'tgl_mulai_pendaftaran',
        'tgl_selesai_pendaftaran',
    ];

    protected $casts = [
        'tgl_mulai_pendaftaran' => 'datetime',
        'tgl_selesai_pendaftaran' => 'datetime',
    ];

    /**
     * Cek apakah pendaftaran saat ini sedang aktif (buka) berdasarkan status & rentang tanggal
     */
    public function isPendaftaranBuka(): bool
    {
        if ($this->status === 'tidak buka') {
            return false;
        }

        $now = now();

        if ($this->tgl_mulai_pendaftaran && $this->tgl_selesai_pendaftaran) {
            return $now->between($this->tgl_mulai_pendaftaran, $this->tgl_selesai_pendaftaran);
        }

        if ($this->tgl_mulai_pendaftaran) {
            return $now->gte($this->tgl_mulai_pendaftaran);
        }

        if ($this->tgl_selesai_pendaftaran) {
            return $now->lte($this->tgl_selesai_pendaftaran);
        }

        return $this->status === 'buka';
    }

    /**
     * Dapatkan status pendaftaran dinamis: 'buka', 'akan_datang', atau 'tutup'
     */
    public function getStatusPendaftaranDinamisAttribute(): string
    {
        if ($this->status === 'tidak buka') {
            return 'tutup';
        }

        $now = now();

        if ($this->tgl_mulai_pendaftaran && $now->lt($this->tgl_mulai_pendaftaran)) {
            return 'akan_datang';
        }

        if ($this->tgl_selesai_pendaftaran && $now->gt($this->tgl_selesai_pendaftaran)) {
            return 'tutup';
        }

        return $this->status === 'buka' ? 'buka' : 'tutup';
    }

    /**
     * Format teks rentang waktu pendaftaran
     */
    public function getRentangPendaftaranFormattedAttribute(): ?string
    {
        if ($this->tgl_mulai_pendaftaran && $this->tgl_selesai_pendaftaran) {
            return $this->tgl_mulai_pendaftaran->translatedFormat('d M Y') . ' - ' . $this->tgl_selesai_pendaftaran->translatedFormat('d M Y');
        }

        if ($this->tgl_mulai_pendaftaran) {
            return 'Mulai ' . $this->tgl_mulai_pendaftaran->translatedFormat('d M Y');
        }

        if ($this->tgl_selesai_pendaftaran) {
            return 's.d. ' . $this->tgl_selesai_pendaftaran->translatedFormat('d M Y');
        }

        return null;
    }

    /**
     * Scope query untuk hanya mengambil ekskul yang pendaftarannya sedang buka sesuai rentang tanggal
     */
    public function scopePendaftaranBuka($query)
    {
        $now = now();

        return $query->where('status', 'buka')
            ->where(function ($q) use ($now) {
                $q->where(function ($sub) use ($now) {
                    $sub->whereNotNull('tgl_mulai_pendaftaran')
                        ->whereNotNull('tgl_selesai_pendaftaran')
                        ->where('tgl_mulai_pendaftaran', '<=', $now)
                        ->where('tgl_selesai_pendaftaran', '>=', $now);
                })
                ->orWhere(function ($sub) use ($now) {
                    $sub->whereNotNull('tgl_mulai_pendaftaran')
                        ->whereNull('tgl_selesai_pendaftaran')
                        ->where('tgl_mulai_pendaftaran', '<=', $now);
                })
                ->orWhere(function ($sub) use ($now) {
                    $sub->whereNull('tgl_mulai_pendaftaran')
                        ->whereNotNull('tgl_selesai_pendaftaran')
                        ->where('tgl_selesai_pendaftaran', '>=', $now);
                })
                ->orWhere(function ($sub) {
                    $sub->whereNull('tgl_mulai_pendaftaran')
                        ->whereNull('tgl_selesai_pendaftaran');
                });
            });
    }

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
        return $this->hasMany(Nilai_ekstra::class, 'id_ekstrakurikuler', 'id_ekstrakurikuler');
    }

    public function pengurusekstra()
    {
        return $this->hasMany(PengurusEkstra::class, 'id_ekstrakurikuler', 'id_ekstrakurikuler');
    }

    public function inventarisekstra()
    {
        return $this->hasMany(InventarisEkstrakurikuler::class, 'id_ekstrakurikuler', 'id_ekstrakurikuler');
    }

    public function laporanpenilaianekstra()
    {
        return $this->hasMany(LaporanPenilaianEkstrakurikuler::class, 'id_ekstrakurikuler', 'id_ekstrakurikuler');
    }

    public function postinganekstra()
    {
        return $this->hasMany(PostingEkstrakurikuler::class, 'id_ekstrakurikuler', 'id_ekstrakurikuler');
    }

    public function prestasiekstra()
    {
        return $this->hasMany(PrestasiEkstrakurikuler::class, 'id_ekstrakurikuler', 'id_ekstrakurikuler');
    }

    public function registrasiekstra()
    {
        return $this->hasMany(RegistrasiEkstrakurikuler::class, 'id_ekstrakurikuler', 'id_ekstrakurikuler');
    }

    public function penilaianekstra()
    {
        return $this->hasMany(PenilaianEkstrakurikuler::class, 'id_ekstrakurikuler', 'id_ekstrakurikuler');
    }
}
