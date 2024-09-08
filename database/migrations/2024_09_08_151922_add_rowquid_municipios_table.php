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
        Schema::table('municipios', function (Blueprint $table) {
            $table->text('rowquid')->nullable()->after('estatus');
        });

        $municipios = \App\Models\Municipio::all();
        foreach ($municipios as $municipio){
            $row = \App\Models\Municipio::find($municipio->id);
            $row->rowquid = generarStringAleatorio(16);
            $row->save();
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('municipios', function (Blueprint $table) {
            //
        });
    }
};
