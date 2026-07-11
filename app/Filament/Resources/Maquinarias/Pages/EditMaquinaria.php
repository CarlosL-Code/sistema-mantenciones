<?php

namespace App\Filament\Resources\Maquinarias\Pages;

use App\Filament\Resources\Maquinarias\MaquinariaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMaquinaria extends EditRecord
{
    protected static string $resource = MaquinariaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getMaxContentWidth(): \Filament\Support\Enums\Width | string | null
    {
        return \Filament\Support\Enums\Width::SevenExtraLarge;
    }
}
