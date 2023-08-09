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
        Schema::create('user_haspaymenttypes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign("user_id")->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('paymenttype_id');
            $table->foreign("paymenttype_id")->references('id')->on('anual_payments')->onDelete('cascade');
            $table->string('start_date');
            $table->string('end_date');
            $table->boolean('is_active')->default(1)->comment('0:expired, 1:active');
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
        Schema::dropIfExists('user_haspaymenttypes');
    }
};
