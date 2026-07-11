<?php

namespace App\Filament\Resources\Repuestos\RelationManagers;

use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class IngresosRelationManager extends RelationManager
{
    protected static string $relationship = 'ingresos';

    protected static ?string $title = 'Historial de Compras / Ingresos';
    protected static ?string $recordTitleAttribute = 'id';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\DatePicker::make('fecha')
                    ->label('Fecha de Ingreso')
                    ->default(now())
                    ->required(),
                Forms\Components\TextInput::make('cantidad')
                    ->label('Cantidad Comprada')
                    ->numeric()
                    ->default(1)
                    ->minValue(1)
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($get, $set) {
                        $set('costo_total', floatval($get('cantidad')) * floatval($get('costo_unitario')));
                    }),
                Forms\Components\TextInput::make('costo_unitario')
                    ->label('Costo Unitario')
                    ->numeric()
                    ->prefix('$')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($get, $set) {
                        $set('costo_total', floatval($get('cantidad')) * floatval($get('costo_unitario')));
                    }),
                Forms\Components\TextInput::make('costo_total')
                    ->label('Costo Total')
                    ->numeric()
                    ->prefix('$')
                    ->readOnly()
                    ->required(),
                Forms\Components\TextInput::make('numero_factura')
                    ->label('N° Factura / Boleta')
                    ->maxLength(255),
                Forms\Components\Textarea::make('observaciones')
                    ->label('Observaciones')
                    ->columnSpanFull(),
                Forms\Components\Hidden::make('user_id')
                    ->default(fn () => Auth::id()),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fecha')->date('d/m/Y')->sortable(),
                Tables\Columns\TextColumn::make('cantidad')->sortable(),
                Tables\Columns\TextColumn::make('costo_unitario')->money('CLP')->sortable(),
                Tables\Columns\TextColumn::make('costo_total')->money('CLP')->sortable(),
                Tables\Columns\TextColumn::make('numero_factura')->searchable(),
                Tables\Columns\TextColumn::make('user.name')->label('Registrado por'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                \Filament\Actions\CreateAction::make()
                    ->label('Registrar Nueva Compra'),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
