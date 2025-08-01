<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\OrangTua;
use App\Models\Gelombang;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class FormulirController extends Controller
{
    public function index()
    {
        // Cek apakah ada gelombang yang aktif
        $gelombangAktif = Gelombang::where('status', 'aktif')->first();
        
        if (!$gelombangAktif) {
            return Inertia::render('Formulir', [
                'error' => 'Tidak ada gelombang pendaftaran yang aktif saat ini.',
                'gelombangAktif' => null
            ]);
        }

        // Ambil semua unit yang aktif di gelombang ini
        $units = $gelombangAktif->units()
                    ->where('units.aktif', true)
                    ->where('gelombang_unit.aktif', true)
                    ->orderBy('units.urutan')
                    ->get()
                    ->map(function($unit) use ($gelombangAktif) {
                        $pivot = $gelombangAktif->getUnitPivot($unit->id);
                        return [
                            'id' => $unit->id,
                            'kode' => $unit->kode,
                            'nama' => $unit->nama,
                            'deskripsi' => $unit->deskripsi,
                            'jenjang' => $unit->jenjang,
                            'usia_minimal' => $unit->usia_minimal,
                            'usia_maksimal' => $unit->usia_maksimal,
                            'aktif' => $unit->aktif,
                            'urutan' => $unit->urutan,
                            'persyaratan' => $unit->persyaratan,
                            'biaya' => $unit->biaya,
                            'kuota_maksimal' => $pivot->kuota_maksimal ?? 100,
                            'kuota_terisi' => $pivot->kuota_terisi ?? 0,
                            'sisa_kuota' => $gelombangAktif->getUnitSisaKuota($unit->id),
                            'biaya_administrasi' => $pivot->biaya_administrasi ?? 0,
                            'biaya_daftar_ulang' => $pivot->biaya_daftar_ulang ?? 0,
                            'persyaratan_khusus' => $pivot->persyaratan_khusus ?? [],
                            'diskon' => $pivot->diskon ?? [],
                        ];
                    });

        return Inertia::render('Formulir', [
            'gelombangAktif' => $gelombangAktif,
            'units' => $units,
            'error' => null
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Validasi input - simple aja
            $validator = Validator::make($request->all(), [
                'unit' => 'required',
                'nama' => 'required',
                'jenis_kelamin' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required|date',
                'asal_sekolah' => 'required',
                'anak_ke' => 'required',
                'jumlah_saudara' => 'required',
                'whatsapp' => 'required',
                'nama_ayah' => 'required',
                'nama_ibu' => 'required',
                'provinsi' => 'required',
                'kabupaten' => 'required',
                'kecamatan' => 'required',
                'desa' => 'required',
                'alamat_lengkap' => 'required',
                'kode_pos' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Cek gelombang aktif
            $gelombangAktif = Gelombang::where('status', 'aktif')->first();
            if (!$gelombangAktif) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada gelombang pendaftaran yang aktif'
                ], 400);
            }

            DB::beginTransaction();

            // Cek kuota unit
            $unit = Unit::where('kode', $request->unit)->first();
            if (!$unit) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unit tidak ditemukan'
                ], 400);
            }

            if (!$gelombangAktif->isUnitAvailable($unit->id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kuota untuk unit ini sudah penuh'
                ], 400);
            }

            // Buat data santri
            $santri = Santri::create([
                'gelombang_id' => $gelombangAktif->id,
                'unit' => $request->unit,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => \Carbon\Carbon::parse($request->tanggal_lahir)->format('Y-m-d'),
                'asal_sekolah' => $request->asal_sekolah,
                'anak_ke' => $request->anak_ke,
                'jumlah_saudara' => $request->jumlah_saudara,
                'whatsapp' => $request->whatsapp,
            ]);

            // Increment kuota unit
            $gelombangAktif->incrementUnitKuota($unit->id);

            // Buat data orang tua
            $orangTua = OrangTua::create([
                'santri_id' => $santri->id,
                'nama_ayah' => $request->nama_ayah,
                'nama_ibu' => $request->nama_ibu,
                'provinsi_id' => $request->provinsi,
                'kabupaten_id' => $request->kabupaten,
                'kecamatan_id' => $request->kecamatan,
                'desa_id' => $request->desa,
                'alamat' => $request->alamat_lengkap,
                'kode_pos' => $request->kode_pos,
                'wa_ayah' => $request->whatsapp,
                'wa_ibu' => $request->whatsapp,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil! Nomor pendaftaran Anda: ' . $santri->nomor_pendaftaran,
                'data' => [
                    'santri_id' => $santri->id,
                    'nomor_pendaftaran' => $santri->nomor_pendaftaran,
                    'nama' => $santri->nama,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            \Log::error('Error in FormulirController@store: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function success($nomorPendaftaran)
    {
        $santri = Santri::where('nomor_pendaftaran', $nomorPendaftaran)->first();
        
        if (!$santri) {
            return redirect()->route('formulir.index');
        }

        return Inertia::render('FormulirSuccess', [
            'santri' => $santri
        ]);
    }
} 