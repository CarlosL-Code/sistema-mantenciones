<?php

namespace App\Filament\Resources\Mantencions\Pages;

use App\Filament\Resources\Mantencions\MantencionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMantencions extends ListRecords
{
    protected static string $resource = MantencionResource::class;

    protected function getFooterWidgets(): array
    {
        return [
            \App\Filament\Widgets\MantenimientoCalendarWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nuevo Mantenimiento')
                ->icon('heroicon-o-plus'),
        ];
    }
}
