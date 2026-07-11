<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MantencionRepuesto extends Pivot
{
    protected $table = 'mantencion_repuesto';

    protected static function booted()
    {
        static::created(function ($pivot) {
            $repuesto = Repuesto::find($pivot->repuesto_id);
            if ($repuesto) {
                $repuesto->stock_actual -= $pivot->cantidad;
                $repuesto->save();
            }
        });

        static::deleted(function ($pivot) {
            $repuesto = Repuesto::find($pivot->repuesto_id);
            if ($repuesto) {
                $repuesto->stock_actual += $pivot->cantidad;
                $repuesto->save();
            }
        });

        static::updated(function ($pivot) {
            $originalCantidad = $pivot->getOriginal('cantidad');
            $nuevaCantidad = $pivot->cantidad;
            $diferencia = $nuevaCantidad - $originalCantidad;

            $repuesto = Repuesto::find($pivot->repuesto_id);
            if ($repuesto && $diferencia != 0) {
                $repuesto->stock_actual -= $diferencia;
                $repuesto->save();
            }
        });
    }
}
