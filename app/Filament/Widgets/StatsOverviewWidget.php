<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Maquinaria;
use App\Models\Mantencion;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Total de Activos Registrados', Maquinaria::count())
                ->description('Equipos y maquinarias activas')
                ->descriptionIcon('heroicon-m-cube', \Filament\Support\Enums\IconPosition::Before)
                ->chart([3, 5, 4, 7, 6, 8, 10])
                ->color('info'),
                
            Stat::make('Mantenimientos Pendientes', Mantencion::where('estado', 'Pendiente')->count())
                ->description('Requieren atención urgente')
                ->descriptionIcon('heroicon-m-exclamation-triangle', \Filament\Support\Enums\IconPosition::Before)
                ->chart([7, 6, 5, 6, 5, 4, 2])
                ->color('danger'),

            Stat::make('Trabajos en Proceso', Mantencion::where('estado', 'En Proceso')->count())
                ->description('Mantenimientos ejecutándose')
                ->descriptionIcon('heroicon-m-wrench-screwdriver', \Filament\Support\Enums\IconPosition::Before)
                ->chart([1, 2, 2, 3, 2, 3, 4])
                ->color('warning'),
                
            Stat::make('Órdenes Completadas', Mantencion::where('estado', 'Completada')->count())
                ->description('Trabajos finalizados este mes')
                ->descriptionIcon('heroicon-m-check-badge', \Filament\Support\Enums\IconPosition::Before)
                ->chart([2, 4, 3, 5, 8, 12, 15])
                ->color('success'),
        ];
    }
}
