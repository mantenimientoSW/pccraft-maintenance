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
        Schema::create('producto__ordens', function (Blueprint $table) {
            $table->id('ID_Producto_Orden');
            $table->unsignedBigInteger('ID_Producto');
            $table->unsignedBigInteger('ID_Orden');
            $table->integer('cantidad');
            $table->decimal('precio', 10, 2); // Añadir la columna 'precio' aquí
            $table->integer('calificacion')->nullable()->default(null)->unsigned()->check('calificacion >= 1 AND calificacion <= 5');
            $table->text('resena')->nullable();
            $table->timestamp('agregado')->useCurrent();

            // Definición de las llaves foráneas
            $table->foreign('ID_Producto')->references('ID_Producto')->on('products')->onDelete('cascade');
            $table->foreign('ID_Orden')->references('ID_Orden')->on('ordens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto__ordens');
    }
};
