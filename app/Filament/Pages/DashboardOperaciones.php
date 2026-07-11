<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard;
use Illuminate\Contracts\Support\Htmlable;

class DashboardOperaciones extends Dashboard
{
    protected static string $routePath = 'dashboard-operaciones';
    protected static ?string $slug = 'dashboard-operaciones';

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-presentation-chart-line';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Operaciones';
    }

    public static function getNavigationLabel(): string
    {
        return 'Panel de Operaciones';
    }

    public function getTitle(): string | Htmlable
    {
        return 'Panel de Operaciones';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public function getHeading(): string | Htmlable
    {
        return 'Centro de Operaciones';
    }

    public function getSubheading(): string | Htmlable | null
    {
        return 'Vista global del rendimiento del equipo técnico y costos operativos.';
    }

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\OperacionesOverviewWidget::class,
            \App\Filament\Widgets\TiemposResolucionChart::class,
        ];
    }
}
