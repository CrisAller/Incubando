<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEggsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eggs', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->float('weight', 5, 2);
            $table->float('starting_weight', 5, 2)->nullable();
            $table->dateTime('collection_date');
            $table->integer('incubation_day')->unsigned();
            $table->dateTime('starting_date') ->nullable();
            $table->dateTime('pic_date')->nullable();
            $table->dateTime('real_pic_date')->nullable();
            $table->float('weight_pic', 5, 2)->nullable();
            $table->dateTime('misbirth')->nullable();
            $table->dateTime('birth')->nullable();
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
        Schema::dropIfExists('eggs');
    }
}
