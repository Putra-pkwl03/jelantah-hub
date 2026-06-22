<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'masyarakat_id',
    'pengepul_id',
    'liter_estimasi',
    'tanggal_penjemputan',
    'jam_penjemputan',
    'status',
    'liter_bersih',
    'endapan',
    'harga_dibayar',
    
    // 🌟 Kolom Hasil Uji Lab & Otorisasi PT HEN
    'kadar_air',
    'ffa',
    'kotoran',
    'grade',
    'liter_final',
])]
class Setoran extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'tanggal_penjemputan' => 'date',
            'jam_penjemputan'     => 'datetime:H:i', 
            'liter_estimasi'      => 'float',
            'liter_bersih'        => 'float',
            'endapan'             => 'float',
            'harga_dibayar'       => 'integer',
            
            // 🌟 Casting metrik lab ke float agar mendukung angka desimal/persentase
            'kadar_air'           => 'float',
            'ffa'                 => 'float',
            'kotoran'             => 'float',
            'liter_final'         => 'float',
        ];
    }

    public function masyarakat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'masyarakat_id');
    }

    public function pengepul(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengepul_id');
    }
}