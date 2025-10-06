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

        Schema::create('sucursales' ,function (BluePrint $table) {
            $table->integer('idSucursal');
            $table->string('nombre');
            $table->primary('idSucursal'); 
            $table->index('nombre');
        }); 

        Schema::create('medicamentos' ,function (BluePrint $table) {
            $table->integer('idMedicamento');
            $table->string('nombre');
            $table->integer('gramaje');
            $table->primary('idMedicamento'); 
            $table->index(['nombre', 'gramaje']);
        }); 

        Schema::create('inventario' ,function (BluePrint $table) {
            $table->integer('idSucursal');
            $table->integer('idMedicamento');
            $table->integer('stockActual');
            $table->integer('stockMinimo');
            $table->integer('stockMaximo');
            $table->primary([ 'idSucursal', 'idMedicamento']); 
            $table->foreign('idSucursal')->references('idSucursal')->on('sucursales')->onDelete('cascade');
            $table->foreign('idMedicamento')->references('idMedicamento')->on('medicamentos')->onDelete('cascade');
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Schema::dropIfExists('recetas');
        Schema::dropIfExists('sucursales');
        Schema::dropIfExists('medicamentos');
        Schema::dropIfExists('inventario');
    }
};
