<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parroquias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('mini')->nullable();
            $table->bigInteger('municipios_id')->unsigned();
            $table->integer('estatus')->default(1);
            $table->foreign('municipios_id')->references('id')->on('municipios')->cascadeOnDelete();
            $table->timestamps();
        });

        foreach (dataMunicipiosParroquias()[1] as $parroquia) {
            DB::table("parroquias")
                ->insert([
                    "id" => $parroquia['id'],
                    "nombre" => $parroquia['nombre'],
                    "mini" => $parroquia['mini'],
                    "municipios_id" => $parroquia['municipios_id'],
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now(),
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parroquias');
    }
};
