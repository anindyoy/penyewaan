<?php

namespace App\Models;

use App\Models\Pinjam;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mobil extends Model
{
    /** @use HasFactory<\Database\Factories\MobilFactory> */
    use HasFactory;
    protected $table = 'mobil';
    protected $guarded = [];

    public function pinjam()
    {
        return $this->hasMany(Pinjam::class);
    }
}
