<?php

namespace App\Filament\Resources\Peminjams;

use BackedEnum;
use App\Models\Peminjam;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\Peminjams\Pages\EditPeminjam;
use App\Filament\Resources\Peminjams\Pages\ListPeminjams;
use App\Filament\Resources\Peminjams\Pages\CreatePeminjam;
use App\Filament\Resources\Peminjams\Schemas\PeminjamForm;
use App\Filament\Resources\Peminjams\Tables\PeminjamsTable;

class PeminjamResource extends Resource
{
    protected static ?string $model = Peminjam::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return PeminjamForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PeminjamsTable::configure($table);
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
            'index' => ListPeminjams::route('/'),
            'create' => CreatePeminjam::route('/create'),
            'edit' => EditPeminjam::route('/{record}/edit'),
        ];
    }
}
