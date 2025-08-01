<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'santri_id',
        'pasfoto',
        'akta_lahir',
        'kartu_keluarga',
        'ijazah',
        'sertifikat_prestasi',
        'dokumen_pendukung',
        'status_verifikasi',
        'catatan_verifikasi',
    ];

    protected $casts = [
        'dokumen_pendukung' => 'array',
    ];

    // Relationships
    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status_verifikasi', $status);
    }

    public function scopeBelumVerifikasi($query)
    {
        return $query->where('status_verifikasi', 'belum');
    }

    public function scopeDiterima($query)
    {
        return $query->where('status_verifikasi', 'diterima');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status_verifikasi', 'ditolak');
    }

    // Accessors
    public function getIsDiterimaAttribute()
    {
        return $this->status_verifikasi === 'diterima';
    }

    public function getIsDitolakAttribute()
    {
        return $this->status_verifikasi === 'ditolak';
    }

    public function getIsBelumVerifikasiAttribute()
    {
        return $this->status_verifikasi === 'belum';
    }

    // Methods
    public function verifikasi($status, $catatan = null)
    {
        $this->status_verifikasi = $status;
        $this->catatan_verifikasi = $catatan;
        $this->save();

        return $this;
    }

    public function terima($catatan = null)
    {
        return $this->verifikasi('diterima', $catatan);
    }

    public function tolak($catatan = null)
    {
        return $this->verifikasi('ditolak', $catatan);
    }
}
