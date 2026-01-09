<?php

namespace App\Filament\Resources\Pinjams\Schemas;

use App\Models\Mobil;
use Filament\Schemas\Schema;
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
                            ->options(Mobil::where('status', 'tersedia')->pluck('model', 'id'))
                            // ->description('Hanya menampilkan mobil yang berstatus tersedia')
                            ->searchable()
                            ->required(),
                        Select::make('tipe_sewa')
                            ->options([
                                'jam' => 'Per Jam',
                                'hari' => 'Per Hari',
                            ])
                            ->required()
                            ->native(false),
                        Select::make('status_sewa')
                            ->options([
                                'dipesan' => 'Dipesan',
                                'berjalan' => 'Berjalan',
                                'kembali' => 'Kembali',
                                'terlambat' => 'Terlambat',
                                'dibatalkan' => 'Dibatalkan',
                            ])
                            ->default('dipesan')
                            ->required(),
                    ])->columns(2),

                Section::make('Waktu & Durasi')
                    ->schema([
                        DateTimePicker::make('tanggal_mulai')
                            ->required(),
                        DateTimePicker::make('tanggal_selesai_rencana')
                            ->required(),
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
