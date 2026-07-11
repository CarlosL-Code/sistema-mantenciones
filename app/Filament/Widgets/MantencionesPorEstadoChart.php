<?php

namespace App\Filament\Widgets;

use App\Models\Mantencion;
use Filament\Widgets\ChartWidget;

class MantencionesPorEstadoChart extends ChartWidget
{
    protected ?string $heading = 'Estado de Órdenes de Trabajo';
    protected static ?int $sort = 3;
    protected ?string $maxHeight = '250px'; // Matching height
    protected int | string | array $columnSpan = ['sm' => 1, 'md' => 1, 'lg' => 1, 'xl' => 1];

    protected function getData(): array
    {
        // Obtener el conteo por estado
        $stats = Mantencion::selectRaw('estado, count(*) as total')
            ->groupBy('estado')
            ->get();

        $labels = [];
        $data = [];
        $colors = [];

        // Colores profesionales base para cada estado
        $colorMap = [
            'Pendiente' => 'rgba(239, 68, 68, 0.8)',     // red-500
            'En Proceso' => 'rgba(245, 158, 11, 0.8)',    // amber-500
            'Completada' => 'rgba(16, 185, 129, 0.8)',    // emerald-500
            'Cancelada' => 'rgba(100, 116, 139, 0.8)',     // slate-500
        ];

        foreach ($stats as $stat) {
            $estado = $stat->estado ?? 'Sin Estado';
            $labels[] = $estado;
            $data[] = $stat->total;
            $colors[] = $colorMap[$estado] ?? 'rgba(139, 92, 246, 0.8)';
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total de Mantenciones',
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderRadius' => 6, // Esquinas redondeadas premium
                    'borderWidth' => 0,
                    'barThickness' => 30, // Barras estilizadas
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false, // Ocultar leyenda porque los ejes ya explican todo
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                    'grid' => [
                        'display' => true,
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false, // Más limpio
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
