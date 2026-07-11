<?php

namespace App\Filament\Widgets;

use App\Models\Mantencion;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class OperacionesOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        // Gasto total este mes
        $gastoEsteMes = Mantencion::where('created_at', '>=', $startOfMonth)->sum('costo');
        $gastoMesPasado = Mantencion::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->sum('costo');
        
        $tendenciaGasto = 'increased';
        $colorGasto = 'danger';
        $iconGasto = 'heroicon-m-arrow-trending-up';
        if ($gastoEsteMes <= $gastoMesPasado) {
            $tendenciaGasto = 'decreased';
            $colorGasto = 'success';
            $iconGasto = 'heroicon-m-arrow-trending-down';
        }

        // Mantenciones completadas este mes
        $completadasEsteMes = Mantencion::where('estado', 'Completada')->where('created_at', '>=', $startOfMonth)->count();
        $completadasMesPasado = Mantencion::where('estado', 'Completada')->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        
        // Tiempo promedio de resolución (días entre creación y fecha_reparacion)
        $mantencionesResueltas = Mantencion::where('estado', 'Completada')->whereNotNull('fecha_reparacion')->get();
        $promedioDias = $mantencionesResueltas->count() > 0 
            ? $mantencionesResueltas->avg(function($m) {
                return Carbon::parse($m->created_at)->diffInDays(Carbon::parse($m->fecha_reparacion));
            }) 
            : 0;

        return [
            Stat::make('Gasto Operativo (Mes Actual)', '$' . number_format($gastoEsteMes, 0, ',', '.'))
                ->description('Mes pasado: $' . number_format($gastoMesPasado, 0, ',', '.'))
                ->descriptionIcon($iconGasto)
                ->color($colorGasto),
            Stat::make('Órdenes Completadas', $completadasEsteMes)
                ->description('Trabajos terminados este mes')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
            Stat::make('Tiempo Medio de Resolución', round($promedioDias, 1) . ' días')
                ->description('Promedio desde la creación al cierre')
                ->descriptionIcon('heroicon-m-clock')
                ->color('info'),
        ];
    }
}
