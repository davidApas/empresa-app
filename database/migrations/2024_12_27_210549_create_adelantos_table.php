<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdelantosTable extends Migration
{
    public function up()
    {
        Schema::create('adelantos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ID_Persona'); // Define la clave foránea
            $table->foreign('ID_Persona')->references('id')->on('personas')->onDelete('cascade');
            $table->dateTime('Fecha');
            $table->decimal('Monto', 10, 2);
            $table->string('Entregado_Por');
            $table->text('Descripcion')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('adelantos');
    }
}
