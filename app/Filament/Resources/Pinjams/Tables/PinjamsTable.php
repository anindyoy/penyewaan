<?php

namespace App\Filament\Resources\Pinjams\Tables;

use Carbon\Carbon;
use App\Models\Pinjam;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class PinjamsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('peminjam.nama')
                    ->label('Nama Peminjam')
                    ->description(
                        fn(Pinjam $record): string => $record->peminjam?->organisasi . ' - ' . $record->peminjam?->jabatan
                    )
                    ->searchable(),

                TextColumn::make('mobil.model')
                    ->label('Mobil')
                    ->description(fn(Pinjam $record): string => $record->mobil->nomor_plat),

                BadgeColumn::make('status_sewa')
                    ->colors([
                        'warning' => 'dipinjam',
                        'success' => 'kembali',
                        'danger' => 'terlambat',
                        'secondary' => 'dibatalkan',
                    ])
                    ->formatStateUsing(fn($state) => ucfirst($state)),
                TextColumn::make('tanggal_mulai')
                    ->formatStateUsing(function ($state) {
                        if (blank($state)) {
                            return null;
                        }

                        $date = Carbon::parse($state);

                        return $date->year === now()->year
                            ? $date->format('d M, H:i')
                            : $date->format('d M Y, H:i');
                    })
                    ->description(function (Pinjam $record): ?string {
                        if (blank($record->tanggal_selesai_rencana)) {
                            return null;
                        }

                        $date = $record->tanggal_selesai_rencana;

                        return 'Rencana Kembali: ' .
                            ($date->year === now()->year
                                ? $date->format('d M, H:i')
                                : $date->format('d M Y, H:i'));
                    })
                    ->sortable(),

                TextColumn::make('tujuan')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('user.name'),
            ])
            ->defaultSort('tanggal_mulai', 'desc')
            ->filters([
                // STATUS SEWA
                SelectFilter::make('status_sewa')
                    ->label('Status Sewa')
                    ->options([
                        'dipinjam' => 'Dipinjam',
                        'kembali' => 'Kembali',
                        'terlambat' => 'Terlambat',
                        'dibatalkan' => 'Dibatalkan',
                    ]),

                // MOBIL
                SelectFilter::make('mobil_id')
                    ->label('Mobil')
                    ->relationship(
                        'mobil',
                        'model',
                        fn(Builder $query) => $query->orderBy('model')
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn($record) => "{$record->model} ({$record->nomor_plat})"
                    )
                    ->searchable()->preload(),

                // PEMINJAM
                SelectFilter::make('peminjam_id')
                    ->label('Peminjam')
                    ->relationship(
                        'peminjam',
                        'nama',
                        fn(Builder $query) => $query->orderBy('nama')
                    )
                    ->searchable()->preload(),

                // TANGGAL MULAI (RANGE)
                DateRangeFilter::make('tanggal_mulai'),

                // USER (PETUGAS)
                SelectFilter::make('user_id')
                    ->label('Petugas')
                    ->relationship('user', 'name')
                    ->searchable()->preload(),
            ])
            ->filtersFormColumns(2)
            ->actions([
                EditAction::make()->after(function ($record) {
                    // Jika status diubah jadi dipinjam, pastikan mobil jadi dipinjam
                    $hariIni = Carbon::now()->isSameDay($record->tanggal_mulai);

                    if ($hariIni && $record->status_sewa === 'dipinjam') {
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
