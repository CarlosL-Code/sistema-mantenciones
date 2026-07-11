<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Mantencion;
use App\Mail\AlertaMantencionMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class EnviarAlertasMantenciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:enviar-alertas-mantenciones';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía alertas por correo para mantenciones próximas (3 días)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fechaObjetivo = Carbon::today()->addDays(3);

        $mantenciones = Mantencion::whereDate('fecha_proxima', $fechaObjetivo)
            ->where('estado', 'Pendiente')
            ->with('maquinaria')
            ->get();

        foreach ($mantenciones as $mantencion) {
            // Se envía al admin o a un correo configurado. Por ahora, a admin@mantenciones.local
            // Idealmente, se sacaría del usuario responsable o admin
            Mail::to('admin@mantenciones.local')->send(new AlertaMantencionMail($mantencion));
            $this->info("Alerta enviada para la mantención de: {$mantencion->maquinaria->nombre}");
        }

        $this->info('Proceso de alertas finalizado.');
    }
}
