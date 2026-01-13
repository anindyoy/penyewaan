<?php

namespace App\Filament\Resources\Pinjams\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DateTimePicker;

class PinjamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Utama')
                    ->schema([
                        Select::make('peminjam_id')
                            ->relationship('peminjam', 'nama')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('mobil_id')
                            ->label('Mobil')
                            ->relationship(
                                name: 'mobil',
                                titleAttribute: 'model',
                                modifyQueryUsing: function ($query, $get, $record) {
                                    $query->where('status', 'tersedia');
                                    if ($record?->mobil_id) {
                                        $query->orWhere('id', $record->mobil_id);
                                    }
                                }
                            )
                            ->getOptionLabelFromRecordUsing(
                                fn($record) => "{$record->model} {$record->warna} ({$record->nomor_plat})"
                            )
                            ->searchable()->preload()
                            ->helperText('Mobil tersedia')
                            ->searchable()
                            ->required(),

                        Radio::make('tipe_sewa')
                            ->options([
                                'jam' => 'Per Jam',
                                'hari' => 'Per Hari',
                            ])
                            ->required(),
                        Select::make('status_sewa')
                            ->options([
                                'dipinjam' => 'Dipinjam',
                                'kembali' => 'Kembali',
                                'terlambat' => 'Terlambat',
                                'dibatalkan' => 'Dibatalkan',
                            ])
                            ->default('dipinjam')
                            ->required(),

                        TextInput::make('tujuan')->maxLength(150)->columnSpanFull(),
                    ])->columns(2),

                Section::make('Waktu & Durasi')
                    ->schema([
                        DateTimePicker::make('tanggal_mulai')->required()->default(now()),
                        DateTimePicker::make('tanggal_selesai_rencana')->required(),
                        DateTimePicker::make('tanggal_kembali_aktual'),
                    ])->columns(3),

                Section::make('Kondisi Mobil')
                    ->schema([
                        TextInput::make('km_awal')
                            ->label('KM Awal')
                            ->numeric(),
                        TextInput::make('km_akhir')
                            ->label('KM Akhir')
                            ->numeric(),
                        Textarea::make('catatan_kondisi')
                            ->columnSpanFull(),
                    ])->columns(2),
            ])->columns(1);
    }
}
