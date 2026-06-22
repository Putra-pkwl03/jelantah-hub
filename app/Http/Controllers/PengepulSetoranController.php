<?php

namespace App\Http\Controllers;

use App\Models\Setoran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengepulSetoranController extends Controller
{
   public function dashboard()
    {
        if (Auth::user()->role !== 'pengepul') {
            return redirect('/' . Auth::user()->role . '/dashboard');
        }

        $pengepulId = Auth::id();

        // 1. HITUNG STATISTIK SECARA DINAMIS DARI DATABASE
        
        // Total Stok Tangki = Akumulasi 'liter_bersih' dari setoran yang berstatus 'selesai'
        $totalStok = Setoran::where('pengepul_id', $pengepulId)
            ->where('status', 'selesai')
            ->sum('liter_bersih');

        // Antrean Penjemputan = Jumlah transaksi yang berstatus 'pending' atau 'dijemput'
        $jumlahAntrean = Setoran::where('pengepul_id', $pengepulId)
            ->whereIn('status', ['pending', 'dijemput'])
            ->count();

        // Kas Dana Cair = Total akumulasi 'harga_dibayar' yang telah diserahkan ke masyarakat
        $totalKasCair = Setoran::where('pengepul_id', $pengepulId)
            ->where('status', 'selesai')
            ->sum('harga_dibayar');

        // 2. AMBIL DAFTAR ANTRIAN TRANSAKSI
       $setoranMasuk = Setoran::with(['masyarakat' => function($query) {
        $query->select('id', 'name', 'latitude', 'longitude'); // Pastikan latitude & longitude ikut ditarik
    }])
    ->where('pengepul_id', $pengepulId)
    ->latest()
    ->get();

        return view('dashboard.pengepul', compact('setoranMasuk', 'totalStok', 'jumlahAntrean', 'totalKasCair'));
    }

    /**
     * [UPDATE STATUS] Mengubah status setoran dari 'pending' menjadi 'dijemput'
     */
    public function jemput($id)
    {
        $setoran = Setoran::where('pengepul_id', Auth::id())->findOrFail($id);

        if ($setoran->status !== 'pending') {
            return redirect()->back()->with('error', 'Setoran tidak dalam status pending.');
        }

        $setoran->update([
            'status' => 'dijemput'
        ]);

        return redirect()->back()->with('success', 'Status berhasil diperbarui, minyak siap dijemput!');
    }

    /**
     * [UPDATE - PROCESS] Validasi Akhir: Input endapan, hitung berat bersih & nominal uang
     */
    public function selesai(Request $request, $id)
    {
        $setoran = Setoran::where('pengepul_id', Auth::id())->findOrFail($id);

        // Proteksi alur bisnis: Harus dijemput dulu baru bisa diselesaikan
        if ($setoran->status !== 'dijemput') {
            return redirect()->back()->with('error', 'Setoran harus diubah ke status "dijemput" terlebih dahulu.');
        }

        $request->validate([
            'endapan' => 'required|numeric|min:0',
        ]);

        $hargaPengepul = Auth::user()->harga_per_liter;

        if (is_null($hargaPengepul) || $hargaPengepul <= 0) {
            return redirect()->back()->with('error', 'Anda belum menentukan harga beli per liter di profil Anda!');
        }

        // RUMUS BISNIS (Sesuai Aturan Studi Kasus)
        // 1. Liter Bersih = Liter Estimasi - Endapan
        $literBersih = $setoran->liter_estimasi - $request->endapan;

        if ($literBersih < 0) {
            return redirect()->back()->with('error', 'Jumlah endapan tidak logis karena melebihi estimasi total liter!');
        }

        // 2. Nominal Ke Penyetor = Liter Bersih x Harga Pengepul
        $hargaDibayar = $literBersih * $hargaPengepul;

        // Simpan hasil kalkulasi final
        $setoran->update([
            'endapan' => $request->endapan,
            'liter_bersih' => $literBersih,
            'harga_dibayar' => $hargaDibayar,
            'status' => 'selesai',
        ]);

        return redirect()->back()->with('success', 'Setoran berhasil divalidasi dan selesai dihitung!');
    }

    /**
     * [UPDATE STATUS] Menolak setoran dari masyarakat jika tidak sesuai kriteria awal
     */
    public function tolak($id)
    {
        $setoran = Setoran::where('pengepul_id', Auth::id())->findOrFail($id);

        if (!in_array($setoran->status, ['pending', 'dijemput'])) {
            return redirect()->back()->with('error', 'Setoran yang sudah selesai tidak dapat ditolak.');
        }

        $setoran->update([
            'status' => 'ditolak'
        ]);

        return redirect()->back()->with('success', 'Pengajuan setoran berhasil ditolak.');
    }
}