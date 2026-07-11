<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Form;

class UserForm
{
    public static function configure(Form $form): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                \Filament\Forms\Components\TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required()
                    ->maxLength(255),
                \Filament\Forms\Components\TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (\Filament\Pages\Page $livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                    ->maxLength(255),
                \Filament\Forms\Components\Select::make('roles')
                    ->label('Roles de Acceso')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->required(),
            ]);
    }
}
