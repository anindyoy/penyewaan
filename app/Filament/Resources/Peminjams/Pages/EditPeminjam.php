<?php

namespace App\Filament\Resources\Peminjams\Pages;

use App\Filament\Resources\Peminjams\PeminjamResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPeminjam extends EditRecord
{
    protected static string $resource = PeminjamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
