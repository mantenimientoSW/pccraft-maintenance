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
        Schema::create('categories', function (Blueprint $table) {
            $table->unsignedBigInteger('ID_Categoria')->autoIncrement();
            $table->string('nombre_categoria');
        });
        DB::table('categories')->insert([
            ['ID_Categoria' => 1, 'nombre_categoria' => 'Procesador'],
            ['ID_Categoria' => 2, 'nombre_categoria' => 'Tarjeta de Video'],
            ['ID_Categoria' => 3, 'nombre_categoria' => 'Tarjeta Madre'],
            ['ID_Categoria' => 4, 'nombre_categoria' => 'Memoría RAM'],
            ['ID_Categoria' => 5, 'nombre_categoria' => 'Disco Duro'],
            ['ID_Categoria' => 6, 'nombre_categoria' => 'Gabinete'],
            ['ID_Categoria' => 7, 'nombre_categoria' => 'Accesorios'],
            ['ID_Categoria' => 8, 'nombre_categoria' => 'Fuente de poder'],
            ['ID_Categoria' => 9, 'nombre_categoria' => 'Enfriamiento'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
