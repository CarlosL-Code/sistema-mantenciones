<?php

namespace App\Filament\Resources\Mantencions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class MantencionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordAction('view')
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('maquinaria.nombre')->label('Maquinaria')->searchable()->sortable(),
                \Filament\Tables\Columns\TextColumn::make('tecnico.name')->label('Técnico Asignado')->searchable()->sortable()->visibleFrom('md'),
                \Filament\Tables\Columns\TextColumn::make('tipo')->searchable()->sortable()->visibleFrom('md'),
                \Filament\Tables\Columns\TextColumn::make('estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pendiente' => 'danger',
                        'En Proceso' => 'warning',
                        'Completada' => 'success',
                        default => 'gray',
                    }),
                \Filament\Tables\Columns\TextColumn::make('prioridad')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Baja' => 'gray',
                        'Media' => 'warning',
                        'Alta' => 'danger',
                        default => 'primary',
                    })
                    ->visibleFrom('md'),
                \Filament\Tables\Columns\TextColumn::make('responsable')->searchable()->visibleFrom('md'),
                \Filament\Tables\Columns\TextColumn::make('fecha_realizacion')->date()->sortable()->visibleFrom('md'),
                \Filament\Tables\Columns\TextColumn::make('fecha_proxima')->date()->sortable()->visibleFrom('md'),
                \Filament\Tables\Columns\TextColumn::make('costo')->money('CLP')->sortable()->visibleFrom('md'),
                \Filament\Tables\Columns\ImageColumn::make('foto')->label('Evidencia'),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('estado')
                    ->options([
                        'Pendiente' => 'Pendiente',
                        'En Proceso' => 'En Proceso',
                        'Completada' => 'Completada',
                    ]),
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make()
                    ->extraModalFooterActions([
                        \Filament\Actions\Action::make('realizar_mantenimiento')
                            ->label('Realizar Mantenimiento')
                            ->color('primary')
                            ->url(fn ($record) => url('/admin/mantencions/' . $record->id . '/edit')),
                    ]),
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\Action::make('pdf')
                    ->label('Descargar PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->action(function ($record) {
                        $pdf = new \Dompdf\Dompdf();
                        $html = view('pdf.orden_trabajo', ['mantencion' => $record])->render();
                        $pdf->loadHtml($html);
                        $pdf->setPaper('A4', 'portrait');
                        $pdf->render();
                        $output = $pdf->output();
                        return response()->streamDownload(
                            fn () => print($output),
                            "Orden_Trabajo_{$record->id}.pdf"
                        );
                    }),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
