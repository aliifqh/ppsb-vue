<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Santri extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'santri';

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
        'whatsapp',
    ];

    protected $casts = [
        'anak_ke' => 'integer',
        'jumlah_saudara' => 'integer',
        'tanggal_lahir' => 'date',
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
        return $this->hasMany(DokumenSantri::class);
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
        if ($this->tanggal_lahir) {
            return \Carbon\Carbon::parse($this->tanggal_lahir)->age;
        }
        return 0;
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
                $santri->nomor_pendaftaran = self::generateNomorPendaftaran($santri->unit);
            }
        });
    }

    public static function generateNomorPendaftaran($unit = null)
    {
        // Generate 4 huruf random unik
        $randomLetters = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4));
        
        // Get nomor urut berdasarkan unit
        $unitCode = strtoupper($unit ?? 'GEN');
        
        // Cari nomor terakhir berdasarkan unit
        $lastSantri = self::where('unit', $unit)->latest()->first();

        if ($lastSantri && preg_match('/PSB-' . $unitCode . '-(\d{4})/', $lastSantri->nomor_pendaftaran, $matches)) {
            $lastNumber = (int) $matches[1];
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return sprintf('PSB-%s-%04d-%s', $unitCode, $newNumber, $randomLetters);
    }
}
