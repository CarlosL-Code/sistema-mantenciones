<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class GastosMensualesChart extends ChartWidget
{
    protected ?string $heading = 'Resumen de Gastos Mensuales';
    protected static ?int $sort = 2;
    protected ?string $maxHeight = '250px'; 
    protected int | string | array $columnSpan = ['sm' => 1, 'md' => 1, 'lg' => 1, 'xl' => 1];

    protected function getData(): array
    {
        $mantenciones = \App\Models\Mantencion::where('created_at', '>=', now()->subMonths(6))->get();
            
        $labels = [];
        $values = [];
        foreach(range(5, 0) as $i) {
            $month = now()->subMonths($i)->format('Y-m');
            $labels[] = ucfirst(now()->subMonths($i)->translatedFormat('M Y'));
            
            $aggregate = $mantenciones->filter(function($m) use ($month) {
                return $m->created_at->format('Y-m') === $month;
            })->sum('costo');
            
            $values[] = $aggregate;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Gastos en Mantención ($)',
                    'data' => $values,
                    'backgroundColor' => 'rgba(14, 165, 233, 0.25)', // Sky blue transparent
                    'borderColor' => '#0ea5e9', // Sky blue 500
                    'fill' => 'start',
                    'tension' => 0.5,
                    'pointBackgroundColor' => '#fff',
                    'pointBorderColor' => '#0ea5e9',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
