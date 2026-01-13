<?php

namespace App\Filament\Resources\Mobils\Schemas;

use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;

class MobilForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('merek')
                    ->required()
                    ->placeholder('Contoh: Toyota'),
                TextInput::make('model')
                    ->required()
                    ->placeholder('Contoh: Avanza'),
                TextInput::make('nomor_plat')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->dehydrateStateUsing(fn($state) => Str::upper($state)) // Otomatis Uppercase
                    ->placeholder('Contoh: F 1234 ABC'),
                TextInput::make('warna')
                    ->required(),
                TextInput::make('tahun_produksi')
                    ->numeric()
                    ->length(4)
                    ->required(),
                Select::make('status')
                    ->options([
                        'tersedia' => 'Tersedia',
                        'dipinjam' => 'Dipinjam',
                        'perbaikan' => 'Dalam Perbaikan',
                        'dipinjam' => 'Dipinjam',
                    ])
                    ->default('tersedia')
                    ->required(),

            ]);
    }
}
