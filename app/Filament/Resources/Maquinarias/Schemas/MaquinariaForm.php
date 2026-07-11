<?php

namespace App\Filament\Resources\Maquinarias\Schemas;

use Filament\Forms\Form;

class MaquinariaForm
{
    public static function configure(Form $form): Form
    {
        return $schema
            ->columns(3)
            ->components([
                \Filament\Schemas\Components\Group::make()
                    ->columnSpan(['lg' => 2])
                    ->schema([
                        \Filament\Schemas\Components\Section::make('Identificación del Activo')
                            ->description('Información principal y características básicas.')
                            ->icon('heroicon-o-cube')
                            ->columns(2)
                            ->schema([
                                \Filament\Forms\Components\TextInput::make('codigo_interno')
                                    ->label('Código Interno')
                                    ->placeholder('Ej: CSJ-001')
                                    ->required()
                                    ->maxLength(255),
                                \Filament\Forms\Components\TextInput::make('nombre')
                                    ->label('Nombre del Activo')
                                    ->required()
                                    ->maxLength(255),
                                \Filament\Forms\Components\Select::make('categoria')
                                    ->label('Categoría')
                                    ->options([
                                        'Maquinaria de Producción' => 'Maquinaria de Producción',
                                        'Equipamiento General' => 'Equipamiento General',
                                        'Vehículos' => 'Vehículos',
                                        'Herramientas' => 'Herramientas',
                                        'Otro' => 'Otro',
                                    ])
                                    ->required()
                                    ->native(false),
                                \Filament\Forms\Components\Select::make('estado')
                                    ->label('Estado Actual')
                                    ->options([
                                        'Operativo' => 'Operativo',
                                        'En reparación' => 'En reparación',
                                        'Fuera de servicio' => 'Fuera de servicio',
                                        'Dado de baja' => 'Dado de baja',
                                    ])
                                    ->default('Operativo')
                                    ->required()
                                    ->native(false),
                                \Filament\Forms\Components\FileUpload::make('fotografia')
                                    ->label('Fotografía')
                                    ->image()
                                    ->imageResizeMode('cover')
                                    ->imageResizeTargetWidth('1024')
                                    ->imageResizeTargetHeight('1024')
                                    ->maxSize(20480)
                                    ->directory('activos')
                                    ->columnSpanFull(),
                            ]),
                            
                        \Filament\Schemas\Components\Section::make('Especificaciones Técnicas')
                            ->description('Detalles de marca, modelo y periodicidad de mantención.')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->columns(2)
                            ->schema([
                                \Filament\Forms\Components\TextInput::make('marca')
                                    ->label('Marca')
                                    ->required()
                                    ->maxLength(255),
                                \Filament\Forms\Components\TextInput::make('modelo')
                                    ->label('Modelo')
                                    ->required()
                                    ->maxLength(255),
                                \Filament\Forms\Components\TextInput::make('numero_serie')
                                    ->label('Número de Serie')
                                    ->required()
                                    ->maxLength(255),
                                \Filament\Forms\Components\DatePicker::make('fecha_adquisicion')
                                    ->label('Fecha de Adquisición')
                                    ->native(false)
                                    ->required()
                                    ->displayFormat('d/m/Y'),
                                \Filament\Forms\Components\Select::make('periodicidad_mantencion')
                                    ->label('Periodicidad Preventiva')
                                    ->options([
                                        'Semanal' => 'Cada semana',
                                        'Quincenal' => 'Cada 15 días',
                                        'Mensual' => 'Cada mes',
                                        'Trimestral' => 'Cada 3 meses',
                                        'Semestral' => 'Cada 6 meses',
                                        'Anual' => 'Anualmente',
                                    ])
                                    ->native(false),
                                \Filament\Forms\Components\Textarea::make('observaciones')
                                    ->label('Observaciones Generales')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ]),
                    ]),

                \Filament\Schemas\Components\Group::make()
                    ->columnSpan(['lg' => 1])
                    ->schema([
                        \Filament\Schemas\Components\Section::make('Ubicación y Asignación')
                            ->icon('heroicon-o-map-pin')
                            ->schema([
                                \Filament\Forms\Components\TextInput::make('area_sector')
                                    ->label('Área o Sector')
                                    ->placeholder('Ej: Envasado')
                                    ->required()
                                    ->maxLength(255),
                                \Filament\Forms\Components\TextInput::make('responsable')
                                    ->label('Responsable del Activo')
                                    ->placeholder('Nombre del encargado')
                                    ->required()
                                    ->maxLength(255),
                                \Filament\Forms\Components\TextInput::make('cantidad')
                                    ->numeric()
                                    ->label('Cantidad')
                                    ->default(1)
                                    ->minValue(1)
                                    ->required(),
                            ]),
                            
                        \Filament\Schemas\Components\Section::make('Baja y Reemplazo')
                            ->description('Información de ciclo de vida final.')
                            ->icon('heroicon-o-arrow-path-rounded-square')
                            ->collapsed()
                            ->schema([
                                \Filament\Forms\Components\Select::make('reemplazado_por_id')
                                    ->label('Activo de Reemplazo')
                                    ->relationship('reemplazadoPor', 'nombre')
                                    ->searchable()
                                    ->native(false),
                                \Filament\Forms\Components\DatePicker::make('fecha_baja')
                                    ->label('Fecha de Baja')
                                    ->native(false)
                                    ->displayFormat('d/m/Y'),
                                \Filament\Forms\Components\Textarea::make('motivo_baja')
                                    ->label('Motivo de Baja')
                                    ->rows(3),
                            ]),
                    ]),
            ]);
    }
}
