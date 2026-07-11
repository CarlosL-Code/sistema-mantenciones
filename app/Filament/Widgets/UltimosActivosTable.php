<?php

namespace App\Filament\Widgets;

use App\Models\Maquinaria;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UltimosActivosTable extends BaseWidget
{
    protected static bool $isDiscovered = false;
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Maquinaria::query()->latest('created_at')->limit(5)
            )
            ->heading('Últimos Activos Ingresados')
            ->description('Los 5 activos más recientes añadidos al sistema')
            ->columns([
                Tables\Columns\ImageColumn::make('fotografia')
                    ->label('Foto')
                    ->circular(),
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre del Equipo')
                    ->weight('bold')
                    ->searchable(),
                Tables\Columns\TextColumn::make('codigo_interno')
                    ->label('Código')
                    ->badge(),
                Tables\Columns\TextColumn::make('categoria')
                    ->label('Categoría'),
                Tables\Columns\TextColumn::make('estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Operativo' => 'success',
                        'En reparación' => 'warning',
                        'Fuera de servicio' => 'danger',
                        'Dado de baja' => 'gray',
                        default => 'primary',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Ingreso')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->paginated(false)
            ->recordUrl(
                fn (Maquinaria $record): string => route('filament.admin.resources.maquinarias.view', ['record' => $record]),
            );
    }
}
