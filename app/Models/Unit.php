<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'jenjang',
        'usia_minimal',
        'usia_maksimal',
        'aktif',
        'urutan',
        'persyaratan',
        'biaya',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'usia_minimal' => 'integer',
        'usia_maksimal' => 'integer',
        'urutan' => 'integer',
        'persyaratan' => 'array',
        'biaya' => 'array',
    ];

    // Relationships
    public function santri()
    {
        return $this->hasMany(Santri::class, 'unit', 'kode');
    }

    // Many-to-Many relationship dengan Gelombang
    public function gelombangs()
    {
        return $this->belongsToMany(Gelombang::class, 'gelombang_unit')
                    ->withPivot([
                        'kuota_maksimal', 
                        'kuota_terisi', 
                        'biaya_administrasi', 
                        'biaya_daftar_ulang',
                        'aktif',
                        'persyaratan_khusus',
                        'diskon'
                    ])
                    ->withTimestamps();
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeByJenjang($query, $jenjang)
    {
        return $query->where('jenjang', $jenjang);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }

    // Accessors
    public function getNamaLengkapAttribute()
    {
        return "{$this->nama} ({$this->jenjang})";
    }

    public function getRangeUsiaAttribute()
    {
        return "{$this->usia_minimal} - {$this->usia_maksimal} tahun";
    }

    public function getBiayaAdministrasiAttribute()
    {
        return $this->biaya['administrasi'] ?? 0;
    }

    public function getBiayaDaftarUlangAttribute()
    {
        return $this->biaya['daftar_ulang'] ?? 0;
    }

    // Helper methods
    public static function getJenjangOptions()
    {
        return [
            'SD' => 'Sekolah Dasar',
            'SMP' => 'Sekolah Menengah Pertama',
            'SMA' => 'Sekolah Menengah Atas',
            'SMK' => 'Sekolah Menengah Kejuruan',
            'MA' => 'Madrasah Aliyah',
            'MTs' => 'Madrasah Tsanawiyah',
            'MI' => 'Madrasah Ibtidaiyah',
        ];
    }

    public function isUsiaValid($usia)
    {
        return $usia >= $this->usia_minimal && $usia <= $this->usia_maksimal;
    }

    public function getPersyaratanListAttribute()
    {
        return $this->persyaratan ?? [];
    }

    // Constants
    const JENJANG_SD = 'SD';
    const JENJANG_SMP = 'SMP';
    const JENJANG_SMA = 'SMA';
    const JENJANG_SMK = 'SMK';
    const JENJANG_MA = 'MA';
    const JENJANG_MTs = 'MTs';
    const JENJANG_MI = 'MI';
} 