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
        Schema::table('reservas', function (Blueprint $table) {
            $table->time('hora_inicio')->after('data');
            $table->time('hora_fim')->after('hora_inicio');
            $table->dropColumn('hora'); // remove campo antigo
        });
    }
    
    public function down(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->time('hora')->nullable();
            $table->dropColumn(['hora_inicio', 'hora_fim']);
        });
    }
};
