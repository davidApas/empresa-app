<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ID_Persona'); // Clave foránea
            $table->date('fecha');
            $table->string('tipo_pago'); // 'horas' o 'dia'
            $table->integer('nro_horas')->nullable(); // Puede ser nulo
            $table->decimal('precio_hora', 10, 2)->nullable(); // Puede ser nulo
            $table->integer('dias_trabajados')->nullable(); // Puede ser nulo
            $table->decimal('precio_dia', 10, 2)->nullable(); // Puede ser nulo
            $table->decimal('deuda', 10, 2)->nullable(); // Puede ser nulo
            $table->string('relevo')->nullable(); // Puede ser nulo
            $table->decimal('precio_relevo', 10, 2)->nullable(); // Puede ser nulo
            $table->decimal('total', 10, 2); // Obligatorio, siempre debe guardarse
            $table->timestamps(); // Para created_at y updated_at
            $table->softDeletes(); // Para el SoftDeletes

            // Clave foránea con tabla `personas`
            $table->foreign('ID_Persona')->references('id')->on('personas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagos');
    }
}
