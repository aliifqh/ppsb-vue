<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Santri extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'gelombang_id',
        'nomor_pendaftaran',
        'unit',
        'nama',
        'nisn',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'asal_sekolah',
        'anak_ke',
        'jumlah_saudara',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'anak_ke' => 'integer',
        'jumlah_saudara' => 'integer',
    ];

    // Relationships
    public function gelombang()
    {
        return $this->belongsTo(Gelombang::class);
    }

    public function orangTua()
    {
        return $this->hasOne(OrangTua::class);
    }

    public function dokumen()
    {
        return $this->hasOne(Dokumen::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function statusPendaftaran()
    {
        return $this->hasOne(StatusPendaftaran::class);
    }

    // Scopes
    public function scopeByGelombang($query, $gelombangId)
    {
        return $query->where('gelombang_id', $gelombangId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->whereHas('statusPendaftaran', function($q) use ($status) {
            $q->where('status', $status);
        });
    }

    // Accessors
    public function getUmurAttribute()
    {
        return $this->tanggal_lahir->age;
    }

    public function getNamaLengkapAttribute()
    {
        return $this->nama;
    }

    // Boot method untuk generate nomor pendaftaran otomatis
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($santri) {
            if (empty($santri->nomor_pendaftaran)) {
                $santri->nomor_pendaftaran = self::generateNomorPendaftaran();
            }
        });
    }

    public static function generateNomorPendaftaran()
    {
        $year = date('Y');
        $lastSantri = self::whereYear('created_at', $year)->latest()->first();

        if ($lastSantri) {
            $lastNumber = (int) substr($lastSantri->nomor_pendaftaran, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return sprintf('PPSB%s%04d', $year, $newNumber);
    }
}
