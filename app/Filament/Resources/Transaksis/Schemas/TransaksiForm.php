<?php

namespace App\Filament\Resources\Transaksis\Schemas;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Tarif;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;

use function Laravel\Prompts\select;

class TransaksiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('id_kendaraan')
                ->label('Kendaraan')
                ->options(Kendaraan::pluck('plat_nomor','id_kendaraan'))
                
                    ->required(),
               
                Select::make('id_tarif')
                ->label('Tarif Parkir')
                ->options(Tarif::pluck('jenis_kendaraan', 'id_tarif'))
                    ->required(),

                    Select::make('id_area')
                    ->label('Area Parkir')
                    ->options(AreaParkir::pluck('nama_area', 'id_area'))
                    ->required(),
                TextColumn::make('durasi_jam')
                 ->suffix('jam'),
                    
                TextColumn::make('biaya_total')
                ->label('Total Biaya')
               
                    
                    ->numeric(),

                    TextColumn::make('status')
                    ->default('masuk')
                    ->numeric(),
                     TextColumn::make('waktu_masuk')
                ->date(' D M Y H:i s'),
                TextColumn::make('waktu_keluar')
                ->date('d/m/y H:1 s'),
                // Select::make('status')
                    
                //     ->default('masuk')
                //     ->required(),
                // TextInput::make('id_user')
                //     ->required()
                //     ->numeric(),
                
            ]);
    }
}
