<?php

namespace App\Http\Controllers\Santri;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SantriController extends Controller
{
    /**
     * Menampilkan form login santri
     */
    public function login()
    {
        return Inertia::render('LoginSantri');
    }

    /**
     * Memproses login santri
     */
    public function check(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|size:4',
            'nama' => 'required|string'
        ], [
            'kode.required' => 'Kode unik harus diisi',
            'kode.size' => 'Kode unik harus 4 karakter',
            'nama.required' => 'Nama lengkap harus diisi'
        ]);

        // Cari pendaftaran berdasarkan kode unik (4 huruf terakhir) dan nama
        $santri = Santri::where('nomor_pendaftaran', 'like', '%' . $request->kode)
            ->where('nama', $request->nama)
            ->first();

        if (!$santri) {
            return back()->withErrors([
                'error' => 'Data pendaftaran tidak ditemukan. Pastikan kode unik dan nama lengkap sudah benar.'
            ]);
        }

        // Simpan data santri ke session
        session([
            'nomor_pendaftaran' => $santri->nomor_pendaftaran,
            'nama_santri' => $santri->nama,
            'is_santri_logged_in' => true
        ]);

        return redirect()->route('santri.dashboard', ['nomor_pendaftaran' => $santri->nomor_pendaftaran]);
    }

    /**
     * Menampilkan dashboard santri
     */
    public function dashboard(Request $request, $nomor_pendaftaran)
    {
        // Cek apakah user sudah login sebagai santri
        if (!session()->has('is_santri_logged_in')) {
            return redirect()->route('santri.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek apakah nomor pendaftaran sesuai dengan yang login
        if (session('nomor_pendaftaran') !== $nomor_pendaftaran) {
            return redirect()->route('santri.login')->with('error', 'Akses tidak diizinkan.');
        }

        $santri = Santri::with(['orangTua', 'dokumen', 'pembayaran'])
            ->where('nomor_pendaftaran', $nomor_pendaftaran)
            ->firstOrFail();

        return Inertia::render('Santri/Dashboard', [
            'santri' => $santri
        ]);
    }

    /**
     * Logout santri
     */
    public function logout()
    {
        session()->forget(['nomor_pendaftaran', 'nama_santri', 'is_santri_logged_in']);
        return redirect()->route('santri.login')->with('success', 'Berhasil logout.');
    }
} 