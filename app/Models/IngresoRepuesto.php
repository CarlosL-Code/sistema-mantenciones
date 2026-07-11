<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IngresoRepuesto extends Model
{
    protected $fillable = [
        'repuesto_id',
        'user_id',
        'cantidad',
        'costo_unitario',
        'costo_total',
        'fecha',
        'numero_factura',
        'observaciones',
    ];

    protected $casts = [
        'fecha' => 'date',
        'costo_unitario' => 'decimal:2',
        'costo_total' => 'decimal:2',
    ];

    public function repuesto()
    {
        return $this->belongsTo(Repuesto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::created(function ($ingreso) {
            $repuesto = $ingreso->repuesto;
            if ($repuesto) {
                $repuesto->stock_actual += $ingreso->cantidad;
                $repuesto->save();
            }
        });

        static::deleted(function ($ingreso) {
            $repuesto = $ingreso->repuesto;
            if ($repuesto) {
                $repuesto->stock_actual -= $ingreso->cantidad;
                $repuesto->save();
            }
        });
    }
}
