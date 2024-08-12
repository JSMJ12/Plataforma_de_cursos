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
        Schema::table('registros', function (Blueprint $table) {
            $table->boolean('aprobado')->default(false);
        });
    }

    public function down()
    {
        Schema::table('registros', function (Blueprint $table) {
            $table->dropColumn('aprobado');
        });
    }

};
