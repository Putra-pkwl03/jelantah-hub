<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 

class PengepulController extends Controller
{
    public function index(Request $request)
    {
        $userLat = $request->get('lat', -7.5661); 
        $userLng = $request->get('lng', 110.8243);

        $pengepulList = User::where('role', 'pengepul')->get();

        $hasilPencarian = $pengepulList->map(function ($pengepul) use ($userLat, $userLng) {
            $earthRadius = 6371; 

            $dLat = deg2rad($pengepul->latitude - $userLat);
            $dLng = deg2rad($pengepul->longitude - $userLng);

            $a = sin($dLat / 2) * sin($dLat / 2) +
                 cos(deg2rad($userLat)) * cos(deg2rad($pengepul->latitude)) *
                 sin($dLng / 2) * sin($dLng / 2);
            
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $jarak = $earthRadius * $c; 

            $pengepul->jarak = round($jarak, 2); 
            return $pengepul;
        })
        ->sort(function ($a, $b) {
            if ($a->jarak == $b->jarak) {
                return $b->harga_per_liter <=> $a->harga_per_liter;
            }
            return $a->jarak <=> $b->jarak;
        });

        return view('masyarakat.pengepul.index', compact('hasilPencarian', 'userLat', 'userLng'));
    }
}