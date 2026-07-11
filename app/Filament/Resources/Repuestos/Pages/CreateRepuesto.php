<?php

namespace App\Filament\Resources\Repuestos\Pages;

use App\Filament\Resources\Repuestos\RepuestoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRepuesto extends CreateRecord
{
    protected static string $resource = RepuestoResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
