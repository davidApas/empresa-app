<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->decimal('deuda', 10, 2)->default(0); // Deuda inicial
            $table->integer('relevo')->default(0)->nullable(); // Número de relevos
            $table->decimal('precio_relevo', 10, 2)->default(0)->nullable(); // Precio por relevo
            $table->decimal('total', 10, 2)->default(0); // Precio por relevo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
