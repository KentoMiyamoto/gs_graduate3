<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('men_entry_id');
            $table->string('women_entry_id');  
            $table->integer('men_result')->default(0);
            $table->integer('women_result')->default(0);
            // $table->datetime('returnlimit_time')->default(null);
            $table->integer('men_evaluation')->default(0);
            $table->integer('women_evaluation')->default(0);
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
        Schema::dropIfExists('matches');
    }
}
