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
        Schema::create('direccions', function (Blueprint $table) {
            $table->id('ID_Direccion');
            $table->unsignedBigInteger('ID_Usuario');  
            $table->string('ciudad');
            $table->string('codigo_postal');
            $table->string('calle_principal');
            $table->string('cruzamientos')->nullable();
            $table->string('numero_exterior');
            $table->string('numero_interior')->nullable();
            $table->text('detalles')->nullable();
        
            $table->foreign('ID_Usuario')->references('id')->on('users')->onDelete('cascade'); 
        

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direccions');
    }
};
