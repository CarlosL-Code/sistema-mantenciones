<?php

namespace App\Filament\Resources\Repuestos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;

class RepuestosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordAction('view')
            ->columns([
                TextColumn::make('codigo_interno')->searchable()->sortable()->visibleFrom('md'),
                TextColumn::make('nombre')->searchable()->sortable(),
                TextColumn::make('stock_actual')
                    ->label('Stock Actual')
                    ->badge()
                    ->color(fn (int $state, $record): string => $state <= $record->stock_minimo ? 'danger' : 'success')
                    ->sortable(),
                TextColumn::make('stock_minimo')->label('Mínimo')->sortable()->visibleFrom('md'),
                TextColumn::make('precio_unitario')->money('CLP')->sortable()->visibleFrom('md'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make()
                    ->extraModalFooterActions([
                        \Filament\Actions\Action::make('editar')
                            ->label('Editar')
                            ->color('primary')
                            ->url(fn ($record) => url('/admin/repuestos/' . $record->id . '/edit')),
                    ]),
                \Filament\Actions\EditAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
