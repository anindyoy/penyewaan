<?php

namespace App\Filament\Resources\Peminjams\Pages;

use App\Filament\Resources\Peminjams\PeminjamResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPeminjams extends ListRecords
{
    protected static string $resource = PeminjamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
