<?php

namespace App\Models;

use App\Models\Mobil;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pinjam extends Model
{
    /** @use HasFactory<\Database\Factories\PinjamFactory> */
    use HasFactory;
    protected $table = 'pinjam';
    protected $guarded = [];

    public function mobil()
    {
        return $this->belongsTo(Mobil::class);
    }

    public function peminjam()
    {
        return $this->belongsTo(Peminjam::class);
    }
}
