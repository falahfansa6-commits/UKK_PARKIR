<?php

namespace App\Filament\Resources\Tarifs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TarifInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('jenis_kendaraan')
                    ->badge(),
                TextEntry::make('tarif_per_jam')
                    ->numeric(),
            ]);
    }
}
