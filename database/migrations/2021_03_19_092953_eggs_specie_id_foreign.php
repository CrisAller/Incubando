<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EggsSpecieIdForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eggs', function (Blueprint $table) {            
            $table->unsignedBigInteger('specie_id');   
            $table->foreign('specie_id')->references('id')->on('species'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eggs', function (Blueprint $table) {
            $table->dropForeign('eggs_specie_id_foreign');
            $table->dropColumn('specie_id');
        });
    }
}
