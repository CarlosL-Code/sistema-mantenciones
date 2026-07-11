<?php

namespace App\Console\Commands;

use App\Models\Mantencion;
use App\Models\User;
use App\Mail\MantencionProximaMail;
use Filament\Notifications\Notification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckMantencionesProximas extends Command
{
    protected $signature = 'app:check-mantenciones-proximas';
    protected $description = 'Revisa mantenciones próximas y vencidas para notificar a los supervisores/técnicos';

    public function handle()
    {
        // Vencidas
        $vencidas = Mantencion::where('estado', '!=', 'Completada')
            ->whereNotNull('fecha_proxima')
            ->whereDate('fecha_proxima', '<', now()->toDateString())
            ->get();
            
        // Próximas (a 3 días)
        $proximas = Mantencion::where('estado', '!=', 'Completada')
            ->whereNotNull('fecha_proxima')
            ->whereDate('fecha_proxima', '=', now()->addDays(3)->toDateString())
            ->get();

        $users = User::role(['admin', 'supervisor'])->get();

        foreach ($vencidas as $mantencion) {
            foreach ($users as $user) {
                // Notificación en Filament
                Notification::make()
                    ->title('Mantención Vencida')
                    ->body("La mantención del activo {$mantencion->maquinaria->nombre} está vencida desde el {$mantencion->fecha_proxima}.")
                    ->danger()
                    ->sendToDatabase($user);
                    
                // Correo Electrónico
                Mail::to($user->email)->queue(new MantencionProximaMail($mantencion, 'vencida'));
            }
        }
        
        foreach ($proximas as $mantencion) {
            foreach ($users as $user) {
                // Notificación en Filament
                Notification::make()
                    ->title('Mantención Próxima')
                    ->body("La mantención del activo {$mantencion->maquinaria->nombre} está programada para el {$mantencion->fecha_proxima}.")
                    ->warning()
                    ->sendToDatabase($user);
                    
                // Correo Electrónico
                Mail::to($user->email)->queue(new MantencionProximaMail($mantencion, 'proxima'));
            }
        }
        
        $this->info('Revision finalizada. '.count($vencidas).' vencidas, '.count($proximas).' próximas.');
    }
}
