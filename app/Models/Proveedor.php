<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $fillable = [
        'nombre',
        'rut',
        'contacto',
        'telefono',
        'email',
        'tipo_servicio',
    ];

    public function repuestos()
    {
        return $this->hasMany(Repuesto::class);
    }

    public function mantenciones()
    {
        return $this->hasMany(Mantencion::class);
    }
}
