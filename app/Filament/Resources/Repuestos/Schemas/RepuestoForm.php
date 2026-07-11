<?php

namespace App\Filament\Resources\Repuestos\Schemas;

use Filament\Forms\Form;

use Filament\Forms\Components\TextInput;

class RepuestoForm
{
    public static function configure(Form $form): Form
    {
        return $schema
            ->components([
                TextInput::make('codigo_interno')->label('Código Interno')->unique(ignoreRecord: true)->required(),
                TextInput::make('nombre')->required(),
                TextInput::make('stock_actual')->numeric()->default(0)->required(),
                TextInput::make('stock_minimo')->numeric()->default(5)->required()->label('Stock Mínimo'),
                TextInput::make('precio_unitario')->numeric()->prefix('$')->default(0)->required(),
                \Filament\Forms\Components\Select::make('proveedor_id')
                    ->relationship('proveedor', 'nombre')
                    ->label('Proveedor')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('nombre')->required(),
                        TextInput::make('rut'),
                    ]),
            ])->columns(['sm' => 1, 'md' => 2]);
    }
}
