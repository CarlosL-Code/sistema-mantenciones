<?php

namespace App\Filament\Resources\Mantencions\Pages;

use App\Filament\Resources\Mantencions\MantencionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMantencion extends EditRecord
{
    protected static string $resource = MantencionResource::class;

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

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (!empty($data['firma_tecnico'])) {
            $firma = json_decode($data['firma_tecnico'], true);
            if (json_last_error() === JSON_ERROR_NONE && isset($firma['rut'])) {
                $data['firma_nombre'] = $firma['nombre'] ?? '';
                $data['firma_rut'] = $firma['rut'] ?? '';
                $data['firma_confirmacion'] = true;
            } else {
                // Fallback para firmas antiguas
                $data['firma_nombre'] = 'Firma Antigua';
                $data['firma_rut'] = 'N/A';
                $data['firma_confirmacion'] = true;
            }
        }
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['firma_nombre']) && isset($data['firma_rut'])) {
            $data['firma_tecnico'] = json_encode([
                'nombre' => $data['firma_nombre'],
                'rut' => $data['firma_rut'],
                'fecha' => now()->toDateTimeString(),
            ]);
            // Al firmar, damos por completada la orden automáticamente
            $data['estado'] = 'Completada';
        }
        unset($data['firma_nombre'], $data['firma_rut'], $data['firma_confirmacion'], $data['tipo_firma'], $data['firma_texto']);
        return $data;
    }

    protected function afterSave(): void
    {
        $mantencion = $this->record;
        
        $totalRepuestos = $mantencion->mantencionRepuestos()->sum('precio_total');
        $totalManoObra = floatval($mantencion->costo_mano_obra);
        $totalExterno = floatval($mantencion->costo_externo);
        $totalOtros = floatval($mantencion->costo_otros);
        
        $costoTotal = $totalRepuestos + $totalManoObra + $totalExterno + $totalOtros;
        
        // Actualizar el costo total silenciosamente
        $mantencion->updateQuietly(['costo' => $costoTotal]);
    }

}
