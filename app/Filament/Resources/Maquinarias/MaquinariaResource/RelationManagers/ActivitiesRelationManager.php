<?php

namespace App\Filament\Resources\Maquinarias\MaquinariaResource\RelationManagers;

use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ActivitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'activities';

    protected static ?string $title = 'Historial de Actividad';
    protected static ?string $recordTitleAttribute = 'description';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Read-only
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha y Hora')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event')
                    ->label('Evento')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('causer.name')
                    ->label('Usuario'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción'),
                Tables\Columns\TextColumn::make('properties')
                    ->label('Cambios')
                    ->wrap()
                    ->html()
                    ->formatStateUsing(function ($state) {
                        if (empty($state) || !is_array($state)) return '-';
                        
                        $html = '<ul class="list-disc pl-4 text-sm">';
                        $attributes = $state['attributes'] ?? $state;
                        $old = $state['old'] ?? [];
                        
                        foreach ($attributes as $key => $value) {
                            if (is_array($value)) {
                                $value = json_encode($value);
                            }
                            
                            if (array_key_exists($key, $old)) {
                                $oldValue = is_array($old[$key]) ? json_encode($old[$key]) : $old[$key];
                                if ($oldValue !== $value) {
                                    $html .= "<li><strong>{$key}:</strong> <span class='line-through text-gray-400'>{$oldValue}</span> <span class='text-primary-600 font-bold'>&rarr;</span> {$value}</li>";
                                }
                            } else {
                                $html .= "<li><strong>{$key}:</strong> {$value}</li>";
                            }
                        }
                        $html .= '</ul>';
                        
                        return $html;
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Read-only
            ])
            ->actions([
                // Read-only
            ])
            ->bulkActions([
                // Read-only
            ])
            ->defaultSort('created_at', 'desc');
    }
}
