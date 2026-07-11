<?php

namespace App\Filament\Resources\Maquinarias\Pages;

use App\Filament\Resources\Maquinarias\MaquinariaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

use App\Filament\Imports\MaquinariaImporter;
use Filament\Actions\ImportAction;

class ListMaquinarias extends ListRecords
{
    protected static string $resource = MaquinariaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->importer(MaquinariaImporter::class)
                ->csvDelimiter(';')
                ->label('Importar Activos')
                ->color('primary')
                ->icon('heroicon-o-arrow-down-tray'),
            CreateAction::make()
                ->label('Nuevo Activo')
                ->icon('heroicon-o-plus'),
        ];
    }
}
