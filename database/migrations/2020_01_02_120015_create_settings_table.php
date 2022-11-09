<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('admin_email');
            $table->string('withdraw_fees');
            $table->string('withdraw_from_day');
            $table->string('withdraw_to_day');
            $table->integer('topup_process_fees');
            $table->integer('allow_first_withdraw');
            $table->integer('minimum_withdraw_amount');
            $table->integer('profit_sharing_commision_l1');
            $table->integer('profit_sharing_commision_l2');
            $table->integer('profit_sharing_commision_l3');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('settings');
    }
}
