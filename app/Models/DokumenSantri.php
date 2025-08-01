<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenSantri extends Model
{
    use HasFactory;

    protected $table = 'dokumen_santri';

    protected $fillable = [
        'santri_id',
        'jenis',
        'nama_file',
        'path',
        'mime_type',
        'size',
        'status',
        'catatan',
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    // Relationships
    public function santri()
    {
        return $this->belongsTo(Santri::class);
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

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Accessors
    public function getSizeInMbAttribute()
    {
        return round($this->size / 1024 / 1024, 2);
    }

    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }

    public function getIsImageAttribute()
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    public function getIsPdfAttribute()
    {
        return $this->mime_type === 'application/pdf';
    }

    // Constants untuk jenis dokumen
    const JENIS_KTP = 'ktp';
    const JENIS_KK = 'kk';
    const JENIS_AKTA = 'akta';
    const JENIS_IJAZAH = 'ijazah';
    const JENIS_FOTO = 'foto';
    const JENIS_SURAT_SEHAT = 'surat_sehat';
    const JENIS_LAINNYA = 'lainnya';

    // Constants untuk status
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    // Helper methods
    public static function getJenisOptions()
    {
        return [
            self::JENIS_KTP => 'KTP',
            self::JENIS_KK => 'Kartu Keluarga',
            self::JENIS_AKTA => 'Akta Kelahiran',
            self::JENIS_IJAZAH => 'Ijazah',
            self::JENIS_FOTO => 'Foto',
            self::JENIS_SURAT_SEHAT => 'Surat Sehat',
            self::JENIS_LAINNYA => 'Lainnya',
        ];
    }

    public static function getStatusOptions()
    {
        return [
            self::STATUS_PENDING => 'Menunggu Review',
            self::STATUS_APPROVED => 'Diterima',
            self::STATUS_REJECTED => 'Ditolak',
        ];
    }

    public function getJenisLabelAttribute()
    {
        return self::getJenisOptions()[$this->jenis] ?? $this->jenis;
    }

    public function getStatusLabelAttribute()
    {
        return self::getStatusOptions()[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'yellow',
            self::STATUS_APPROVED => 'green',
            self::STATUS_REJECTED => 'red',
            default => 'gray'
        };
    }
} 