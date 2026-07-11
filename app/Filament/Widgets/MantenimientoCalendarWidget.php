<?php

namespace App\Filament\Widgets;

use App\Models\Mantencion;
use Filament\Widgets\Widget;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;

class MantenimientoCalendarWidget extends Widget implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    protected string $view = 'filament.widgets.mantenimiento-calendar-widget';

    protected static ?int $sort = 1;
    
    // Ocupar todo el ancho
    protected int | string | array $columnSpan = 'full';

    public function viewMantencionAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\ViewAction::make('viewMantencion')
            ->record(fn(array $arguments) => Mantencion::find($arguments['record']))
            ->form(fn ($form) => \App\Filament\Resources\Mantencions\Schemas\MantencionForm::configure($form))
            ->extraModalFooterActions([
                \Filament\Actions\Action::make('realizar_mantenimiento')
                    ->label('Realizar Mantenimiento')
                    ->color('primary')
                    ->url(fn ($record) => url('/admin/mantencions/' . $record->id . '/edit'))
            ]);
    }

    public function getEvents(): array
    {
        $mantenciones = Mantencion::with('maquinaria')->get();
        $events = [];

        foreach ($mantenciones as $mantencion) {
            if (!$mantencion->fecha_realizacion && !$mantencion->fecha_proxima) {
                continue; // Saltar si no hay fecha
            }

            // Usar la fecha programada o real
            $fecha = $mantencion->fecha_proxima ?? $mantencion->fecha_realizacion;
            
            // Determinar color por estado
            $color = match ($mantencion->estado) {
                'Completado' => '#22c55e',
                'En Progreso' => '#eab308',
                'Pendiente' => '#3b82f6',
                'Cancelado' => '#ef4444',
                default => '#6b7280',
            };

            $title = $mantencion->maquinaria ? "{$mantencion->tipo} - {$mantencion->maquinaria->nombre}" : $mantencion->tipo;

            $events[] = [
                'id' => $mantencion->id,
                'title' => $title,
                'start' => \Carbon\Carbon::parse($fecha)->format('Y-m-d'),
                'color' => $color,
                'url' => url('/admin/mantencions/' . $mantencion->id . '/edit'),
            ];
        }

        return $events;
    }
}
