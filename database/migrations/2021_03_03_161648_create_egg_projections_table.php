<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEggProjectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egg_projections', function (Blueprint $table) {
            $table->id();
            $table->float('incubation_day',3,1)->unsigned();
            $table->dateTime('incubation_date');
            $table->float('weight_standard',5,2);
            $table->float('ideal_weight_above',5,2);
            $table->float('ideal_weight_below',5,2);
            $table->float('real_weight',5,2)->nullable();
            $table->timestamp('timestamp_weight')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('egg_projections');
    }
}
