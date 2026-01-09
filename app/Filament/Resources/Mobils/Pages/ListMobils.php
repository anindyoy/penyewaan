<?php

namespace App\Filament\Resources\Mobils\Pages;

use Illuminate\Support\Str;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Mobils\MobilResource;

class ListMobils extends ListRecords
{
    protected static string $resource = MobilResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
