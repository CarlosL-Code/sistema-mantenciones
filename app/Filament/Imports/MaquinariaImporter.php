<?php

namespace App\Filament\Imports;

use App\Models\Maquinaria;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class MaquinariaImporter extends Importer
{
    protected static ?string $model = Maquinaria::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('codigo_interno')
                ->label('Código Interno')
                ->example('TR-001')
                ->rules(['max:255']),
            ImportColumn::make('nombre')
                ->label('Nombre del Equipo (Obligatorio)')
                ->example('Tractor John Deere')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('marca')
                ->label('Marca')
                ->example('John Deere')
                ->rules(['max:255']),
            ImportColumn::make('modelo')
                ->label('Modelo')
                ->example('5090E')
                ->rules(['max:255']),
            ImportColumn::make('numero_serie')
                ->label('Número de Serie')
                ->example('SN-123456789')
                ->rules(['max:255']),
            ImportColumn::make('fecha_adquisicion')
                ->label('Fecha de Adquisición (YYYY-MM-DD)')
                ->example('2024-01-15')
                ->rules(['date']),
            ImportColumn::make('estado')
                ->label('Estado (Obligatorio)')
                ->example('Operativo')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('area')
                ->label('Área (General)')
                ->example('Producción')
                ->rules(['max:255']),
            ImportColumn::make('observaciones')
                ->label('Observaciones')
                ->example('Equipo nuevo con garantía de 1 año'),
            ImportColumn::make('categoria')
                ->label('Categoría')
                ->example('Maquinaria Pesada')
                ->rules(['max:255']),
            ImportColumn::make('area_sector')
                ->label('Sector Específico')
                ->example('Campo Norte')
                ->rules(['max:255']),
            ImportColumn::make('fotografia')
                ->label('Fotografía (Dejar en blanco)')
                ->example('')
                ->rules(['max:255']),
            ImportColumn::make('responsable')
                ->label('Responsable')
                ->example('Juan Pérez')
                ->rules(['max:255']),
            ImportColumn::make('cantidad')
                ->label('Cantidad (Obligatorio)')
                ->example('1')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('periodicidad_mantencion')
                ->label('Periodicidad de Mantención')
                ->example('Mensual')
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): Maquinaria
    {
        return new Maquinaria();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'La importación de activos ha finalizado. Se importaron ' . Number::format($import->successful_rows) . ' ' . str('fila')->plural($import->successful_rows) . ' correctamente.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('fila')->plural($failedRowsCount) . ' fallaron al importar.';
        }

        return $body;
    }
}
