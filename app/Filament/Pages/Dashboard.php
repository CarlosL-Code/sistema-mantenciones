<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class Dashboard extends BaseDashboard
{
    public function getHeading(): string | Htmlable
    {
        return '';
    }

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\PremiumWelcomeWidget::class,
            \App\Filament\Widgets\StatsOverviewWidget::class,
            \App\Filament\Widgets\GastosMensualesChart::class,
            \App\Filament\Widgets\MantencionesPorEstadoChart::class,
            \App\Filament\Widgets\MantencionesVencidasWidget::class,
            \App\Filament\Widgets\LatestMantenciones::class,
            \App\Filament\Widgets\UltimosActivosTable::class,
        ];
    }
}
