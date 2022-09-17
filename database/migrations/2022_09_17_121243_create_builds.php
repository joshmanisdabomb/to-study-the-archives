<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuilds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('builds', function (Blueprint $table) {
            $table->id();
            $table->boolean('nightly');
            $table->string('mc_version');
            $table->string('mod_version');
            $table->foreignId('version_id')->nullable()->references('id')->on('versions');
            $table->string('path');
            $table->string('source_path')->nullable();
            $table->integer('run_number')->nullable();
            $table->string('ref_name');
            $table->string('sha')->nullable();
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
        Schema::dropIfExists('builds');
    }
}
