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
        Schema::create('ajustes_segmentos', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->integer('tipo')->nullable()->default(0);
            $table->timestamps();
        });

        DB::table("ajustes_segmentos")
            ->insert([
                "descripcion" => "Municipios",
                "tipo" => 1,
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ]);

        DB::table("ajustes_segmentos")
            ->insert([
                "descripcion" => "Instituciones",
                "tipo" => 0,
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ]);

        DB::table("ajustes_segmentos")
            ->insert([
                "descripcion" => "Particular",
                "tipo" => 0,
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ]);
        DB::table("ajustes_segmentos")
            ->insert([
                "descripcion" => "Recepción",
                "tipo" => 0,
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ajustes_segmentos');
    }
};
