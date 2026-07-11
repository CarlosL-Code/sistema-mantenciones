<?php

namespace App\Filament\Resources\Maquinarias\Pages;

use App\Filament\Resources\Maquinarias\MaquinariaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMaquinaria extends CreateRecord
{
    protected static string $resource = MaquinariaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getMaxContentWidth(): \Filament\Support\Enums\Width | string | null
    {
        return \Filament\Support\Enums\Width::SevenExtraLarge;
    }
}
