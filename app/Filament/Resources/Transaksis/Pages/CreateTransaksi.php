<?php

namespace App\Filament\Resources\Transaksis\Pages;

use App\Filament\Resources\Transaksis\TransaksiResource;
use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use App\Models\Tarif;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateTransaksi extends CreateRecord
{
    protected static string $resource = TransaksiResource::class;

    // Dijalankan sebelum data disimpan
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // 1. Cek kapasitas area
        $area = AreaParkir::find($data['id_area']);

        if ($area->terisi >= $area->kapasitas) {
            throw ValidationException::withMessages([
                'id_area' => 'Area parkir ini sudah penuh.',
            ]);
        }

        // 2. Ambil tarif sesuai jenis kendaraan
        $kendaraan = Kendaraan::find($data['id_kendaraan']);
        $tarif = Tarif::where('jenis_kendaraan', $kendaraan->jenis_kendaraan)->firstOrFail();

        // 3. Isi data otomatis
        $data['id_tarif'] = $tarif->id_tarif;
        $data['id_user'] = auth()->id();
        $data['waktu_masuk'] = now();
        $data['status'] = 'masuk';

        return $data;
    }

    // Dijalankan setelah data berhasil disimpan
    protected function afterCreate(): void
    {
        AreaParkir::where('id_area', $this->record->id_area)->increment('terisi');

        LogAktivitas::catat('Kendaraan masuk: ' . $this->record->kendaraan->plat_nomor);
    }
}