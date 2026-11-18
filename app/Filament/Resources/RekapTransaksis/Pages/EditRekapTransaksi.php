<?php

namespace App\Filament\Resources\RekapTransaksis\Pages;

use App\Filament\Resources\RekapTransaksis\RekapTransaksiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRekapTransaksi extends EditRecord
{
    protected static string $resource = RekapTransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
