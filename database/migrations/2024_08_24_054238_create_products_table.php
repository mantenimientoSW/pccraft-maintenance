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
        Schema::create('products', function (Blueprint $table) {
            $table->id('ID_producto');
            $table->string('nombre');
            $table->string('modelo');
            $table->string('fabricante');
            $table->text('descripcion');
            $table->decimal('precio', 10, 2);
            $table->integer('descuento');
            $table->integer('stock');
            $table->timestamp('fecha_agregada')->useCurrent();
            //Foreign key
            $table->unsignedBigInteger('ID_Categoria');
            $table->foreign('ID_Categoria')->references('ID_Categoria')->on('categories')->onDelete('cascade');

            $table->json('especificacionJSON')->nullable();
            $table->json('url_photo')->nullable();
            $table->integer('vendidos');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
