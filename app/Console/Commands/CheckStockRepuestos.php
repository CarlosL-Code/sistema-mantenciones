<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Repuesto;
use App\Models\User;
use Filament\Notifications\Notification;

class CheckStockRepuestos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-stock-repuestos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Chequea el stock de repuestos y envía notificaciones si es bajo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $admins = User::role(['admin', 'supervisor'])->get();
        if ($admins->isEmpty()) {
            $admins = User::all(); // Fallback si no hay roles
        }

        $repuestosBajos = Repuesto::where('stock_actual', '<=', 5)->get();

        foreach ($repuestosBajos as $repuesto) {
            foreach ($admins as $admin) {
                Notification::make()
                    ->title('Stock Bajo de Repuesto')
                    ->body("El repuesto {$repuesto->nombre} tiene solo {$repuesto->stock_actual} unidades en inventario.")
                    ->warning()
                    ->sendToDatabase($admin);
            }
        }

        $this->info('Revision de stock finalizada. ' . count($repuestosBajos) . ' repuestos con stock bajo.');
    }
}
