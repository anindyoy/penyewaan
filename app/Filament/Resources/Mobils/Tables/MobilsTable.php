<?php

namespace App\Filament\Resources\Mobils\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;

class MobilsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor_plat')->searchable()->sortable(),
                TextColumn::make('merek')->searchable(),
                TextColumn::make('model'),
                BadgeColumn::make('status')
                    ->colors([
                        'success' => 'tersedia',
                        'warning' => 'dipinjam',
                        'danger' => 'perbaikan',
                        'primary' => 'dipinjam',
                    ])
                    ->formatStateUsing(fn($state) => ucfirst($state)),
                TextColumn::make('tahun_produksi'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'tersedia' => 'Tersedia',
                        'dipinjam' => 'Dipinjam',
                    ]),
            ])
            ->actions([
                EditAction::make(), // Akan terbuka di Modal
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
