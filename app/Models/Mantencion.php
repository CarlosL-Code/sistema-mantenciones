<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Mantencion extends Model
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
        'maquinaria_id',
        'tecnico_id',
        'tipo',
        'responsable',
        'fecha_realizacion',
        'fecha_proxima',
        'costo',
        'observaciones_tecnico',
        'foto',
        'estado',
        'firma_tecnico',
        'prioridad',
        'evidencia_fotografica',
        'trabajo_realizado',
        'resultado',
        'fecha_reparacion',
        'responsable_reparacion',
        'tipo_tecnico',
        'tiempo_utilizado',
        'costo_mano_obra',
        'costo_externo',
        'costo_otros',
        'proveedor_id',
    ];

    protected $casts = [
        'fecha_realizacion' => 'date',
        'fecha_proxima' => 'date',
        'fecha_reparacion' => 'date',
        'costo' => 'decimal:2',
        'costo_mano_obra' => 'decimal:2',
        'costo_externo' => 'decimal:2',
        'costo_otros' => 'decimal:2',
        'evidencia_fotografica' => 'array',
    ];

    public function maquinaria()
    {
        return $this->belongsTo(Maquinaria::class);
    }

    public function repuestos()
    {
        return $this->belongsToMany(Repuesto::class)
            ->using(MantencionRepuesto::class)
            ->withPivot('cantidad', 'precio_unitario', 'precio_total')
            ->withTimestamps();
    }

    public function mantencionRepuestos()
    {
        return $this->hasMany(MantencionRepuesto::class);
    }

    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
}
