<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrangTua extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orang_tua';

    protected $fillable = [
        'santri_id',
        'nama_ayah',
        'nama_ibu',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'pekerjaan_ayah_lainnya',
        'pekerjaan_ibu_lainnya',
        'pendidikan_ayah',
        'pendidikan_ibu',
        'wa_ayah',
        'wa_ibu',
        'alamat',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'desa_id',
        'kode_pos',
    ];

    // Relationships
    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    // Accessors
    public function getAlamatLengkapAttribute()
    {
        return "{$this->alamat}, Desa {$this->desa_id}, Kecamatan {$this->kecamatan_id}, {$this->kabupaten_id}, {$this->provinsi_id} {$this->kode_pos}";
    }
}
