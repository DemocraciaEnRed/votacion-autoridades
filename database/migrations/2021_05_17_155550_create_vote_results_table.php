<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoteResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vote_results', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('block_id');
            $table->unsignedBigInteger('plate_id');

            $table->integer('votes')->default(0);
            $table->integer('manuals')->default(0);
            $table->integer('no_manuals')->default(0);

            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');
            $table->foreign('plate_id')->references('id')->on('plates')->onDelete('cascade');

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
        Schema::dropIfExists('vote_results');
    }
}
