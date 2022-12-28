<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConceptosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conceptos', function (Blueprint $table) {
            $table->id();
            $table->integer('facturas_id');
            $table->string('clave_producto', 8);
            $table->text('descripcion');
            $table->string('nombre_receptor', 255);
            $table->string('rfc_receptor', 32);
            $table->string('regimen_fiscal', 3); 
            $table->string('domicilio_fiscal', 7);
            $table->string('uso_CFDI');
            $table->string('metodo_pago', 3);
            $table->string('forma_pago', 4);
            $table->string('clave_unidad', 3);
            $table->float('cantidad');
            $table->float('valor_unitario');
            $table->float('importe');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conceptos');
    }
}
