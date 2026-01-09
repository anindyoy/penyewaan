<?php

namespace App\Filament\Resources\Pinjams\Pages;

use App\Filament\Resources\Pinjams\PinjamResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPinjam extends EditRecord
{
    protected static string $resource = PinjamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
