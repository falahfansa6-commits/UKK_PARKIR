<?php

namespace App\Filament\Resources\AreaParkirs;

use App\Filament\Resources\AreaParkirs\Pages;
use App\Models\AreaParkir;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;
use BackedEnum;

class AreaParkirResource extends Resource
{
    protected static ?string $model = AreaParkir::class;

    protected static ?string $navigationLabel = 'Area Parkir';

    protected static ?string $modelLabel = 'Area Parkir';
     protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHomeModern;

    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        return auth()->user()->isAdmin();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nama_area')
                ->required()
                ->maxLength(50),

            TextInput::make('kapasitas')
                ->numeric()
                ->minValue(1)
                ->required(),

            // Terisi diatur otomatis oleh sistem, tidak diisi manual
            TextInput::make('terisi')
                ->numeric()
                ->default(0)
                ->disabled()
                ->dehydrated(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_area')->searchable(),
                TextColumn::make('kapasitas'),
                TextColumn::make('terisi'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAreaParkirs::route('/'),
            'create' => Pages\CreateAreaParkir::route('/create'),
            'edit' => Pages\EditAreaParkir::route('/{record}/edit'),
        ];
    }
}