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
        Schema::table('producto__ordens', function (Blueprint $table) {
            // Eliminar: calificacion, resena
            $table->dropColumn('calificacion');
            $table->dropColumn('resena');

            // Agregar: FK Review
            $table->unsignedBigInteger('ID_Review')->after('ID_Orden')->nullable();
            $table->foreign('ID_Review')->references('ID_Review')->on('reviews')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('producto__ordens', function (Blueprint $table) {
            // Agregar de vuelta las columnas eliminadas en caso de rollback
            $table->integer('calificacion')->nullable()->default(null)->unsigned()->check('calificacion >= 1 AND calificacion <= 5');
            $table->text('resena')->nullable();

            // Eliminar FK asociada
            $table->dropForeign(['ID_Review']);
            $table->dropColumn('ID_Review');
        });
    }
};
