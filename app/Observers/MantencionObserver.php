<?php

namespace App\Observers;

use App\Models\Mantencion;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificacionMantencionMail;

class MantencionObserver
{
    /**
     * Handle the Mantencion "created" event.
     */
    public function created(Mantencion $mantencion): void
    {
        $tecnicos = User::role('tecnico')->get();
        $admins = User::role('super_admin')->get();

        $recipients = $tecnicos->merge($admins)->unique('id');
        $maquinariaName = $mantencion->maquinaria ? $mantencion->maquinaria->nombre : 'Desconocida';
        $titulo = 'Nueva Mantención Reportada';
        $mensaje = "Se ha reportado un nuevo requerimiento para la máquina: {$maquinariaName}.";

        // Notificación en base de datos (Filament)
        Notification::make()
            ->title($titulo)
            ->body($mensaje)
            ->icon('heroicon-o-wrench-screwdriver')
            ->success()
            ->actions([
                Action::make('Ver')
                    ->url(route('filament.admin.resources.mantencions.edit', $mantencion))
                    ->button(),
            ])
            ->sendToDatabase($recipients);

        // Envío por correo a los mismos destinatarios
        foreach ($recipients as $user) {
            if ($user->email) {
                Mail::to($user->email)->send(new NotificacionMantencionMail($mantencion, $titulo, $mensaje));
            }
        }
    }

    /**
     * Handle the Mantencion "updated" event.
     */
    public function updated(Mantencion $mantencion): void
    {
        if ($mantencion->wasChanged('estado') && $mantencion->estado === 'Completada') {
            $supervisores = User::role('supervisor')->get();
            $admins = User::role('super_admin')->get();

            $recipients = $supervisores->merge($admins)->unique('id');
            $maquinariaName = $mantencion->maquinaria ? $mantencion->maquinaria->nombre : 'Desconocida';
            $titulo = 'Mantención Completada';
            $mensaje = "La mantención de la máquina {$maquinariaName} ha sido marcada como Completada.";

            // Notificación en base de datos (Filament)
            Notification::make()
                ->title($titulo)
                ->body($mensaje)
                ->icon('heroicon-o-check-circle')
                ->success()
                ->actions([
                    Action::make('Ver')
                        ->url(route('filament.admin.resources.mantencions.edit', $mantencion))
                        ->button(),
                ])
                ->sendToDatabase($recipients);
            
            // Envío por correo
            foreach ($recipients as $user) {
                if ($user->email) {
                    Mail::to($user->email)->send(new NotificacionMantencionMail($mantencion, $titulo, $mensaje));
                }
            }
        }
    }

    public function deleted(Mantencion $mantencion): void {}
    public function restored(Mantencion $mantencion): void {}
    public function forceDeleted(Mantencion $mantencion): void {}
}
