<?php

use App\Models\Maquinaria;
use App\Models\Repuesto;
use App\Models\Mantencion;

// 1. Crear Maquinarias
$maq1 = Maquinaria::create([
    'nombre' => 'Retroexcavadora CAT 420F2',
    'codigo_interno' => 'MAQ-001',
    'marca' => 'Caterpillar',
    'modelo' => '420F2',
    'anio' => 2018,
    'numero_serie' => 'CAT42000001',
    'estado' => 'Operativa',
]);

$maq2 = Maquinaria::create([
    'nombre' => 'Tractor John Deere 5090E',
    'codigo_interno' => 'MAQ-002',
    'marca' => 'John Deere',
    'modelo' => '5090E',
    'anio' => 2021,
    'numero_serie' => 'JD50900002',
    'estado' => 'En Mantención',
]);

// 2. Crear Repuestos
$repuestosData = [
    ['codigo_interno' => 'REP-001', 'nombre' => 'Filtro de Aceite', 'stock_actual' => 50, 'precio_unitario' => 15000],
    ['codigo_interno' => 'REP-002', 'nombre' => 'Aceite Hidráulico 10W (Litro)', 'stock_actual' => 200, 'precio_unitario' => 5000],
    ['codigo_interno' => 'REP-003', 'nombre' => 'Correa de Alternador', 'stock_actual' => 20, 'precio_unitario' => 25000],
    ['codigo_interno' => 'REP-004', 'nombre' => 'Bujía de Precalentamiento', 'stock_actual' => 30, 'precio_unitario' => 12000],
    ['codigo_interno' => 'REP-005', 'nombre' => 'Batería 12V 100Ah', 'stock_actual' => 5, 'precio_unitario' => 85000],
];

$repuestos = [];
foreach ($repuestosData as $data) {
    $repuestos[] = Repuesto::create($data);
}

// 3. Crear Mantención 1 (Preventiva)
$mantencion1 = Mantencion::create([
    'maquinaria_id' => $maq1->id,
    'tipo' => 'Preventiva',
    'responsable' => 'Juan Pérez',
    'fecha_realizacion' => now()->subDays(2),
    'fecha_proxima' => now()->addMonths(6),
    'costo' => 0, // Se calculará según repuestos
    'observaciones_tecnico' => 'Cambio de aceite y filtros de rutina. Revisión general en buen estado.',
]);

// Adjuntar repuestos y calcular costo
$costo1 = 0;
// 1 Filtro de Aceite
$mantencion1->repuestos()->attach($repuestos[0]->id, ['cantidad' => 1, 'precio_total' => $repuestos[0]->precio_unitario]);
$costo1 += $repuestos[0]->precio_unitario;
$repuestos[0]->decrement('stock_actual', 1);

// 10 Litros de Aceite Hidráulico
$mantencion1->repuestos()->attach($repuestos[1]->id, ['cantidad' => 10, 'precio_total' => $repuestos[1]->precio_unitario * 10]);
$costo1 += ($repuestos[1]->precio_unitario * 10);
$repuestos[1]->decrement('stock_actual', 10);

$mantencion1->update(['costo' => $costo1 + 20000]); // 20000 de mano de obra

// 4. Crear Mantención 2 (Correctiva)
$mantencion2 = Mantencion::create([
    'maquinaria_id' => $maq2->id,
    'tipo' => 'Correctiva',
    'responsable' => 'Carlos Soto',
    'fecha_realizacion' => null, // Pendiente
    'fecha_proxima' => now()->addDays(5),
    'costo' => 0,
    'observaciones_tecnico' => 'Máquina no arranca. Se diagnostica falla en batería y se requiere reemplazo de correa.',
]);

// Adjuntar repuestos
$costo2 = 0;
// 1 Batería
$mantencion2->repuestos()->attach($repuestos[4]->id, ['cantidad' => 1, 'precio_total' => $repuestos[4]->precio_unitario]);
$costo2 += $repuestos[4]->precio_unitario;
$repuestos[4]->decrement('stock_actual', 1);

// 1 Correa
$mantencion2->repuestos()->attach($repuestos[2]->id, ['cantidad' => 1, 'precio_total' => $repuestos[2]->precio_unitario]);
$costo2 += $repuestos[2]->precio_unitario;
$repuestos[2]->decrement('stock_actual', 1);

$mantencion2->update(['costo' => $costo2 + 45000]); // 45000 mano de obra

echo "Datos de prueba creados exitosamente.\n";
