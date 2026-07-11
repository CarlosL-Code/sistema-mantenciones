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
        Schema::table('maquinarias', function (Blueprint $table) {
            $table->string('categoria')->nullable()->after('nombre');
            $table->string('area_sector')->nullable()->after('area'); // Will keep area for backwards compatibility if needed, or we can just use area_sector
            $table->string('fotografia')->nullable()->after('fecha_adquisicion');
            $table->string('responsable')->nullable()->after('fotografia');
            $table->integer('cantidad')->default(1)->after('responsable');
            $table->string('periodicidad_mantencion')->nullable()->after('cantidad');
            
            // Reemplazo y Baja
            $table->foreignId('reemplazado_por_id')->nullable()->constrained('maquinarias')->nullOnDelete();
            $table->date('fecha_baja')->nullable();
            $table->text('motivo_baja')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maquinarias', function (Blueprint $table) {
            $table->dropForeign(['reemplazado_por_id']);
            $table->dropColumn([
                'categoria', 'area_sector', 'fotografia', 'responsable', 
                'cantidad', 'periodicidad_mantencion', 'reemplazado_por_id', 
                'fecha_baja', 'motivo_baja'
            ]);
        });
    }
};
