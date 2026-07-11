<?php

namespace App\Filament\Resources\Proveedors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class ProveedorForm
{
    public static function configure(Form $form): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Información del Proveedor')
                    ->description('Datos comerciales y de contacto del contratista o proveedor.')
                    ->schema([
                        TextInput::make('nombre')
                            ->label('Nombre / Razón Social')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('rut')
                            ->label('RUT / NIT')
                            ->maxLength(255),
                        TextInput::make('tipo_servicio')
                            ->label('Tipo de Servicio o Producto')
                            ->placeholder('Ej. Venta de Repuestos, Reparación Hidráulica')
                            ->maxLength(255),
                    ])->columns(['sm' => 1, 'md' => 2, 'lg' => 3])
                    ->columnSpanFull(),

                \Filament\Schemas\Components\Section::make('Datos de Contacto')
                    ->schema([
                        TextInput::make('contacto')
                            ->label('Persona de Contacto')
                            ->maxLength(255),
                        TextInput::make('telefono')
                            ->label('Teléfono')
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Correo Electrónico')
                            ->email()
                            ->maxLength(255),
                    ])->columns(['sm' => 1, 'md' => 2, 'lg' => 3])
                    ->columnSpanFull(),
            ]);
    }
}
