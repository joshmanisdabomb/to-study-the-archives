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
        Schema::create('mod_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mod_id')->references('id')->on('mods');
            $table->string('mod_version');
            $table->string('mc_version');
            $table->string('code');
            $table->string('commit')->nullable()->unique();
            $table->string('title')->nullable();
            $table->text('changelog');
            $table->timestamp('released_at')->nullable();
            $table->timestamps();
            $table->unique(['mod_id', 'mod_version']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mod_versions');
    }
};
