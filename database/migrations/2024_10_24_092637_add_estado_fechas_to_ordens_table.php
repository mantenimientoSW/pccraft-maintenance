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
        Schema::table('ordens', function (Blueprint $table) {
            // Agregar las nuevas columnas para almacenar las fechas de cada estado
            $table->timestamp('fecha_enviado')->nullable()->after('agregada');
            $table->timestamp('fecha_cancelado')->nullable()->after('fecha_enviado');
            $table->timestamp('fecha_entregado')->nullable()->after('fecha_cancelado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordens', function (Blueprint $table) {
            // Eliminar las columnas si se realiza una reversión de la migración
            $table->dropColumn('fecha_enviado');
            $table->dropColumn('fecha_cancelado');
            $table->dropColumn('fecha_entregado');
        });
    }
};
