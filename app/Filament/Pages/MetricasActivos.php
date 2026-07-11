<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\NuevosActivosChart;
use App\Filament\Widgets\UltimosActivosTable;

class MetricasActivos extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';
    protected static ?string $navigationGroup = 'Inventario';
    
    protected static ?string $navigationLabel = 'Métricas de Inventario';
    
    protected static ?string $title = 'Métricas de Inventario';

    protected static ?int $navigationSort = 3;

    public function getHeaderWidgetsColumns(): int | array
    {
        return 2;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            NuevosActivosChart::class,
            UltimosActivosTable::class,
        ];
    }
}
