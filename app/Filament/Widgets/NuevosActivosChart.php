<?php

namespace App\Filament\Widgets;

use App\Models\Maquinaria;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class NuevosActivosChart extends ChartWidget
{
    protected static bool $isDiscovered = false;
    protected static ?string $heading = 'Ingresos de Activos en el Año';
    protected static ?int $sort = 2;
    protected ?string $maxHeight = '250px';
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $data = Trend::model(Maquinaria::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Activos Ingresados',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#3b82f6',
                    'borderColor' => '#1d4ed8',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => \Carbon\Carbon::parse($value->date)->translatedFormat('M')),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
