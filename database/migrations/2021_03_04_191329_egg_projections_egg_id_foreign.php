<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EggProjectionsEggIdForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('egg_projections', function (Blueprint $table) {   
            $table->bigInteger('egg_id')->unsigned();
            $table->foreign('egg_id')->references('id')->on('eggs');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('egg_projections', function (Blueprint $table) {
            $table->dropForeign('egg_projections_egg_id_foreign');
            $table->dropColumn('egg_id');
        });
    }
}
