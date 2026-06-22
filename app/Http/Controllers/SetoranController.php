<?php

namespace App\Http\Controllers;

use App\Models\Setoran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetoranController extends Controller
{
    /**
     * [READ] Menampilkan Dashboard Utama Masyarakat (Statistik / Ringkasan)
     */
public function dashboardMasyarakat()
{
    if (Auth::user()->role !== 'masyarakat') {
        return redirect('/' . Auth::user()->role . '/dashboard');
    }

    $user = Auth::user();
    $userId = Auth::id();

    // 1. Statistik Utama
    $totalPoin = $user->eco_points ?? 0; 
    $totalPengajuan = Setoran::where('masyarakat_id', $userId)->count();
    $totalMinyakSelesai = Setoran::where('masyarakat_id', $userId)
        ->where('status', 'selesai')
        ->sum('liter_bersih'); // Menggunakan liter_bersih agar akurat setelah disaring pengepul

    // 2. Ambil 5 Riwayat Setoran Terbaru Terakhir
    $riwayatTerbaru = Setoran::with('pengepul')
        ->where('masyarakat_id', $userId)
        ->latest()
        ->take(5)
        ->get();

    // 3. Ambil Titik Pengepul Terdekat (Menggunakan Garis Lintang/Bujur User jika ada)
    $lat = $user->latitude ?? -7.5661; // fallback default koordinat jika kosong
    $lon = $user->longitude ?? 110.8243;

    $pengepulTerdekat = User::where('role', 'pengepul')
        ->selectRaw("*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS jarak", [$lat, $lon, $lat])
        ->orderBy('jarak', 'asc')
        ->orderBy('harga_per_liter', 'desc')
        ->take(6) // Ambil 6 pengepul terdekat untuk sebaran peta dashboard
        ->get();

    return view('dashboard.masyarakat', compact(
        'totalPoin', 
        'totalPengajuan', 
        'totalMinyakSelesai', 
        'riwayatTerbaru', 
        'pengepulTerdekat',
        'lat',
        'lon'
    ));
}

    /**
     * [READ] Menampilkan Halaman Riwayat Setoran Khusus (Tabel Log Lengkap)
     */
    public function riwayatMasyarakat()
    {
        if (Auth::user()->role !== 'masyarakat') {
            return redirect('/' . Auth::user()->role . '/dashboard');
        }

        $riwayatSetoran = Setoran::with('pengepul')
            ->where('masyarakat_id', Auth::id())
            ->latest()
            ->get();

        return view('dashboard.masyarakat_riwayat', compact('riwayatSetoran'));
    }

    /**
     * [CREATE] Menampilkan Formulir Pengajuan & Daftar Pengepul
     */
    public function createMasyarakat()
    {
        if (Auth::user()->role !== 'masyarakat') {
            return redirect('/' . Auth::user()->role . '/dashboard');
        }

        $user = Auth::user();
        $lat = $user->latitude;
        $lon = $user->longitude;

        if ($lat && $lon) {
            $daftarPengepul = User::where('role', 'pengepul')
                ->selectRaw("*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS jarak", [$lat, $lon, $lat])
                ->orderBy('jarak', 'asc')
                ->orderBy('harga_per_liter', 'desc')
                ->get();
        } else {
            $daftarPengepul = User::where('role', 'pengepul')->orderBy('harga_per_liter', 'desc')->get();
        }

        return view('dashboard.setoran', compact('daftarPengepul'));
    }

    /**
     * [READ - PENGEPUL] Menampilkan Antrean Setoran dari Masyarakat
     */
    public function indexPengepul()
    {
        $totalStok = Setoran::where('pengepul_id', Auth::id())
                    ->where('status', 'selesai')
                    ->sum('liter_bersih');

        $antreanSetoran = Setoran::with('masyarakat')
                            ->where('pengepul_id', Auth::id())
                            ->where('status', 'pending')
                            ->orderBy('created_at', 'asc')
                            ->get();

        return view('pengepul.setoran.index', compact('totalStok', 'antreanSetoran'));
    }

    public function storeMasyarakat(Request $request)
    {
        $request->validate([
            'pengepul_id'         => 'required|exists:users,id',
            'liter_estimasi'      => 'required|numeric|min:1',
            'tanggal_penjemputan' => 'required|date|after_or_equal:today',
            'jam_penjemputan'     => 'required|date_format:H:i', 
        ]);

        Setoran::create([
            'masyarakat_id'       => Auth::id(),
            'pengepul_id'         => $request->pengepul_id,
            'liter_estimasi'      => $request->liter_estimasi,
            'tanggal_penjemputan' => $request->tanggal_penjemputan,
            'jam_penjemputan'     => $request->jam_penjemputan, 
            'status'              => 'pending',
        ]);

        return redirect()->route('masyarakat.riwayat')->with('success', 'Pengajuan setoran berhasil dikirim!');
    }

    /**
     * [UPDATE] Menampilkan Halaman Edit Setoran
     */
    public function editMasyarakat($id)
    {
        $setoran = Setoran::where('masyarakat_id', Auth::id())->findOrFail($id);

        if ($setoran->status !== 'pending') {
            return redirect()->route('masyarakat.riwayat')->with('error', 'Pengajuan tidak dapat diubah karena sedang/sudah diproses oleh pengepul.');
        }

        $daftarPengepul = User::where('role', 'pengepul')->get();

        return view('dashboard.setoran_edit', compact('setoran', 'daftarPengepul'));
    }

    /**
     * [UPDATE - PROCESS] Memperbarui Data Setoran di Database
     */
    public function updateMasyarakat(Request $request, $id)
    {
        $setoran = Setoran::where('masyarakat_id', Auth::id())->findOrFail($id);

        if ($setoran->status !== 'pending') {
            return redirect()->route('masyarakat.riwayat')->with('error', 'Pengajuan tidak dapat diubah karena sedang/sudah diproses.');
        }

        $request->validate([
            'pengepul_id'         => 'required|exists:users,id',
            'liter_estimasi'      => 'required|numeric|min:1',
            'tanggal_penjemputan' => 'required|date|after_or_equal:today',
            'jam_penjemputan'     => 'required|date_format:H:i', 
        ]);

        $setoran->update([
            'pengepul_id'         => $request->pengepul_id,
            'liter_estimasi'      => $request->liter_estimasi,
            'tanggal_penjemputan' => $request->tanggal_penjemputan,
            'jam_penjemputan'     => $request->jam_penjemputan, 
        ]);

        return redirect()->route('masyarakat.riwayat')->with('success', 'Pengajuan setoran berhasil diperbarui!');
    }

    /**
     * [DELETE] Membatalkan/Menghapus Pengajuan Setoran
     */
    public function destroyMasyarakat($id)
    {
        $setoran = Setoran::where('masyarakat_id', Auth::id())->findOrFail($id);

        if ($setoran->status !== 'pending') {
            return redirect()->route('masyarakat.riwayat')->with('error', 'Pengajuan tidak dapat dibatalkan karena sedang/sudah diproses.');
        }

        $setoran->delete();

        return redirect()->route('masyarakat.riwayat')->with('success', 'Pengajuan setoran berhasil dibatalkan.');
    }

    public function simpanUjiPengepul(Request $request, $id)
    {
        $setoran = Setoran::findOrFail($id);

        $request->validate([
            'liter_clean'  => 'required|numeric|min:0',
            'sediment'     => 'required|numeric|min:0',
        ]);

        $setoran->update([
            'liter_bersih' => $request->liter_clean,
            'endapan'      => $request->sediment,
            'status'       => 'selesai',
        ]);

        return back()->with('success', 'Hasil uji fisik minyak berhasil disimpan!');
    }

    /**
     * =========================================================================
     * TEMPELKAN DI SINI: Method Dashboard untuk Pengepul
     * =========================================================================
     */
    public function dashboardPengepul()
    {
        if (Auth::user()->role !== 'pengepul') {
            return redirect('/' . Auth::user()->role . '/dashboard');
        }

        $pengepulId = Auth::id();

        // 1. Hitung Statistik Dinamis Minyak Jelantah
        $totalStok = Setoran::where('pengepul_id', $pengepulId)
            ->where('status', 'selesai')
            ->sum('liter_bersih');

        // Total transaksi yang perlu diproses/dikonfirmasi
        $jumlahAntrean = Setoran::where('pengepul_id', $pengepulId)
            ->whereIn('status', ['pending', 'dijemput'])
            ->count();

        // Akumulasi pengeluaran uang cash yang dibayarkan ke masyarakat
        $totalKasCair = Setoran::where('pengepul_id', $pengepulId)
            ->where('status', 'selesai')
            ->sum('harga_dibayar');

        // 2. Ambil List Data Setoran Masuk untuk Tabel Dashboard
        $setoranMasuk = Setoran::with('masyarakat')
            ->where('pengepul_id', $pengepulId)
            ->latest()
            ->get();

        // 3. Lempar variabel ke file blade view
        return view('dashboard.pengepul', compact('setoranMasuk', 'totalStok', 'jumlahAntrean', 'totalKasCair'));
    }
}