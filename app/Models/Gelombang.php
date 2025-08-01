<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gelombang extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama',
        'kode',
        'tanggal_mulai',
        'tanggal_selesai',
        'biaya_administrasi',
        'biaya_daftar_ulang',
        'kuota_maksimal',
        'kuota_terisi',
        'status',
        'deskripsi',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'biaya_administrasi' => 'integer',
        'biaya_daftar_ulang' => 'integer',
        'kuota_maksimal' => 'integer',
        'kuota_terisi' => 'integer',
    ];

    // Relationships
    public function santri()
    {
        return $this->hasMany(Santri::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeTersedia($query)
    {
        return $query->where('status', 'aktif')
                    ->where(function($q) {
                        $q->whereNull('kuota_maksimal')
                          ->orWhereRaw('kuota_terisi < kuota_maksimal');
                    });
    }

    // Accessors
    public function getSisaKuotaAttribute()
    {
        if (!$this->kuota_maksimal) return null;
        return max(0, $this->kuota_maksimal - $this->kuota_terisi);
    }

    public function getIsFullAttribute()
    {
        if (!$this->kuota_maksimal) return false;
        return $this->kuota_terisi >= $this->kuota_maksimal;
    }

    public function getTotalBiayaAttribute()
    {
        return $this->biaya_administrasi + $this->biaya_daftar_ulang;
    }
}
