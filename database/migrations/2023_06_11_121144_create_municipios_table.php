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
        Schema::create('municipios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('mini')->nullable();
            $table->integer('parroquias')->nullable()->default(0);
            $table->integer('familias')->nullable()->unsigned()->default(null);
            $table->integer('estatus')->default(1);
            $table->timestamps();
        });

        foreach (dataMunicipiosParroquias()[0] as $municipio){
            DB::table("municipios")
                ->insert([
                    "id" => $municipio['id'],
                    "nombre" => $municipio['nombre'],
                    "mini" => $municipio['mini'],
                    "parroquias" => $municipio['parroquias'],
                    "familias" => $municipio['familias'],
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
        Schema::dropIfExists('municipios');
    }
};
