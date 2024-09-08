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
        Schema::table('parroquias', function (Blueprint $table) {
            $table->text('rowquid')->nullable()->after('estatus');
        });

        $parroquias = \App\Models\Parroquia::all();
        foreach ($parroquias as $parroquia){
            $row = \App\Models\Parroquia::find($parroquia->id);
            $row->rowquid = generarStringAleatorio(16);
            $row->save();
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parroquias', function (Blueprint $table) {
            //
        });
    }
};
