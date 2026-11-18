<?php

namespace App\Filament\Resources\RekapTransaksis;

use App\Models\Transaksi;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RekapTransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationLabel = 'Rekap Transaksi';

    protected static ?string $modelLabel = 'Rekap Transaksi';

    protected static ?string $pluralModelLabel = 'Rekap Transaksi';

    protected static ?int $navigationSort = 7;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentCurrencyDollar;

    // Hanya owner yang melihat menu rekap
    public static function canViewAny(): bool
    {
        return auth()->user()->isOwner();
    }

    // Rekap hanya dibaca
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('waktu_masuk', 'desc')
            ->columns([
                TextColumn::make('kendaraan.plat_nomor')
                    ->label('Plat')
                    ->searchable(),
                TextColumn::make('area.nama_area')
                    ->label('Area'),
                TextColumn::make('user.nama_lengkap')
                    ->label('Petugas'),
                TextColumn::make('waktu_masuk')
                    ->label('Waktu Masuk')
                    ->dateTime('d M Y H:i'),
                TextColumn::make('waktu_keluar')
                    ->label('Waktu Keluar')
                    ->dateTime('d M Y H:i'),
                TextColumn::make('durasi_jam')
                    ->suffix(' jam'),
                TextColumn::make('biaya_total')
                    ->money('IDR', locale: 'id')
                    ->summarize(
                        Sum::make()
                            ->money('IDR', locale: 'id')
                            ->label('Total Pendapatan')
                    ),
                TextColumn::make('status')->badge(),
            ])
            ->filters([
                // Filter periode berdasarkan waktu transaksi masuk
                Filter::make('periode')
                    ->label('Waktu Transaksi')
                    ->schema([
                        DateTimePicker::make('dari')
                            ->label('Dari Waktu')
                            ->displayFormat('d/m/Y H:i')
                            ->seconds(false),
                        DateTimePicker::make('sampai')
                            ->label('Sampai Waktu')
                            ->displayFormat('d/m/Y H:i')
                            ->seconds(false),
                    ])
                    ->query(fn (Builder $query, array $data) => $query
                        ->when(
                            $data['dari'] ?? null,
                            fn (Builder $q, $waktu) => $q->where('waktu_masuk', '>=', $waktu)
                        )
                        ->when(
                            $data['sampai'] ?? null,
                            fn (Builder $q, $waktu) => $q->where('waktu_masuk', '<=', $waktu)
                        )
                    ),
            ])
            ->filtersTriggerAction(
                fn (Action $action): Action => $action
                    ->button()
                    ->label('Waktu Transaksi')
            );
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRekapTransaksis::route('/'),
        ];
    }
}
