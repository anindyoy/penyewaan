<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Mobil;
use App\Models\Peminjam;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pinjam extends Model
{
    /** @use HasFactory<\Database\Factories\PinjamFactory> */
    use HasFactory;
    protected $table = 'pinjam';
    protected $guarded = [];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai_rencana' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function ($record) {
            self::syncStatusMobil($record);
        });

        static::updated(function ($record) {
            self::syncStatusMobil($record);
        });
    }

    private static function syncStatusMobil($record): void
    {
        // hanya jika tanggal_mulai adalah hari ini
        if (! Carbon::parse($record->tanggal_mulai)->isToday()) {
            return;
        }

        $mobil = $record->mobil;
        if (! $mobil) {
            return;
        }

        $statusMobil = match ($record->status_sewa) {
            'dipesan'   => 'dipesan',
            'berjalan'  => 'dipinjam',
            'kembali',
            'dibatalkan' => 'tersedia',
            default     => $mobil->status,
        };

        // hindari update berulang
        if ($mobil->status !== $statusMobil) {
            $mobil->update([
                'status' => $statusMobil,
            ]);
        }
    }

    public function mobil()
    {
        return $this->belongsTo(Mobil::class);
    }

    public function peminjam()
    {
        return $this->belongsTo(Peminjam::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
