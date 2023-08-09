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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign("user_id")->references('id')->on('users')->onDelete('cascade');
            $table->string('total_amount')->nullable();
            $table->string('amount')->nullable();
            $table->string('monthly_amount')->nullable();
            $table->string('dues')->nullable();
            $table->string('advance')->nullable();
            $table->text('description')->nullable();
            $table->boolean('previous_amount')->default('0')->comment('0:new amount, 1:previous amount')->nullable();
            $table->string('date')->nullable();
            $table->integer('status')->default(0)->comment('0:unpaid, 1:paid ');
            $table->string('slug');
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
        Schema::dropIfExists('payments');
    }
};
