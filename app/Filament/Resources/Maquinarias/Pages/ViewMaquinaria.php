<?php

namespace App\Filament\Resources\Maquinarias\Pages;

use App\Filament\Resources\Maquinarias\MaquinariaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMaquinaria extends ViewRecord
{
    protected static string $resource = MaquinariaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('descargar_qr')
                ->label('Imprimir QR')
                ->icon('heroicon-o-qr-code')
                ->color('success')
                ->action(function () {
                    $record = $this->getRecord();
                    $url = url('/admin/maquinarias/' . $record->id);
                    $qr = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(300)->generate($url);
                    return response()->streamDownload(
                        fn () => print($qr),
                        "QR_{$record->codigo_interno}.svg"
                    );
                }),
        ];
    }

    public function getTitle(): string | \Illuminate\Contracts\Support\Htmlable
    {
        return $this->getRecord()->nombre;
    }
}
