<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('builds', function (Blueprint $table) {
            $table->id();
            $table->boolean('nightly');
            $table->string('repository');
            $table->string('mod_identifier');
            $table->string('mod_version');
            $table->string('mc_version');
            $table->integer('run_number')->nullable();
            $table->string('ref_name');
            $table->string('commit')->unique();
            $table->dateTimeTz('released_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('builds');
    }
};
