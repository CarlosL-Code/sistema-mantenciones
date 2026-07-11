<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class ActivosPorEstadoChart extends ChartWidget
{
    protected ?string $heading = 'Activos Por Estado Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
