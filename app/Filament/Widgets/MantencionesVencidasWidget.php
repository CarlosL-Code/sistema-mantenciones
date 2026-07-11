<?php

namespace App\Filament\Widgets;

use App\Models\Mantencion;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class MantencionesVencidasWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';
    
    protected static ?string $heading = 'Mantenciones Próximas o Vencidas';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Mantencion::query()
                    ->where('estado', '!=', 'Completada')
                    ->whereNotNull('fecha_proxima')
                    ->orderBy('fecha_proxima', 'asc')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('maquinaria.nombre')->label('Activo'),
                Tables\Columns\TextColumn::make('tipo'),
                Tables\Columns\TextColumn::make('fecha_proxima')
                    ->label('Fecha Programada')
                    ->date()
                    ->color(fn ($record) => $record->fecha_proxima < now() ? 'danger' : 'warning'),
                Tables\Columns\TextColumn::make('estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pendiente' => 'danger',
                        'En Proceso' => 'warning',
                        default => 'gray',
                    }),
            ])
            ->paginated(false);
    }
}
