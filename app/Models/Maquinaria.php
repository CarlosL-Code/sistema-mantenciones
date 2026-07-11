<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Maquinaria extends Model
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
        'marca',
        'modelo',
        'numero_serie',
        'fecha_adquisicion',
        'estado',
        'area',
        'observaciones',
        'categoria',
        'fotografia',
        'area_sector',
        'responsable',
        'cantidad',
        'periodicidad_mantencion',
        'reemplazado_por_id',
        'fecha_baja',
        'motivo_baja',
    ];

    protected $casts = [
        'fecha_adquisicion' => 'date',
        'fecha_baja' => 'date',
    ];

    public function mantenciones()
    {
        return $this->hasMany(Mantencion::class);
    }

    public function reemplazadoPor()
    {
        return $this->belongsTo(Maquinaria::class, 'reemplazado_por_id');
    }
}
