<?php

namespace App\Http\Controllers;

use App\Models\Setoran;
use App\Models\User;
use App\Models\Hub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StakeholderController extends Controller
{
    /**
     * Dashboard Utama Stakeholder + Logika Prediksi AI Dana Pembelian + Overlay Lokasi Jaringan
     */
    public function index()
    {
        if (Auth::user()->role !== 'stakeholder') {
            return redirect('/' . Auth::user()->role . '/dashboard');
        }

        // Statistik Dashboard Utama
        $totalMinyakSelesai = Setoran::where('status', 'selesai')->sum('liter_final') ?? 0;
        $antreanKendaliMutu = Setoran::whereIn('status', ['proses', 'dijemput'])->count(); 
        $totalPengeluaranInsentif = Setoran::where('status', 'selesai')->sum('harga_dibayar') ?? 0;

        // 2. Logika Utama AI/ML: Prediksi Dana Pembelian Bulan Depan (Linear Regression)
        $historiBulanan = Setoran::where('status', 'selesai')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%m') as bulan_angka"),
                DB::raw("SUM(harga_dibayar) as total_biaya")
            )
            ->groupBy('bulan_angka')
            ->orderBy('bulan_angka', 'asc')
            ->take(6)
            ->get();

        $prediksiDanaBulanDepan = $this->hitungLinearRegression($historiBulanan);

        // 3. Ambil Log Transaksi Gabungan untuk Audit Kendali Mutu
        $semuaSetoran = Setoran::with(['masyarakat', 'pengepul'])
            ->latest()
            ->paginate(10);

        // 4. KOORDINAT JARINGAN UNTUK PETA LEAFLET
        $titikPetaPengepul = User::where('role', 'pengepul')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['id', 'name', 'latitude', 'longitude']);

        $titikPetaMasyarakat = User::where('role', 'masyarakat')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['id', 'name', 'latitude', 'longitude']);

        // 5. [FITUR PEMBEDA JURI] Hitung Titik Rekomendasi Hub Baru Menggunakan K-Means
        $titikRekomendasiHub = $this->hitungCentroidRekomendasi($titikPetaMasyarakat);

        return view('dashboard.stakeholder', compact(
            'totalMinyakSelesai',
            'antreanKendaliMutu',
            'totalPengeluaranInsentif',
            'prediksiDanaBulanDepan',
            'semuaSetoran',
            'titikPetaPengepul',
            'titikPetaMasyarakat',
            'titikRekomendasiHub'
        ));
    }

    /**
     * Mesin Algoritma Regresi Linier Sederhana (Y = a + bX)
     */
    private function hitungLinearRegression($data)
    {
        $n = $data->count();
        if ($n < 2) {
            return Setoran::where('status', 'selesai')->avg('harga_dibayar') * 1.15 ?? 500000;
        }

        $sumX = 0; $sumY = 0; $sumXY = 0; $sumX2 = 0;
        
        foreach ($data as $index => $row) {
            $x = $index + 1; 
            $y = $row->total_biaya;

            $sumX += $x;
            $sumY += $y;
            $sumXY += ($x * $y);
            $sumX2 += ($x * $x);
        }

        $b = (($n * $sumXY) - ($sumX * $sumY)) / (($n * $sumX2) - ($sumX * $sumX));
        $a = ($sumY - ($b * $sumX)) / $n;

        $xBerikutnya = $n + 1;
        $hasilPrediksi = $a + ($b * $xBerikutnya);

        return max($hasilPrediksi, 200000); 
    }

    /**
     * Algoritma Mencari Centroid (Titik Tengah) K-Means Kluster Penyetor
     */
    private function hitungCentroidRekomendasi($masyarakatCollection)
    {
        if ($masyarakatCollection->isEmpty()) {
            return null;
        }

        $totalLat = 0;
        $totalLng = 0;
        $count = $masyarakatCollection->count();

        foreach ($masyarakatCollection as $user) {
            $totalLat += $user->latitude;
            $totalLng += $user->longitude;
        }

        return [
            'latitude' => $totalLat / $count,
            'longitude' => $totalLng / $count,
            'total_penyetor_sekitar' => $count
        ];
    }

    /**
     * Halaman Pengaturan Harga Acuan & Lokasi Pabrik PT HEN
     */
/**
     * Halaman Pengaturan Harga Acuan & Lokasi Pabrik PT HEN
     */
    public function hargaIndex()
    {
        if (Auth::user()->role !== 'stakeholder') {
            return redirect('/' . Auth::user()->role . '/dashboard');
        }
        
        $stakeholder = Auth::user();

        // 1. Ambil data koordinat jaringan untuk peta leaflet
        $titikPetaPengepul = User::where('role', 'pengepul')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['id', 'name', 'latitude', 'longitude']);

        $titikPetaMasyarakat = User::where('role', 'masyarakat')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['id', 'name', 'latitude', 'longitude']);

        // 2. Hitung Titik Rekomendasi Hub Baru Menggunakan K-Means
        $titikRekomendasiHub = $this->hitungCentroidRekomendasi($titikPetaMasyarakat);

        // [BARU] 3. Ambil data semua Hub untuk disajikan pada Data Table komponen kanan
        $semuaHub = Hub::latest()->get();

        // 4. Compact semua variabel ke view tujuan
        return view('stakeholder.harga.index', compact(
            'stakeholder',
            'titikPetaPengepul',
            'titikPetaMasyarakat',
            'titikRekomendasiHub',
            'semuaHub' // Pastikan ini di-compact agar tidak memicu error undefined variable di prop blade
        ));
    }

    /**
     * Simpan / Perbarui Harga Acuan PT HEN (Aksi POST)
     */
    public function hargaUpdate(Request $request)
    {
        $request->validate([
            'harga_per_liter' => 'required|numeric|min:1000'
        ]);

        Auth::user()->update([
            'harga_per_liter' => $request->harga_per_liter
        ]);

        return redirect()->back()->with('success', 'Harga acuan nasional PT HEN berhasil diperbarui.');
    }

    /**
     * Halaman List Pengiriman Masuk dari Pengepul (Validasi & Lab Rekap)
     */
    public function pengirimanIndex()
    {
        if (Auth::user()->role !== 'stakeholder') {
            return redirect('/' . Auth::user()->role . '/dashboard');
        }

        $antreanSetoran = Setoran::with('pengepul')
            ->latest()
            ->paginate(10);

        return view('stakeholder.pengiriman.index', compact('antreanSetoran'));
    }

    /**
     * STEP 1 KENDALI MUTU: Form Input Angka Parameter Hasil Uji Laboratorium
     */
    public function editLab($id)
    {
        $setoran = Setoran::findOrFail($id);
        return view('dashboard.stakeholder_lab', compact('setoran'));
    }

    /**
     * STEP 1 PROCESS: Menghitung Otomatis Grade Berdasarkan Batas Toleransi Avtur/SAF
     */
    public function updateLab(Request $request, $id)
    {
        $request->validate([
            'kadar_air' => 'required|numeric|min:0|max:100',
            'ffa'       => 'required|numeric|min:0|max:100',
            'kotoran'   => 'required|numeric|min:0|max:100',
        ]);

        $setoran = Setoran::findOrFail($id);
        
        // Klasifikasi klas mutu otomatis standar sertifikasi Avtur/SAF
        if ($request->kadar_air <= 0.15 && $request->ffa <= 1.5 && $request->kotoran <= 0.02) {
            $grade = 'Grade A (Premium SAF)';
        } elseif ($request->kadar_air <= 0.50 && $request->ffa <= 3.0 && $request->kotoran <= 0.05) {
            $grade = 'Grade B (Standar)';
        } else {
            $grade = 'Grade C (Butuh Olah Ulang / Reject)';
        }

        $setoran->update([
            'kadar_air' => $request->kadar_air,
            'ffa'       => $request->ffa,
            'kotoran'   => $request->kotoran,
            'grade'     => $grade,
        ]);

        return redirect()->route('stakeholder.pengiriman.index')->with('success', "Hasil analisis laboratorium untuk TRX #{$id} berhasil disimpan! Grade minyak terhitung: {$grade}. Silakan lanjutkan ke tahap otorisasi masuk.");
    }

    /**
     * STEP 2 OPERASIONAL: Form Otorisasi Terima/Tolak + Input Volume Final (Pemisahan Logika)
     */
    public function editOtorisasi($id)
    {
        $setoran = Setoran::findOrFail($id);

        // Proteksi bisnis: Uji lab harus diisi terlebih dahulu sebelum manajer bisa merilis otorisasi
        if (is_null($setoran->grade)) {
            return redirect()->route('stakeholder.pengiriman.index')->with('error', 'Transaksi ini belum melalui pengujian laboratorium!');
        }

        return view('dashboard.stakeholder_otorisasi', compact('setoran'));
    }

    /**
     * STEP 2 PROCESS: Eksekusi Validasi Terima/Tolak Operasional & Penyusutan Netto Volume Pabrik
     */
    public function updateOtorisasi(Request $request, $id)
    {
        $request->validate([
            'status_validasi' => 'required|in:terima,tolak',
            'liter_final'     => 'required_if:status_validasi,terima|numeric|min:0',
        ]);

        $setoran = Setoran::findOrFail($id);

        if ($request->status_validasi === 'terima') {
            // Cek logis agar volume final penyaringan pabrik tidak melebihi kiriman awal pengepul
            if ($request->liter_final > $setoran->liter_bersih) {
                return redirect()->back()->with('error', 'Volume bersih akhir (liter_final) tidak boleh melebihi volume awal dari pengepul!');
            }

            $setoran->update([
                'liter_final' => $request->liter_final,
                'status'      => 'selesai'
            ]);
            
            $pesan = "Muatan minyak TRX-ID #{$id} resmi DITERIMA dengan volume bersih komersial pabrik {$request->liter_final} Liter.";
        } else {
            $setoran->update([
                'liter_final' => 0,
                'status'      => 'ditolak'
            ]);
            
            $pesan = "Muatan minyak TRX-ID #{$id} resmi DITOLAK operasional dan dikembalikan ke pihak pengepul.";
        }

        return redirect()->route('stakeholder.pengiriman.index')->with('success', $pesan);
    }

    /**
     * Audit Log Panel
     */
    public function auditLog()
    {
        if (Auth::user()->role !== 'stakeholder') {
            return redirect('/' . Auth::user()->role . '/dashboard');
        }

        $semuaSetoran = Setoran::with(['masyarakat', 'pengepul'])
            ->latest()
            ->paginate(10);

        return view('dashboard.stakeholder_audit', compact('semuaSetoran'));
    }

    /**
     * Menyimpan Lokasi Hub Baru Hasil Analisis Rekomendasi Peta Visual Interaktif
     */
   /**
     * Menyimpan Lokasi Hub Baru Hasil Analisis Rekomendasi Peta Visual Interaktif
     */
    public function storeHub(Request $request)
    {
        $request->validate([
            'nama_hub'  => 'required|string|max:255',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        \App\Models\Hub::create([
            'nama_hub'  => $request->nama_hub, 
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
            'status'    => 'aktif'              
        ]);

        return redirect()->back()->with('success', 'Lokasi Hub baru berhasil ditetapkan sebagai titik penerimaan aktif!');
    }



    /**
     * Mengambil detail jumlah pengepul dan pemasok di sekitar koordinat tertentu (Radius ~5 KM)
     */
    public function getDetailAreaHub(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $lat = $request->latitude;
        $lng = $request->longitude;
        
        // Jarak toleransi radius sekitar 5 KM menggunakan pendekatan derajat matematika sederhana
        // (1 derajat sekitar 111 KM, maka 0.045 derajat sekitar 5 KM)
        $radiusDeg = 0.045; 

        // 1. Hitung jumlah pengepul di area tersebut
        $jumlahPengepul = User::where('role', 'pengepul')
            ->whereBetween('latitude', [$lat - $radiusDeg, $lat + $radiusDeg])
            ->whereBetween('longitude', [$lng - $radiusDeg, $lng + $radiusDeg])
            ->count();

        // 2. Hitung jumlah masyarakat/pemasok di area tersebut
        $jumlahPemasok = User::where('role', 'masyarakat')
            ->whereBetween('latitude', [$lat - $radiusDeg, $lat + $radiusDeg])
            ->whereBetween('longitude', [$lng - $radiusDeg, $lng + $radiusDeg])
            ->count();

        return response()->json([
            'success' => true,
            'latitude' => $lat,
            'longitude' => $lng,
            'jumlah_pengepul' => $jumlahPengepul,
            'jumlah_pemasok' => $jumlahPemasok
        ]);
    }



    /**
     * Memperbarui Informasi Nama Hub Zonasi Operasional (Aksi PUT)
     */
    public function updateHub(Request $request, $id)
    {
        $request->validate([
            'nama_hub' => 'required|string|max:255',
        ]);

        $hub = Hub::findOrFail($id);
        $hub->update([
            'nama_hub' => $request->nama_hub
        ]);

        return redirect()->back()->with('success', 'Informasi nama Hub zonasi berhasil diperbarui!');
    }

    /**
     * Menghapus Titik Lokasi Hub dari Log Jaringan Database (Aksi DELETE)
     */
    public function destroyHub($id)
    {
        $hub = Hub::findOrFail($id);
        $hub->delete();

        return redirect()->back()->with('success', 'Titik lokasi Hub berhasil dihapus dari sistem log.');
    }
}