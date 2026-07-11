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
        Schema::create('mantencion_repuesto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mantencion_id')->constrained()->onDelete('cascade');
            $table->foreignId('repuesto_id')->constrained()->onDelete('cascade');
            $table->integer('cantidad');
            $table->decimal('precio_total', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantencion_repuesto');
    }
};
