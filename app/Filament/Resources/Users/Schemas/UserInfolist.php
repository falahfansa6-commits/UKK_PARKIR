<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nama_lengkap'),
                TextEntry::make('username'),
                TextEntry::make('role')
                    ->badge(),
                IconEntry::make('status_aktif')
                    ->boolean(),
            ]);
    }
}
