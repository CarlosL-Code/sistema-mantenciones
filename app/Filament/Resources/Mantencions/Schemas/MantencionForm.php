<?php

namespace App\Filament\Resources\Mantencions\Schemas;

use Filament\Forms\Form;

class MantencionForm
{
    public static function configure(Form $form): Form
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Tabs::make('Mantencion')
                    ->tabs([
                        \Filament\Schemas\Components\Tabs\Tab::make('1. Registro e Inspección')
                            ->schema([
                                \Filament\Forms\Components\Select::make('maquinaria_id')
                                    ->relationship('maquinaria', 'nombre')
                                    ->searchable()
                                    ->required()
                                    ->label('Activo (Maquinaria/Equipo)'),
                                \Filament\Forms\Components\Select::make('tecnico_id')
                                    ->relationship('tecnico', 'name')
                                    ->searchable()
                                    ->label('Técnico Asignado (Opcional)'),
                                \Filament\Forms\Components\Select::make('tipo')
                                    ->options([
                                        'Preventiva' => 'Preventiva',
                                        'Correctiva' => 'Correctiva',
                                    ])
                                    ->required()
                                    ->label('Tipo de Mantención'),
                                \Filament\Forms\Components\Select::make('estado')
                                    ->options([
                                        'Pendiente' => 'Pendiente',
                                        'En Proceso' => 'En Proceso',
                                        'Completada' => 'Completada',
                                    ])
                                    ->default('Pendiente')
                                    ->required()
                                    ->label('Estado de la Orden'),
                                \Filament\Forms\Components\Select::make('prioridad')
                                    ->options([
                                        'Baja' => 'Baja',
                                        'Media' => 'Media',
                                        'Alta' => 'Alta',
                                    ])
                                    ->default('Media')
                                    ->required(),
                                \Filament\Forms\Components\DatePicker::make('fecha_realizacion')
                                    ->label('Fecha de Solicitud/Inspección')
                                    ->required(),
                                \Filament\Forms\Components\DatePicker::make('fecha_proxima')
                                    ->label('Fecha Próxima Programada')
                                    ->required(),
                                \Filament\Forms\Components\Textarea::make('observaciones_tecnico')
                                    ->label('Problema Reportado / Observación Inicial')
                                    ->columnSpanFull(),
                                \Filament\Forms\Components\FileUpload::make('foto')
                                    ->image()
                                    ->imageResizeMode('cover')
                                    ->imageResizeTargetWidth('1024')
                                    ->imageResizeTargetHeight('1024')
                                    ->maxSize(20480)
                                    ->directory('mantenciones_fotos')
                                    ->label('Foto (Imagen Principal)')
                                    ->columnSpanFull(),
                                \Filament\Forms\Components\FileUpload::make('evidencia_fotografica')
                                    ->image()
                                    ->imageResizeMode('cover')
                                    ->imageResizeTargetWidth('1024')
                                    ->imageResizeTargetHeight('1024')
                                    ->maxSize(20480)
                                    ->multiple()
                                    ->directory('mantenciones_evidencias')
                                    ->label('Evidencia Adicional (Múltiples Fotos)')
                                    ->columnSpanFull(),
                            ])
                            ->columns(['sm' => 1, 'md' => 2]),

                        \Filament\Schemas\Components\Tabs\Tab::make('2. Reparación y Trabajo')
                            ->hidden(fn (string $operation): bool => $operation === 'create')
                            ->schema([
                                \Filament\Forms\Components\Textarea::make('trabajo_realizado')
                                    ->label('Detalle del Trabajo Realizado')
                                    ->columnSpanFull(),
                                \Filament\Forms\Components\Textarea::make('resultado')
                                    ->label('Resultado de la Mantención')
                                    ->columnSpanFull(),
                                \Filament\Forms\Components\DatePicker::make('fecha_reparacion')
                                    ->label('Fecha de Reparación Efectiva'),
                                \Filament\Forms\Components\TextInput::make('tiempo_utilizado')
                                    ->label('Tiempo Utilizado (Ej: 3 horas, 2 días)'),
                                \Filament\Forms\Components\Select::make('tipo_tecnico')
                                    ->label('Tipo de Técnico')
                                    ->options([
                                        'Interno' => 'Interno',
                                        'Externo' => 'Externo',
                                    ])
                                    ->default('Interno'),
                                \Filament\Forms\Components\Select::make('proveedor_id')
                                    ->relationship('proveedor', 'nombre')
                                    ->label('Proveedor / Empresa Externa')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        \Filament\Forms\Components\TextInput::make('nombre')->required(),
                                        \Filament\Forms\Components\TextInput::make('rut'),
                                    ]),
                                \Filament\Forms\Components\TextInput::make('responsable_reparacion')
                                    ->label('Nombre del Técnico Externo (Opcional)'),
                            ])
                            ->columns(['sm' => 1, 'md' => 2]),

                        \Filament\Schemas\Components\Tabs\Tab::make('3. Repuestos y Costos')
                            ->hidden(fn (string $operation): bool => $operation === 'create')
                            ->schema([
                                \Filament\Forms\Components\Repeater::make('mantencionRepuestos')
                                    ->relationship('mantencionRepuestos')
                                    ->label('Repuestos Utilizados')
                                    ->schema([
                                        \Filament\Forms\Components\Select::make('repuesto_id')
                                            ->label('Repuesto')
                                            ->options(\App\Models\Repuesto::pluck('nombre', 'id'))
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(function ($get, $set, $state) {
                                                if ($state) {
                                                    $repuesto = \App\Models\Repuesto::find($state);
                                                    if ($repuesto) {
                                                        $set('precio_unitario', $repuesto->precio_unitario);
                                                        $set('precio_total', floatval($get('cantidad') ?? 1) * floatval($repuesto->precio_unitario));
                                                    }
                                                }
                                            }),
                                        \Filament\Forms\Components\TextInput::make('cantidad')
                                            ->numeric()
                                            ->required()
                                            ->default(1)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function ($get, $set) {
                                                $set('precio_total', floatval($get('cantidad')) * floatval($get('precio_unitario')));
                                            }),
                                        \Filament\Forms\Components\TextInput::make('precio_unitario')
                                            ->numeric()
                                            ->required()
                                            ->default(0)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function ($get, $set) {
                                                $set('precio_total', floatval($get('cantidad')) * floatval($get('precio_unitario')));
                                            }),
                                        \Filament\Forms\Components\TextInput::make('precio_total')
                                            ->numeric()
                                            ->required()
                                            ->default(0)
                                            ->readOnly(),
                                    ])
                                    ->columns(['sm' => 1, 'md' => 2, 'lg' => 4])
                                    ->columnSpanFull(),
                                
                                \Filament\Forms\Components\TextInput::make('costo_mano_obra')
                                    ->numeric()
                                    ->prefix('$')
                                    ->label('Costo Mano de Obra'),
                                \Filament\Forms\Components\TextInput::make('costo_externo')
                                    ->numeric()
                                    ->prefix('$')
                                    ->label('Costo Servicios Externos'),
                                \Filament\Forms\Components\TextInput::make('costo_otros')
                                    ->numeric()
                                    ->prefix('$')
                                    ->label('Otros Costos'),
                            ])
                            ->columns(['sm' => 1, 'md' => 2, 'lg' => 3]),
                        
                        \Filament\Schemas\Components\Tabs\Tab::make('4. Firma y Cierre')
                            ->hidden(fn (string $operation): bool => $operation === 'create')
                            ->schema([
                                \Filament\Schemas\Components\Fieldset::make('Firma Electrónica del Técnico')
                                    ->schema([
                                        \Filament\Forms\Components\TextInput::make('firma_nombre')
                                            ->label('Nombre del Técnico')
                                            ->placeholder('Ej. Juan Pérez')
                                            ->required(),
                                        \Filament\Forms\Components\TextInput::make('firma_rut')
                                            ->label('RUT del Técnico')
                                            ->placeholder('Ej. 12.345.678-9')
                                            ->required(),
                                        \Filament\Forms\Components\Checkbox::make('firma_confirmacion')
                                            ->label('Declaro que la información es verídica y la mantención fue realizada.')
                                            ->accepted()
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(['sm' => 1, 'md' => 2])
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
