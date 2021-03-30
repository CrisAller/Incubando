<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EggsCompanyIdForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eggs', function (Blueprint $table) {            
            $table->unsignedBigInteger('company_id');   
            $table->foreign('company_id')->references('id')->on('companies'); 
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
            $table->dropForeign('eggs_company_id_foreign');
            $table->dropColumn('company_id');
        });
    }
}
