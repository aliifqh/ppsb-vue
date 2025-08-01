<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPembayaran extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pembayaran';

    protected $fillable = [
        'pembayaran_id',
        'santri_id',
        'jumlah_bayar',
        'metode_pembayaran',
        'nomor_referensi',
        'bukti_transaksi',
        'status',
        'verified_by',
        'tgl_transaksi',
        'tgl_verifikasi',
        'catatan',
    ];

    protected $casts = [
        'jumlah_bayar' => 'decimal:2',
        'tgl_transaksi' => 'datetime',
        'tgl_verifikasi' => 'datetime',
    ];

    // Relationships
    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class);
    }

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Scopes
    public function scopeByMetode($query, $metode)
    {
        return $query->where('metode_pembayaran', $metode);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDiterima($query)
    {
        return $query->where('status', 'diterima');
    }

    // Accessors
    public function getIsPendingAttribute()
    {
        return $this->status === 'pending';
    }

    public function getIsDiterimaAttribute()
    {
        return $this->status === 'diterima';
    }

    public function getIsDitolakAttribute()
    {
        return $this->status === 'ditolak';
    }

    // Methods
    public function terima($userId, $catatan = null)
    {
        $this->status = 'diterima';
        $this->verified_by = $userId;
        $this->tgl_verifikasi = now();
        $this->catatan = $catatan;
        $this->save();

        return $this;
    }

    public function tolak($userId, $catatan = null)
    {
        $this->status = 'ditolak';
        $this->verified_by = $userId;
        $this->tgl_verifikasi = now();
        $this->catatan = $catatan;
        $this->save();

        return $this;
    }
}
