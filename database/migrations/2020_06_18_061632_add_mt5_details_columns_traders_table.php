<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMt5DetailsColumnsTradersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('traders', function (Blueprint $table) {
            $table->string('mt5_username')->after('status')->nullable();
            $table->string('mt5_password')->after('mt5_username')->nullable();
            $table->string('subtitle')->after('name')->nullable();
            $table->string('best_trader_image')->after('graph_picture')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('traders', function (Blueprint $table) {
            $table->dropColumn(['mt4_username','mt4_password','subtitle','best_trader_image']);
        });
    }
}
