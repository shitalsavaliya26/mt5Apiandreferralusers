_leadr_un<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sponsor')->unique();
            $table->string('full_name');
            $table->string('user_name')->unique();   ;
            $table->string('email')->unique();
            $table->string('identification_number')->unique();
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->integer('country_id');
            $table->string('role')->default('user');
            $table->string('secure_password');
            $table->string('phone_number');
            $table->integer('fixed_rank')->default(0);
            $table->string('mt4_username')->nullable();
            $table->string('mt4_password')->nullable();
            $table->integer('rank_id')->nullable();
            $table->string('status')->default('active');
            $table->integer('total_capital')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('password_otp')->nullable();
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
}
