<?php

namespace App\Filament\Resources\Kendaraans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class KendaraanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('plat_nomor'),
                TextEntry::make('jenis_kendaraan')
                    ->badge(),
                TextEntry::make('warna')
                    ->placeholder('-'),
                TextEntry::make('pemilik')
                    ->placeholder('-'),
                TextEntry::make('is_user')
                    ->numeric()
                    ->placeholder('-'),
            ]);
    }
}
