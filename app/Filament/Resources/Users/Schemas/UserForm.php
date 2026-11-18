<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_lengkap')
                ->label('Nama lengkap')
                ->maxLength(50)
                    ->required(),
                TextInput::make('username')
                ->label('Username')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignoreRecord:true),
                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->required(fn (string $operation) => $operation === 'create')
                ->dehydrated(fn ($state) => filled($state))
                ->maxLength(100),
                
                Select::make('role')
                    ->options(['admin' => 'Admin', 'petugas' => 'Petugas', 'owner' => 'Owner'])
                    ->required(),
                Toggle::make('status_aktif')
                    ->required()
                    ->label('Aktif')
                    ->default(true),
            ]);
    }
}
