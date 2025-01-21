<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasTable extends Migration
{
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id(); 
            $table->string('Nombre');
            $table->string('Apellido');
            $table->string('DNI')->unique();
            $table->string('Telefono');
            $table->string('Domicilio');
            $table->string('Correo_Electronico')->nullable();
            $table->string('Puesto_Trabajo');
            $table->softDeletes();
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('personas');
    }
}
