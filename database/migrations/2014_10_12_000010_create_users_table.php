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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('pass_name')->nullable();
            $table->string('password')->nullable();
            $table->unsignedBigInteger('role');
            $table->foreign('role')->references('id')->on('roles')->onDelete('cascade')->comment('1:Superadmin, 2:admin , 3:developer , 4:trainer, 5:gymer')->nullable();
            $table->boolean('status')->default(1)->comment('0:inactive, 1:active')->nullable();
            $table->boolean('mode')->default(0)->comment('0:light, 1:dark')->nullable();
            $table->boolean('collapse')->default(0)->comment('0:sidebar_off, 1:sidebar_on')->nullable();
            $table->boolean('expand')->default(0)->comment('0:fullpage_off, 1:fullpage')->nullable();
            $table->string('dumy_join_date')->nullable();   
            $table->string('join_date')->nullable();   
            $table->string('slug')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
