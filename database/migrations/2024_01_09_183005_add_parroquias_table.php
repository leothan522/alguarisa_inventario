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
            $table->integer('familias')->nullable()->unsigned()->default(null)->after('mini');
        });
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
