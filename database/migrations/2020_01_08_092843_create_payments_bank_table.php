<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments_bank', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_name');
            $table->string('bank_name');
            $table->integer('account_number');
            $table->string('account_opening');
            $table->integer('rmb');
            $table->integer('ntd');
            $table->integer('hkd');
            $table->integer('usdt');
            $table->integer('jpy');
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
        Schema::dropIfExists('payments_bank');
    }
}
