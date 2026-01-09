<?php

namespace App\Filament\Resources\Pinjams\Tables;

use Carbon\Carbon;
use App\Models\Pinjam;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;


class PinjamsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('peminjam.nama')
                    ->label('Nama Peminjam')
                    ->searchable(),
                TextColumn::make('mobil.model')
                    ->label('Mobil')
                    ->description(fn(Pinjam $record): string => $record->mobil->nomor_plat),
                BadgeColumn::make('status_sewa')
                    ->colors([
                        'warning' => 'dipesan',
                        'success' => 'berjalan',
                        'primary' => 'kembali',
                        'danger' => 'terlambat',
                        'secondary' => 'dibatalkan',
                    ])
                    ->formatStateUsing(fn($state) => ucfirst($state)),
                TextColumn::make('tanggal_mulai')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                TextColumn::make('tanggal_selesai_rencana')
                    ->dateTime('d M Y H:i'),
            ])
            ->filters([
                SelectFilter::make('status_sewa'),
            ])
            ->actions([
                EditAction::make()->after(function ($record) {
                    // Jika status diubah jadi berjalan, pastikan mobil jadi dipinjam
                    $hariIni = Carbon::now()->isSameDay($record->tanggal_mulai);

                    if ($hariIni && $record->status_sewa === 'berjalan') {
                        $record->mobil()->update(['status' => 'dipinjam']);
                    }

                    // Jika status diubah jadi kembali, kembalikan mobil jadi tersedia
                    elseif ($record->status_sewa === 'kembali') {
                        $record->mobil()->update(['status' => 'tersedia']);
                    }
                }),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
