<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Mantencion;
use Carbon\Carbon;

class TiemposResolucionChart extends ChartWidget
{
    protected ?string $heading = 'Mantenimientos vs Costos Externos por Mes';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $mantenciones = Mantencion::where('created_at', '>=', now()->subMonths(6))->get();
            
        $labels = [];
        $totalMantenciones = [];
        $costosExternos = [];
        
        foreach(range(5, 0) as $i) {
            $month = now()->subMonths($i)->format('Y-m');
            $labels[] = ucfirst(now()->subMonths($i)->translatedFormat('M Y'));
            
            $mantencionesMes = $mantenciones->filter(function($m) use ($month) {
                return $m->created_at->format('Y-m') === $month;
            });
            
            $totalMantenciones[] = $mantencionesMes->count();
            $costosExternos[] = $mantencionesMes->sum('costo_externo');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Órdenes de Mantenimiento',
                    'data' => $totalMantenciones,
                    'type' => 'bar',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.8)', // indigo-500
                    'yAxisID' => 'y',
                    'borderRadius' => 4,
                ],
                [
                    'label' => 'Costos de Proveedores Externos ($)',
                    'data' => $costosExternos,
                    'type' => 'line',
                    'borderColor' => '#ef4444', // red-500
                    'backgroundColor' => 'rgba(239, 68, 68, 0.2)',
                    'yAxisID' => 'y1',
                    'tension' => 0.4,
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'left',
                    'title' => [
                        'display' => true,
                        'text' => 'Cantidad de Órdenes'
                    ]
                ],
                'y1' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'right',
                    'grid' => [
                        'drawOnChartArea' => false, // only want the grid lines for one axis to show up
                    ],
                    'title' => [
                        'display' => true,
                        'text' => 'Costo en $'
                    ]
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Mixed chart
    }
}
