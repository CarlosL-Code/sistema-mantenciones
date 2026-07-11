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
        Schema::create('ingreso_repuestos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repuesto_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->integer('cantidad')->default(1);
            $table->decimal('costo_unitario', 12, 2)->default(0);
            $table->decimal('costo_total', 12, 2)->default(0);
            $table->date('fecha')->nullable();
            $table->string('numero_factura')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingreso_repuestos');
    }
};
