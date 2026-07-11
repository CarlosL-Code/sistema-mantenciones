<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Repuesto extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
    protected $fillable = [
        'codigo_interno',
        'nombre',
        'stock_actual',
        'stock_minimo',
        'precio_unitario',
        'proveedor_id',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function mantenciones()
    {
        return $this->belongsToMany(Mantencion::class)
            ->withPivot('cantidad', 'precio_total')
            ->withTimestamps();
    }

    public function ingresos()
    {
        return $this->hasMany(IngresoRepuesto::class);
    }
}
