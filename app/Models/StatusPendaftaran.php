<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPendaftaran extends Model
{
    use HasFactory;

    protected $table = 'status_pendaftaran';

    protected $fillable = [
        'santri_id',
        'status',
        'formulir_lengkap',
        'dokumen_lengkap',
        'pembayaran_lunas',
        'verifikasi_admin',
        'tgl_submit',
        'tgl_review',
        'tgl_approved',
        'tgl_registered',
        'reviewed_by',
        'approved_by',
        'catatan_review',
        'catatan_approval',
    ];

    protected $casts = [
        'formulir_lengkap' => 'boolean',
        'dokumen_lengkap' => 'boolean',
        'pembayaran_lunas' => 'boolean',
        'verifikasi_admin' => 'boolean',
        'tgl_submit' => 'datetime',
        'tgl_review' => 'datetime',
        'tgl_approved' => 'datetime',
        'tgl_registered' => 'datetime',
    ];

    // Relationships
    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRegistered($query)
    {
        return $query->where('status', 'registered');
    }

    // Accessors
    public function getIsDraftAttribute()
    {
        return $this->status === 'draft';
    }

    public function getIsSubmittedAttribute()
    {
        return $this->status === 'submitted';
    }

    public function getIsApprovedAttribute()
    {
        return $this->status === 'approved';
    }

    public function getIsRegisteredAttribute()
    {
        return $this->status === 'registered';
    }

    public function getProgressAttribute()
    {
        $progress = 0;
        if ($this->formulir_lengkap) $progress += 25;
        if ($this->dokumen_lengkap) $progress += 25;
        if ($this->pembayaran_lunas) $progress += 25;
        if ($this->verifikasi_admin) $progress += 25;
        return $progress;
    }

    // Methods
    public function submit()
    {
        $this->status = 'submitted';
        $this->tgl_submit = now();
        $this->save();

        return $this;
    }

    public function review($userId, $catatan = null)
    {
        $this->status = 'review';
        $this->reviewed_by = $userId;
        $this->tgl_review = now();
        $this->catatan_review = $catatan;
        $this->save();

        return $this;
    }

    public function approve($userId, $catatan = null)
    {
        $this->status = 'approved';
        $this->approved_by = $userId;
        $this->tgl_approved = now();
        $this->catatan_approval = $catatan;
        $this->verifikasi_admin = true;
        $this->save();

        return $this;
    }

    public function reject($userId, $catatan = null)
    {
        $this->status = 'rejected';
        $this->reviewed_by = $userId;
        $this->tgl_review = now();
        $this->catatan_review = $catatan;
        $this->save();

        return $this;
    }

    public function register()
    {
        $this->status = 'registered';
        $this->tgl_registered = now();
        $this->save();

        return $this;
    }

    public function updateProgress()
    {
        $santri = $this->santri;

        // Check formulir completeness
        $this->formulir_lengkap = !empty($santri->nama) && !empty($santri->nisn) &&
                                 !empty($santri->tempat_lahir) && !empty($santri->tanggal_lahir);

        // Check dokumen completeness
        $dokumen = $santri->dokumen;
        $this->dokumen_lengkap = $dokumen && !empty($dokumen->pasfoto) &&
                                !empty($dokumen->akta_lahir) && !empty($dokumen->kartu_keluarga) &&
                                !empty($dokumen->ijazah);

        // Check payment completeness
        $pembayaranLunas = $santri->pembayaran()->where('status', 'lunas')->count();
        $totalPembayaran = $santri->pembayaran()->count();
        $this->pembayaran_lunas = $totalPembayaran > 0 && $pembayaranLunas === $totalPembayaran;

        $this->save();

        return $this;
    }
}
