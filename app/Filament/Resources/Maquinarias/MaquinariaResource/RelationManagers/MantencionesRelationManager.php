<?php

namespace App\Filament\Resources\Maquinarias\MaquinariaResource\RelationManagers;

use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class MantencionesRelationManager extends RelationManager
{
    protected static string $relationship = 'mantenciones';

    protected static ?string $recordTitleAttribute = 'id';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('fecha_realizacion')->date(),
                Tables\Columns\TextColumn::make('tipo'),
                Tables\Columns\TextColumn::make('estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pendiente' => 'danger',
                        'En Proceso' => 'warning',
                        'Completada' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('responsable'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make(),
            ])
            ->toolbarActions([
            ]);
    }
}
