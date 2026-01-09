<?php

namespace App\Models;

use App\Models\Pinjam;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjam extends Model
{
    /** @use HasFactory<\Database\Factories\PeminjamFactory> */
    use HasFactory;
    protected $table = 'peminjam';
    protected $guarded = [];

    public function pinjam()
    {
        return $this->hasMany(Pinjam::class);
    }
}
