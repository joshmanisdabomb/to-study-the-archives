<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVersions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('version_groups', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('branch');
            $table->boolean('sources');
            $table->boolean('tags');
            $table->smallInteger('order');
        });

        Schema::create('versions', function (Blueprint $table) {
            $table->id();
            $table->string('mod_version');
            $table->string('mc_version');
            $table->string('code');
            $table->foreignId('group_id')->references('id')->on('version_groups');
            $table->string('title')->nullable();
            $table->text('changelog');
            $table->smallInteger('order');
            $table->timestamp('released_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('versions');
        Schema::dropIfExists('version_groups');
    }
}
