<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogRollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_rolls', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('roll_id');
            $table->unsignedBigInteger('administrator_id');

            $table->text('action');
            $table->text('previous_name')->nullable();
            $table->text('previous_last_name')->nullable();
            $table->text('previous_dni')->nullable();
            $table->text('name');
            $table->text('last_name');
            $table->text('dni');

            $table->foreign('roll_id')->references('id')->on('rolls')->onDelete('cascade');
            $table->foreign('administrator_id')->references('id')->on('administrators')->onDelete('cascade');

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
        Schema::dropIfExists('log_rolls');
    }
}
