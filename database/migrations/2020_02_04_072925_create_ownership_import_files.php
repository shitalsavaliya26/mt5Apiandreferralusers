<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnershipImportFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ownership_import_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file_name');
            $table->string('original_name');
            $table->string('path');
            $table->enum('status',['0','1','2'])->default('0');
            $table->integer('total_count')->default('0');
            $table->integer('complete_count')->default('0');
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
        Schema::dropIfExists('ownership_import_files');
    }
}
