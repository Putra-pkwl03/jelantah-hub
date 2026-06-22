<?php

namespace App\Http\Controllers\Pengepul;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HargaController extends Controller
{
    public function index()
    {
        return view('pengepul.harga.index', [
            'pengepul' => auth()->user()
        ]);
    }

    public function store(Request $request)
    {
        $hargaAcuanStakeholder = \App\Models\User::where('role', 'stakeholder')->first()->harga_per_liter ?? 15000;

        $request->validate([
            'harga_beli' => 'required|numeric|min:1000|max:' . $hargaAcuanStakeholder,
        ]);

        auth()->user()->update([
            'harga_per_liter' => $request->harga_beli
        ]);

        return back()->with('success', 'Harga beli berhasil diperbarui sesuai batas aman!');
    }
}