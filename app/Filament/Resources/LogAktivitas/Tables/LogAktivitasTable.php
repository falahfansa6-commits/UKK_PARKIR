<?php

namespace App\Filament\Resources\LogAktivitas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LogAktivitasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.nama_lengkap')
                    ->label('Pengguna')
                    ->searchable(),
                TextColumn::make('aktivitas')
                ->searchable(),
                TextColumn::make('waktu_aktivitas')
                ->dateTime('d M Y H:i  ')
                ->sortable(),
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
