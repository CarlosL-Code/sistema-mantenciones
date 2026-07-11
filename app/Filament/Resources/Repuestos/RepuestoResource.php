<?php

namespace App\Filament\Resources\Repuestos;

use App\Filament\Resources\Repuestos\Pages\CreateRepuesto;
use App\Filament\Resources\Repuestos\Pages\EditRepuesto;
use App\Filament\Resources\Repuestos\Pages\ListRepuestos;
use App\Filament\Resources\Repuestos\Schemas\RepuestoForm;
use App\Filament\Resources\Repuestos\Tables\RepuestosTable;
use App\Models\Repuesto;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RepuestoResource extends Resource
{
    protected static ?string $model = Repuesto::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Inventario';
    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Repuesto';
    protected static ?string $pluralModelLabel = 'Repuestos';

    public static function form(Schema $schema): Schema
    {
        return RepuestoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RepuestosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\IngresosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRepuestos::route('/'),
            'create' => CreateRepuesto::route('/create'),
            'edit' => EditRepuesto::route('/{record}/edit'),
        ];
    }
}
