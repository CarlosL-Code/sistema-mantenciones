<?php

namespace App\Filament\Resources\Maquinarias\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class MaquinariasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordAction('view')
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('fotografia')->label('Foto')->circular(),
                \Filament\Tables\Columns\TextColumn::make('codigo_interno')->searchable()->sortable()->visibleFrom('md'),
                \Filament\Tables\Columns\TextColumn::make('nombre')->searchable()->sortable(),
                \Filament\Tables\Columns\TextColumn::make('categoria')->searchable()->sortable()->visibleFrom('md'),
                \Filament\Tables\Columns\TextColumn::make('area')->searchable()->sortable()->visibleFrom('md'),
                \Filament\Tables\Columns\TextColumn::make('estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Operativo' => 'success',
                        'En reparación' => 'warning',
                        'Fuera de servicio' => 'danger',
                        'Dado de baja' => 'gray',
                        default => 'primary',
                    })
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('fecha_adquisicion')->date()->sortable()->toggleable(isToggledHiddenByDefault: true),
                \Filament\Tables\Columns\TextColumn::make('responsable')->searchable()->toggleable(isToggledHiddenByDefault: true),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha Ingreso (Sistema)')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make()
                    ->extraModalFooterActions([
                        \Filament\Actions\Action::make('editar')
                            ->label('Editar')
                            ->color('primary')
                            ->url(fn ($record) => url('/admin/maquinarias/' . $record->id . '/edit')),
                    ]),
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\Action::make('descargar_qr')
                    ->label('QR')
                    ->icon('heroicon-o-qr-code')
                    ->color('success')
                    ->action(function ($record) {
                        $url = url('/admin/maquinarias/' . $record->id);
                        $qr = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(300)->generate($url);
                        return response()->streamDownload(
                            fn () => print($qr),
                            "QR_{$record->codigo_interno}.svg"
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
