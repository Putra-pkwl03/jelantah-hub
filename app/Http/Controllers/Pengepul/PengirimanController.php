<?php

namespace App\Http\Controllers\Pengepul;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setoran;
use Illuminate\Support\Facades\Auth;

class PengirimanController extends Controller
{
    // Halaman Riwayat Pengiriman / Log Pengiriman
    public function index()
    {
        // Menampilkan data setoran yang statusnya diubah menjadi 'dijemput' (sedang dikirim ke HEN)
        $riwayatPengiriman = Setoran::where('pengepul_id', Auth::id())
                                    ->where('status', 'dijemput')
                                    ->latest()
                                    ->get();

        return view('pengepul.pengiriman.index', compact('riwayatPengiriman'));
    }

    // Halaman Form Kirim Minyak Baru ke PT HEN
    public function create()
    {
        $user = Auth::user();

        // Hitung akumulasi LITER BERSIH dari masyarakat yang statusnya 'selesai' di gudang pengepul
        $totalStokTersedia = Setoran::where('pengepul_id', $user->id)
                                    ->where('status', 'selesai')
                                    ->sum('liter_bersih');

        $hargaPengepul = $user->harga_per_liter ?? 0;

        return view('pengepul.pengiriman.create', compact('totalStokTersedia', 'hargaPengepul'));
    }

public function store(Request $request)
{
    $user = Auth::user();
    
    $totalStokTersedia = Setoran::where('pengepul_id', $user->id)
                                ->where('status', 'selesai')
                                ->sum('liter_bersih');

    $request->validate([
        'volume'       => 'required|numeric|min:1|max:' . $totalStokTersedia,
        'no_kendaraan' => 'required|string|max:50',
    ]);

    $setorans = Setoran::where('pengepul_id', $user->id)
                        ->where('status', 'selesai')
                        ->orderBy('created_at', 'asc')
                        ->get();

    $volumeDibutuhkan = $request->volume;

    foreach ($setorans as $setoran) {
        if ($volumeDibutuhkan <= 0) break;

        $volumeDibutuhkan -= $setoran->liter_bersih;

        $setoran->update([
            'status' => 'proses' 
        ]);
    }

    return redirect()
        ->route('pengepul.pengiriman.create')
        ->with('success', 'Muatan sebanyak ' . $request->volume . ' Liter berhasil didistribusikan ke PT HEN untuk antrean uji laboratorium.');
}
}