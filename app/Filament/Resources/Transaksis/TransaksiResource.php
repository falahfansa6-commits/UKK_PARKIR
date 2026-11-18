<?php

namespace App\Filament\Resources\Transaksis;

use App\Filament\Resources\Transaksis\Pages;
use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use App\Models\Transaksi;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Filament\Support\Icons\Heroicon;

use BackedEnum;
class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationLabel = 'Transaksi';

    protected static ?string $modelLabel = 'Transaksi';

    protected static ?int $navigationSort = 6;
     protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    // Hanya petugas yang melihat menu Transaksi
    public static function canViewAny(): bool
    {
        return auth()->user()->isPetugas();
    }

    // Petugas boleh menambah transaksi masuk
    public static function canCreate(): bool
    {
        return auth()->user()->isPetugas();
    }

    // Transaksi tidak boleh diubah atau dihapus manual
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
        return $schema->components([
            Select::make('id_kendaraan')
                ->label('Kendaraan (Plat Nomor)')
                ->options(Kendaraan::pluck('plat_nomor', 'id_kendaraan'))
                ->searchable()
                ->required(),

            Select::make('id_area')
                ->label('Area Parkir')
                ->options(
                    AreaParkir::whereColumn('terisi', '<', 'kapasitas')
                        ->pluck('nama_area', 'id_area')
                )
                ->required(),
        ]);
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
                TextColumn::make('waktu_masuk')
                    ->dateTime('d M Y H:i'),
                TextColumn::make('waktu_keluar')
                    ->dateTime('d M Y H:i'),
                TextColumn::make('durasi_jam')
                    ->suffix(' jam'),
                TextColumn::make('biaya_total')
                    ->money('IDR', locale: 'id')
                    ->summarize(
                        Sum::make()
                            ->money('IDR', locale: 'id')
                            ->label('Total')
                    ),
                TextColumn::make('status')->badge(),
            ])
            ->recordActions([
                // Proses kendaraan keluar
                Action::make('keluar')
                    ->label('Kendaraan Keluar')
                    ->icon('heroicon-o-arrow-right-on-rectangle')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn (Transaksi $record) => $record->status === 'masuk')
                    ->action(function (Transaksi $record) {
                        $keluar = now();

                        // Durasi dibulatkan ke atas per jam, minimal 1 jam
                        $durasi = max(1, (int) ceil($record->waktu_masuk->diffInMinutes($keluar) / 60));
                        $biaya = $durasi * $record->tarif->tarif_per_jam;

                        $record->update([
                            'waktu_keluar' => $keluar,
                            'durasi_jam' => $durasi,
                            'biaya_total' => $biaya,
                            'status' => 'keluar',
                        ]);

                        AreaParkir::where('id_area', $record->id_area)->decrement('terisi');

                        LogAktivitas::catat('Kendaraan keluar: ' . $record->kendaraan->plat_nomor);

                        Notification::make()
                            ->title('Total biaya: Rp ' . number_format($biaya, 0, ',', '.'))
                            ->success()
                            ->send();
                    }),

                // Cetak struk untuk transaksi yang sudah keluar
                Action::make('cetak')
                    ->label('Cetak Struk')
                    ->icon('heroicon-o-printer')
                    ->url(fn (Transaksi $record) => route('struk.cetak', $record))
                    ->openUrlInNewTab()
                    ->visible(fn (Transaksi $record) => $record->status === 'keluar'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
        ];
    }
}