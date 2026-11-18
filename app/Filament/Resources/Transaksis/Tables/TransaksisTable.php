<?php

namespace App\Filament\Resources\Transaksis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TransaksisTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->defaultSort('waktu_masuk', 'desc')
            ->columns([
                TextColumn::make('id_kendaraan')
                    ->label('Plat')
                    ->sortable(),
                    TextColumn::make('id_area')
                    ->label('Area Parkir')
                    ->sortable(),
                    TextColumn::make('id_tarif')
                    ->label('tarif_parkir')
                    ->sortable(),
                    TextColumn::make('id_user')
                    ->label('Petugas')
                    ->sortable(),
                TextColumn::make('waktu_masuk')
                    ->dateTime('D M Y H:i')
                    ->sortable(),
                TextColumn::make('waktu_keluar')
                    ->dateTime('D M Y H:1')
                    ->sortable(),
                
                TextColumn::make('durasi_jam')
                    ->searchable(),
                TextColumn::make('biaya_total')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
                
                
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
