<?php

namespace App\Filament\Resources\Mantencions;

use App\Filament\Resources\Mantencions\Pages\CreateMantencion;
use App\Filament\Resources\Mantencions\Pages\EditMantencion;
use App\Filament\Resources\Mantencions\Pages\ListMantencions;
use App\Filament\Resources\Mantencions\Schemas\MantencionForm;
use App\Filament\Resources\Mantencions\Tables\MantencionsTable;
use App\Models\Mantencion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MantencionResource extends Resource
{
    protected static ?string $model = Mantencion::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationGroup = 'Operaciones';
    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'Orden de Mantenimiento';
    protected static ?string $pluralModelLabel = 'Órdenes de Mantenimiento';

    public static function form(Schema $schema): Schema
    {
        return MantencionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MantencionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMantencions::route('/'),
            'create' => CreateMantencion::route('/create'),
            'edit' => EditMantencion::route('/{record}/edit'),
        ];
    }
}
