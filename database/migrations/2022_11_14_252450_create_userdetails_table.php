
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
        Schema::create('userdetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign("user_id")->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('role_id')->nullable();
            $table->foreign("role_id")->references('id')->on('roles')->onDelete('cascade');

            $table->unsignedBigInteger('shift_id')->nullable();
            $table->foreign("shift_id")->references('id')->on('shifts')->onDelete('cascade');

            $table->unsignedBigInteger('reffered_by');
            $table->foreign("reffered_by")->references('id')->on('users')->onDelete("cascade")->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            $table->unsignedBigInteger('blood_type');
            $table->foreign("blood_type")->references('id')->on('bloodtypes')->onDelete("cascade")->nullable();

            $table->string('dob')->nullable();
            $table->string('age')->nullable();

            $table->unsignedBigInteger('gender');
            $table->foreign("gender")->references('id')->on('genders')->onDelete("cascade")->nullable();

            $table->string('weight')->nullable();
            $table->string('height')->nullable();

            $table->string('parent_name')->nullable();
            $table->string('gaurdian_name')->nullable();
            $table->string('gaurdian_number')->nullable();
            $table->string('card_no')->nullable();
            $table->boolean('insurence')->default(0)->nullable();

            $table->string('fee')->nullable();
            $table->string('payment')->nullable();
            $table->string('discount')->nullable();
            $table->string('admission')->nullable();
            $table->string('physical_description')->nullable();
            $table->string('break_notify')->nullable();
            $table->boolean("paid_admission")->default(0)->comment('0:unpaid, 1:paid ')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('userdetails');
    }
};
