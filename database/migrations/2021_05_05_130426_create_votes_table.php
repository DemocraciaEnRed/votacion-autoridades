<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('state_id')->nullable();

            $table->dateTime('day_start')->nullable();
            $table->dateTime('day_finish')->nullable();
            $table->dateTime('day_close_inscriptions')->nullable();
            $table->boolean('mail_results_sended')->default(0);

            $table->foreign('state_id')->references('id')->on('vote_states')->onDelete('cascade');

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
        Schema::dropIfExists('votes');
    }
}
