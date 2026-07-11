<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Mantencion;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;

class LatestMantenciones extends BaseWidget
{
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';
    
    protected static ?string $heading = 'Últimas Órdenes de Trabajo';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Mantencion::query()->latest()->limit(5)
            )
            ->columns([
                TextColumn::make('maquinaria.nombre')
                    ->label('Maquinaria')
                    ->searchable(),
                TextColumn::make('tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Preventiva' => 'info',
                        'Correctiva' => 'warning',
                        'Predictiva' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('fecha_proxima')
                    ->label('Fecha')
                    ->date(),
                TextColumn::make('estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pendiente' => 'danger',
                        'En Proceso' => 'warning',
                        'Completada' => 'success',
                        default => 'gray',
                    }),
            ])
            ->actions([
                Action::make('Ver')
                    ->url(fn (Mantencion $record): string => url('/admin/mantencions/' . $record->id . '/edit'))
                    ->icon('heroicon-m-pencil-square'),
            ])
            ->paginated(false);
    }
}
