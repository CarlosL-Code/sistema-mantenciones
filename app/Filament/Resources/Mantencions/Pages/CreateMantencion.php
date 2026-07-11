<?php

namespace App\Filament\Resources\Mantencions\Pages;

use App\Filament\Resources\Mantencions\MantencionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMantencion extends CreateRecord
{
    protected static string $resource = MantencionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getMaxContentWidth(): \Filament\Support\Enums\Width | string | null
    {
        return \Filament\Support\Enums\Width::SevenExtraLarge;
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['firma_nombre']) && isset($data['firma_rut'])) {
            $data['firma_tecnico'] = json_encode([
                'nombre' => $data['firma_nombre'],
                'rut' => $data['firma_rut'],
                'fecha' => now()->toDateTimeString(),
            ]);
        }
        unset($data['firma_nombre'], $data['firma_rut'], $data['firma_confirmacion'], $data['tipo_firma'], $data['firma_texto']);
        return $data;
    }

}
