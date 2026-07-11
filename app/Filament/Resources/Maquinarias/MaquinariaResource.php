<?php

namespace App\Filament\Resources\Maquinarias;

use App\Filament\Resources\Maquinarias\Pages\CreateMaquinaria;
use App\Filament\Resources\Maquinarias\Pages\EditMaquinaria;
use App\Filament\Resources\Maquinarias\Pages\ListMaquinarias;
use App\Filament\Resources\Maquinarias\Schemas\MaquinariaForm;
use App\Filament\Resources\Maquinarias\Tables\MaquinariasTable;
use App\Models\Maquinaria;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MaquinariaResource extends Resource
{
    protected static ?string $model = Maquinaria::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    
    protected static ?string $navigationGroup = 'Inventario';

    protected static ?string $navigationLabel = 'Maquinarias / Equipos';
    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Activo';
    protected static ?string $pluralModelLabel = 'Activos';

    public static function form(Schema $schema): Schema
    {
        return MaquinariaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaquinariasTable::configure($table);
    }

    public static function infolist(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Grid::make(3)->schema([
                    \Filament\Schemas\Components\Group::make([
                        \Filament\Schemas\Components\Section::make('Información General')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('nombre')
                                    ->size(\Filament\Support\Enums\TextSize::Large)
                                    ->weight(\Filament\Support\Enums\FontWeight::Bold),
                                \Filament\Infolists\Components\TextEntry::make('estado')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Operativa' => 'success',
                                        'En Mantención' => 'warning',
                                        'Dada de Baja' => 'danger',
                                        default => 'gray',
                                    }),
                                \Filament\Infolists\Components\TextEntry::make('codigo_interno'),
                                \Filament\Infolists\Components\TextEntry::make('area')
                                    ->label('Área Responsable'),
                            ])->columns(2),
                            
                        \Filament\Schemas\Components\Section::make('Detalles Técnicos')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('marca'),
                                \Filament\Infolists\Components\TextEntry::make('modelo'),
                                \Filament\Infolists\Components\TextEntry::make('numero_serie'),
                                \Filament\Infolists\Components\TextEntry::make('fecha_adquisicion')
                                    ->date(),
                                \Filament\Infolists\Components\TextEntry::make('observaciones')
                                    ->columnSpanFull(),
                            ])->columns(2),
                    ])->columnSpan(2),
                    \Filament\Schemas\Components\Group::make([
                        \Filament\Schemas\Components\Section::make('Código QR')
                            ->description('Escanea para ver esta ficha')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('qr')
                                    ->hiddenLabel()
                                    ->html()
                                    ->state(function ($record) {
                                        $url = url('/admin/maquinarias/' . $record->id);
                                        $qr = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate($url);
                                        return new \Illuminate\Support\HtmlString('<div style="display: flex; justify-content: center; padding: 1rem; background-color: white; border-radius: 0.5rem;">' . $qr . '</div>');
                                    }),
                            ]),
                    ])->columnSpan(1),
                ])
            ])->columns(1);
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\Maquinarias\MaquinariaResource\RelationManagers\MantencionesRelationManager::class,
            \App\Filament\Resources\Maquinarias\MaquinariaResource\RelationManagers\ActivitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMaquinarias::route('/'),
            'create' => CreateMaquinaria::route('/create'),
            'view' => Pages\ViewMaquinaria::route('/{record}'),
            'edit' => EditMaquinaria::route('/{record}/edit'),
        ];
    }
}
