<?php

namespace App\Filament\Resources\Pinjams\Pages;

use Carbon\Carbon;
use App\Models\Mobil;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Pinjams\PinjamResource;

class ListPinjams extends ListRecords
{
    protected static string $resource = PinjamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->after(function ($record) {
                    // Logika: Jika tanggal mulai adalah hari ini DAN statusnya dipinjam
                    $hariIni = Carbon::now()->isSameDay($record->tanggal_mulai);

                    if ($hariIni && $record->status_sewa === 'dipinjam') {
                        $status =
                        // Update status mobil menjadi dipinjam
                        Mobil::where('id', $record->mobil_id)->update([
                            'status' => 'dipinjam'
                        ]);
                    }
                }),
        ];
    }
}
