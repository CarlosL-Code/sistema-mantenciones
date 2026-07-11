<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Mantencion;

class CalendarioMantenciones extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Operaciones';
    protected static ?int $navigationSort = 2;
    protected static ?string $title = 'Calendario de Mantenciones';
    
    protected string $view = 'filament.pages.calendario-mantenciones';

    protected function getViewData(): array
    {
        $mantenciones = Mantencion::with('maquinaria')->get()->map(function ($mantencion) {
            $color = match ($mantencion->estado) {
                'Pendiente' => '#ef4444',
                'En Proceso' => '#eab308',
                'Completada' => '#22c55e',
                default => '#6b7280',
            };

            return [
                'title' => $mantencion->maquinaria->nombre . ' (' . $mantencion->tipo . ')',
                'start' => $mantencion->fecha_proxima,
                'color' => $color,
                'url' => url('/admin/mantencions/' . $mantencion->id . '/edit'),
            ];
        });

        return [
            'events' => $mantenciones,
        ];
    }
}
