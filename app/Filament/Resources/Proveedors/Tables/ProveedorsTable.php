<?php

namespace App\Filament\Resources\Proveedors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProveedorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordAction('view')
            ->columns([
                TextColumn::make('nombre')
                    ->label('Razón Social')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('rut')
                    ->label('RUT / NIT')
                    ->searchable()
                    ->visibleFrom('md'),
                TextColumn::make('contacto')
                    ->label('Contacto')
                    ->searchable(),
                TextColumn::make('telefono')
                    ->label('Teléfono')
                    ->searchable()
                    ->visibleFrom('md'),
                TextColumn::make('email')
                    ->label('Correo')
                    ->searchable()
                    ->visibleFrom('md'),
                TextColumn::make('tipo_servicio')
                    ->label('Servicio')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->visibleFrom('md'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                            ->url(fn ($record) => url('/admin/proveedors/' . $record->id . '/edit')),
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
