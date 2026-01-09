<?php

namespace App\Filament\Resources\Mobils\Pages;

use App\Filament\Resources\Mobils\MobilResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMobil extends EditRecord
{
    protected static string $resource = MobilResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
