<?php

namespace App\Filament\Resources\Kendaraans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KendaraanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('plat_nomor')
                    ->required()
                    ->unique(ignoreRecord:true),
                Select::make('jenis_kendaraan')
                    ->options(['motor' => 'Motor', 'mobil' => 'Mobil', 'lainnya' => 'Lainnya'])
                    ->required(),
                TextInput::make('warna')
                ->maxLength(50),
                TextInput::make('pemilik')
                ->maxLength(50),
                // TextInput::make('is_user')
                //     ->numeric(),
            ]);
    }
}
