<?php

namespace App\Filament\Resources\Pinjams;

use BackedEnum;
use App\Models\Pinjam;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\Pinjams\Pages\EditPinjam;
use App\Filament\Resources\Pinjams\Pages\ListPinjams;
use App\Filament\Resources\Pinjams\Pages\CreatePinjam;
use App\Filament\Resources\Pinjams\Schemas\PinjamForm;
use App\Filament\Resources\Pinjams\Tables\PinjamsTable;

class PinjamResource extends Resource
{
    protected static ?string $model = Pinjam::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return PinjamForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PinjamsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPinjams::route('/'),
            // 'create' => CreatePinjam::route('/create'),
            // 'edit' => EditPinjam::route('/{record}/edit'),
        ];
    }
}
