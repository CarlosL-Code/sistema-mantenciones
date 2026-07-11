<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mantencions', function (Blueprint $table) {
            $table->string('prioridad')->default('Media')->after('estado'); // Baja, Media, Alta
            $table->json('evidencia_fotografica')->nullable()->after('foto');
            $table->text('trabajo_realizado')->nullable()->after('observaciones_tecnico');
            $table->text('resultado')->nullable()->after('trabajo_realizado');
            $table->date('fecha_reparacion')->nullable()->after('fecha_realizacion');
            $table->string('responsable_reparacion')->nullable()->after('responsable');
            $table->string('tipo_tecnico')->default('Interno')->after('responsable_reparacion'); // Interno, Externo
            $table->string('tiempo_utilizado')->nullable()->after('tipo_tecnico'); // Ej: 2 horas, 1 dia
            $table->decimal('costo_mano_obra', 10, 2)->nullable()->after('costo');
            $table->decimal('costo_externo', 10, 2)->nullable()->after('costo_mano_obra');
            $table->decimal('costo_otros', 10, 2)->nullable()->after('costo_externo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mantencions', function (Blueprint $table) {
            $table->dropColumn([
                'prioridad', 'evidencia_fotografica', 'trabajo_realizado', 'resultado',
                'fecha_reparacion', 'responsable_reparacion', 'tipo_tecnico', 'tiempo_utilizado',
                'costo_mano_obra', 'costo_externo', 'costo_otros'
            ]);
        });
    }
};
