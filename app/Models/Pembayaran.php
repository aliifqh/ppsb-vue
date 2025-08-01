<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembayaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pembayaran';

    protected $fillable = [
        'santri_id',
        'gelombang_id',
        'jenis',
        'nominal',
        'dibayar',
        'sisa',
        'status',
        'bukti_pembayaran',
        'bukti_verifikasi',
        'verified_by',
        'tgl_bayar',
        'tgl_verifikasi',
        'catatan_santri',
        'catatan_admin',
        'metadata',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
        'dibayar' => 'decimal:2',
        'sisa' => 'decimal:2',
        'tgl_bayar' => 'datetime',
        'tgl_verifikasi' => 'datetime',
        'metadata' => 'array',
    ];

    // Relationships
    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function gelombang()
    {
        return $this->belongsTo(Gelombang::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function riwayatPembayaran()
    {
        return $this->hasMany(RiwayatPembayaran::class);
    }

    // Scopes
    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis', $jenis);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeLunas($query)
    {
        return $query->where('status', 'lunas');
    }

    public function scopeBelumLunas($query)
    {
        return $query->whereIn('status', ['belum', 'sebagian']);
    }

    // Accessors
    public function getIsLunasAttribute()
    {
        return $this->status === 'lunas';
    }

    public function getIsVerifikasiAttribute()
    {
        return $this->status === 'verifikasi';
    }

    public function getPersentaseBayarAttribute()
    {
        if ($this->nominal == 0) return 0;
        return round(($this->dibayar / $this->nominal) * 100, 2);
    }

    // Methods
    public function updateStatus()
    {
        if ($this->dibayar >= $this->nominal) {
            $this->status = 'lunas';
            $this->sisa = 0;
        } elseif ($this->dibayar > 0) {
            $this->status = 'sebagian';
            $this->sisa = $this->nominal - $this->dibayar;
        } else {
            $this->status = 'belum';
            $this->sisa = $this->nominal;
        }

        $this->save();
    }

    public function tambahPembayaran($jumlah, $metode = 'transfer', $bukti = null, $nomorRef = null)
    {
        $this->dibayar += $jumlah;
        $this->updateStatus();

        // Buat riwayat pembayaran
        $this->riwayatPembayaran()->create([
            'santri_id' => $this->santri_id,
            'jumlah_bayar' => $jumlah,
            'metode_pembayaran' => $metode,
            'nomor_referensi' => $nomorRef,
            'bukti_transaksi' => $bukti,
            'tgl_transaksi' => now(),
        ]);

        return $this;
    }

    public function verifikasi($userId, $buktiVerifikasi = null, $catatan = null)
    {
        $this->status = 'verifikasi';
        $this->verified_by = $userId;
        $this->bukti_verifikasi = $buktiVerifikasi;
        $this->catatan_admin = $catatan;
        $this->tgl_verifikasi = now();
        $this->save();

        return $this;
    }
}
