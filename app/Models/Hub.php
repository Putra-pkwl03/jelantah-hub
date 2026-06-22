<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hub extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi oleh form laravel
    protected $fillable = [
        'nama_hub',
        'latitude',
        'longitude',
        'status'
    ];
}