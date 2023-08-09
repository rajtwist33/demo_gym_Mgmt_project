<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainerpayments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign("user_id")->references('id')->on('users')->onDelete('cascade');
            $table->string('month')->nullable();
            $table->string('no_shift')->nullable();
            $table->string('present')->nullable();
            $table->string('rate')->nullable();
            $table->string('amount')->nullable();
            $table->string('advance')->nullable();
            $table->string('net_amount')->nullable();
            $table->string('description')->nullable();
            $table->boolean('previous_amount')->default('0')->comment('0:new amount, 1:previous amount')->nullable();
            $table->string('slug')->nullable();
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
        Schema::dropIfExists('trainerpayments');
    }
};
